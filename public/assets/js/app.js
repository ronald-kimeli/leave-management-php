$(document).ready(function () {
  let sessionExpired = false;
  let oldUrl = window.location.pathname;

  // Function to create spinner container
  function createSpinnerContainer() {
    const spinnerContainer = document.createElement('div');
    spinnerContainer.style.position = 'fixed';
    spinnerContainer.style.top = '50%';
    spinnerContainer.style.left = '50%';
    spinnerContainer.style.transform = 'translate(-50%, -50%)';
    spinnerContainer.style.display = 'flex';
    spinnerContainer.style.flexDirection = 'row';
    spinnerContainer.style.justifyContent = 'center';
    spinnerContainer.style.alignItems = 'center';
    spinnerContainer.style.width = '100vw';
    spinnerContainer.style.height = '100vh';
    spinnerContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    return spinnerContainer;
  }

  // Function to create spinner element
  function createSpinnerElement(spinnerClass) {
    const loadingSpinner = document.createElement('div');
    loadingSpinner.classList.add('spinner-grow', spinnerClass);
    loadingSpinner.setAttribute('role', 'status');
    loadingSpinner.style.margin = '0 10px'; // Space between spinners
    loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
    return loadingSpinner;
  }

  // Function to execute any inline scripts in the loaded content
  function executeInlineScripts(response) {
    $(response).find('script').each(function () {
      if (this.src) {
        $.getScript(this.src);
      } else {
        $.globalEval(this.text || this.textContent || this.innerHTML || '');
      }
    });
  }

  // Function to update content based on URL
  function updateContent(url, callback) {
    const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];
    const spinnerContainer = createSpinnerContainer();

    spinnerClasses.forEach(spinnerClass => {
      const loadingSpinner = createSpinnerElement(spinnerClass);
      spinnerContainer.appendChild(loadingSpinner);
    });

    $.ajax({
      url: url,
      type: 'GET',
      beforeSend: () => {
        $('#main').html('').append(spinnerContainer);
      },
      complete: () => {
        spinnerContainer.remove();
      },
      success: function (response) {
        const mainContent = $(response).find('#main').html();
        const sanitizedContent = DOMPurify.sanitize(mainContent, { USE_PROFILES: { html: true } });

        const scrollTop = $(window).scrollTop();
        $('#main').html(sanitizedContent);
        $(window).scrollTop(scrollTop);

        const title = $(response).filter('title').text();
        document.title = title;

        const metaDescription = $(response).filter('meta[name="description"]').attr('content');
        if (metaDescription) {
          $('meta[name="description"]').attr('content', metaDescription);
        }

        executeInlineScripts(response);

        oldUrl = url;

        setActiveSidebarLink(url);

        if (callback && typeof callback === 'function') {
          callback();
        }
      },
      error: function (error) {
        // console.error("Error:", error);
        window.location.href = '/';
      },
    });
  }

  // Function to set active sidebar link
  function setActiveSidebarLink(url) {
    $('.sb-sidenav-menu .nav-link').removeClass('active');
    $('.sb-sidenav-menu .nav-link[href="' + url + '"]').addClass('active');
  }

  // Function to handle link clicks
  function handleLinkClick(event) {
    var href = $(this).attr('href');
    if (href.startsWith('mailto:')) {
      return;
    }

    event.preventDefault();

    if (href === "#" || href === oldUrl) {
      return;
    }

    updateContent(href, () => {
      history.pushState({ pageUrl: href }, '', href);
    });
  }

  // Event listener for clicks on anchor tags
  $('body').on('click', 'a', handleLinkClick);

  // Event listener for popstate (back/forward navigation)
  window.addEventListener('popstate', function (event) {
    if (sessionExpired) return; // Prevent further actions if session expired

    var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;
    if (poppedUrl !== oldUrl) {
      updateContent(poppedUrl);
    }
  });


  $('body').on('submit', 'form', function (event) {
    event.preventDefault();
    // Get the alert div
    var alertDiv = $('#alertMessage');
    var form = $(this);
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method') || 'POST',
      data: form.serialize(),
      success: function (response) {
        // console.log(response);
        // Parse the response
        var jsonResponse = JSON.parse(response);
        alertDiv
          .addClass('alert-' + jsonResponse.status)
          .html(jsonResponse.message + ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>')
          .show();

        // Delay content update to allow the alert message to be displayed
        setTimeout(function () {
          alertDiv.hide();
          alertDiv
            .removeClass('alert-' + jsonResponse.status);

          if (jsonResponse.status === 'success' && jsonResponse.redirect) {
            if (!jsonResponse.redirect.includes('admin')) {
              window.location.href = jsonResponse.redirect;
            } else {
              // Update content via AJAX and push state
              updateContent(jsonResponse.redirect, () => {
                history.pushState({ pageUrl: jsonResponse.redirect }, '', jsonResponse.redirect);
              });
            }
          }


        }, 500);
      },
      error: function (error) {
        console.log(error.response);
        // Show error message in the alert div
        var alertDiv = $('#alertMessage');
        alertDiv
          .addClass('alert-error')
          .html('Form submission error. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>')
          .show();

        // Hide the alert after 100 milliseconds
        setTimeout(function () {
          alertDiv.hide();
          alertDiv
            .removeClass('alert-danger');
        }, 500);
      }
    });
  });
});






