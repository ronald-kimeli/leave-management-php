// $(document).ready(function () {

//   let oldUrl = window.location.pathname;

//   // Function to create spinner container
//   function createSpinnerContainer() {
//     const spinnerContainer = document.createElement('div');
//     spinnerContainer.style.position = 'fixed';
//     spinnerContainer.style.top = '50%';
//     spinnerContainer.style.left = '50%';
//     spinnerContainer.style.transform = 'translate(-50%, -50%)';
//     return spinnerContainer;
//   }

//   // Function to create spinner element
//   function createSpinnerElement(spinnerClass) {
//     const loadingSpinner = document.createElement('div');
//     loadingSpinner.classList.add('spinner-grow', spinnerClass);
//     loadingSpinner.setAttribute('role', 'status');
//     loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
//     return loadingSpinner;
//   }

//   function displayHTMLData(currentUrl, callback) {
//     if (currentUrl === oldUrl) {
//       return;
//     }

//     // Array of spinner classes
//     const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];

//     // Create spinner container
//     const spinnerContainer = createSpinnerContainer();

//     // Loop through each spinner class and create spinner elements
//     spinnerClasses.forEach(spinnerClass => {
//       const loadingSpinner = createSpinnerElement(spinnerClass);
//       spinnerContainer.appendChild(loadingSpinner);
//     });

//     $.ajax({
//       url: currentUrl,
//       type: 'GET',
//       beforeSend: () => {
//         // Show loading spinner
//         $('#main').html('').append(spinnerContainer);
//       },
//       complete: () => {
//         // Remove loading spinner
//         spinnerContainer.remove();
//       },
//       success: function (response) {

//         // Extract #main content from the response and sanitize it
//         const mainContent = $(response).find('#main').html();

//         const sanitizedContent = DOMPurify.sanitize(mainContent);

//         // Update #main content
//         $('#main').html(sanitizedContent);

//         // Extract and update the document title
//         var title = $(response).filter('title').text(); // Extract title from the HTML response
//         document.title = title;

//         // Extract and update the meta description
//         var metaDescription = $(response).filter('meta[name="description"]').attr('content');
//         if (metaDescription) {
//           $('meta[name="description"]').attr('content', metaDescription);
//         }

//         // Update oldUrl but do not push state to history (this will prevent pushing duplicate states)
//         oldUrl = currentUrl;

//         setActiveSidebarLink(currentUrl);

//         // Execute the callback function if provided
//         if (callback && typeof callback === 'function') {
//           callback();
//         }
//       },
//       error: function (error) {
//         // Handle error response
//         console.error("Error:", error);

//         // Redirect to home page on error
//         window.location.href = '/';
//       },
//     });
//   }

//   // Define a function to handle link clicks
//   function handleLinkClick(e) {
//     e.preventDefault(); // Prevent the default link behavior

//     // Get the href attribute of the clicked link
//     var href = $(this).attr('href');

//     if (href === "#") {
//       return;
//     }

//     // Load content dynamically based on the href
//     displayHTMLData(href, (e) => {
//       // Push the new state to the browser history
//       history.pushState(null, null, href);
//     });
//   }

//   // Attach click event handler to all anchor tags
//   $('body').on('click', 'a', handleLinkClick);

//   // Handle popstate event (triggered by back/forward buttons)
//   window.addEventListener('popstate', function (event) {
//     // Get the URL of the popped state
//     var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;

//     // Load the content for the popped URL
//     displayHTMLData(poppedUrl, callback);
//   });


//   function setActiveSidebarLink(currentUrl) {
//     // Select all sidebar anchor tags
//     $('.sb-sidenav-menu .nav-link').each(function () {
//       // Check if the href attribute matches the current URL
//       if ($(this).attr('href') === currentUrl) {
//         // Add the active class to the matched sidebar link
//         $(this).addClass('active');
//       } else {
//         // Remove active class from other sidebar links
//         $(this).removeClass('active');
//       }
//     });
//   }

// });



// $(document).ready(function () {

//   let oldUrl = window.location.pathname;

//   // Function to create spinner container
//   function createSpinnerContainer() {
//     const spinnerContainer = document.createElement('div');
//     spinnerContainer.style.position = 'fixed';
//     spinnerContainer.style.top = '50%';
//     spinnerContainer.style.left = '50%';
//     spinnerContainer.style.transform = 'translate(-50%, -50%)';
//     return spinnerContainer;
//   }

//   // Function to create spinner element
//   function createSpinnerElement(spinnerClass) {
//     const loadingSpinner = document.createElement('div');
//     loadingSpinner.classList.add('spinner-grow', spinnerClass);
//     loadingSpinner.setAttribute('role', 'status');
//     loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
//     return loadingSpinner;
//   }

//   function displayHTMLData(currentUrl, callback) {
//     // if (currentUrl === oldUrl) {
//     //   return;
//     // }

//     // Array of spinner classes
//     const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];

//     // Create spinner container
//     const spinnerContainer = createSpinnerContainer();

//     // Loop through each spinner class and create spinner elements
//     spinnerClasses.forEach(spinnerClass => {
//       const loadingSpinner = createSpinnerElement(spinnerClass);
//       spinnerContainer.appendChild(loadingSpinner);
//     });

//     $.ajax({
//       url: currentUrl,
//       type: 'GET',
//       beforeSend: () => {
//         // Show loading spinner
//         $('#main').html('').append(spinnerContainer);
//       },
//       complete: () => {
//         // Remove loading spinner
//         spinnerContainer.remove();
//       },
//       success: function (response) {
//         // Extract #main content from the response and sanitize it
//         const mainContent = $(response).find('#main').html();
//         const sanitizedContent = DOMPurify.sanitize(mainContent);

//         // Update #main content
//         $('#main').html(sanitizedContent);

//         // Extract and update the document title
//         var title = $(response).filter('title').text(); // Extract title from the HTML response
//         document.title = title;

//         // Extract and update the meta description
//         var metaDescription = $(response).filter('meta[name="description"]').attr('content');
//         if (metaDescription) {
//           $('meta[name="description"]').attr('content', metaDescription);
//         }

//           // Execute any inline scripts in the loaded content
//           $(response).find("script").each(function () {
//             $.globalEval(this.text || this.textContent || this.innerHTML || '');
//         });

//         // Update oldUrl but do not push state to history (this will prevent pushing duplicate states)
//         oldUrl = currentUrl;


//         setActiveSidebarLink(currentUrl);

//         // Execute the callback function if provided
//         if (callback && typeof callback === 'function') {
//           callback();
//         }
//       },
//       error: function (error) {
//         // Handle error response
//         console.error("Error:", error);

//         // Redirect to home page on error
//         window.location.href = '/';
//       },
//     });
//   }

//   // Define a function to handle link clicks
//   function handleLinkClick(e) {
//     e.preventDefault(); // Prevent the default link behavior

//     // Get the href attribute of the clicked link
//     var href = $(this).attr('href');

//     if (href === "#") {
//       return;
//     }

//     // Load content dynamically based on the href
//     displayHTMLData(href, (e) => {
//       // Push the new state to the browser history
//       history.pushState(null, null, href);
//     });
//   }

//   // Attach click event handler to all anchor tags
//   $('body').on('click', 'a', handleLinkClick);

//   // Handle popstate event (triggered by back/forward buttons)
//   window.addEventListener('popstate', function (event) {
//     // Get the URL of the popped state
//     var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;

//     // Load the content for the popped URL
//     displayHTMLData(poppedUrl, callback);
//   });

//   function setActiveSidebarLink(currentUrl) {
//     // Select all sidebar anchor tags
//     $('.sb-sidenav-menu .nav-link').each(function () {
//       // Check if the href attribute matches the current URL
//       if ($(this).attr('href') === currentUrl) {
//         // Add the active class to the matched sidebar link
//         $(this).addClass('active');
//       } else {
//         // Remove active class from other sidebar links
//         $(this).removeClass('active');
//       }
//     });
//   }

// });


// $(document).ready(function () {

//   let oldUrl = window.location.pathname;

//   // Function to create spinner container
//   function createSpinnerContainer() {
//     const spinnerContainer = document.createElement('div');
//     spinnerContainer.style.position = 'fixed';
//     spinnerContainer.style.top = '50%';
//     spinnerContainer.style.left = '50%';
//     spinnerContainer.style.transform = 'translate(-50%, -50%)';
//     return spinnerContainer;
//   }

//   // Function to create spinner element
//   function createSpinnerElement(spinnerClass) {
//     const loadingSpinner = document.createElement('div');
//     loadingSpinner.classList.add('spinner-grow', spinnerClass);
//     loadingSpinner.setAttribute('role', 'status');
//     loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
//     return loadingSpinner;
//   }

//   // Function to update content based on URL
//   function updateContent(url, callback) {
//     // Array of spinner classes
//     const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];

//     // Create spinner container
//     const spinnerContainer = createSpinnerContainer();

//     // Loop through each spinner class and create spinner elements
//     spinnerClasses.forEach(spinnerClass => {
//       const loadingSpinner = createSpinnerElement(spinnerClass);
//       spinnerContainer.appendChild(loadingSpinner);
//     });

//     $.ajax({
//       url: url,
//       type: 'GET',
//       beforeSend: () => {
//         // Show loading spinner
//         $('#main').html('').append(spinnerContainer);
//       },
//       complete: () => {
//         // Remove loading spinner
//         spinnerContainer.remove();
//       },
//       success: function (response) {
//         // Extract #main content from the response and sanitize it
//         const mainContent = $(response).find('#main').html();
//         const sanitizedContent = DOMPurify.sanitize(mainContent);

//         // Update #main content
//         $('#main').html(sanitizedContent);

//         // Extract and update the document title
//         var title = $(response).filter('title').text(); // Extract title from the HTML response
//         document.title = title;

//         // Extract and update the meta description
//         var metaDescription = $(response).filter('meta[name="description"]').attr('content');
//         if (metaDescription) {
//           $('meta[name="description"]').attr('content', metaDescription);
//         }

//         // Execute any inline scripts in the loaded content
//         $(response).find("script").each(function () {
//           $.globalEval(this.text || this.textContent || this.innerHTML || '');
//         });

//         // Update oldUrl without pushing duplicate state
//         oldUrl = url;

//         // Set active link in sidebar
//         setActiveSidebarLink(url);

//         // Execute callback function if provided
//         if (callback && typeof callback === 'function') {
//           callback();
//         }
//       },
//       error: function (error) {
//         // Handle error response
//         console.error("Error:", error);

//         // Redirect to home page on error
//         window.location.href = '/';
//       },
//     });
//   }

//   // Function to set active sidebar link
//   function setActiveSidebarLink(url) {
//     $('.sb-sidenav-menu .nav-link').removeClass('active'); // Remove active class from all links
//     $('.sb-sidenav-menu .nav-link[href="' + url + '"]').addClass('active'); // Add active class to current link
//   }

//   // Function to handle link clicks
//   function handleLinkClick(event) {
//     var href = $(this).attr('href');
//     // Check if the link is a mailto link
//     if (href.startsWith('mailto:')) {
//       // Allow default behavior for mailto links (open email client)
//       return;
//     }

//     event.preventDefault(); // Prevent default link behavior

//     if (href === "#" || href === oldUrl) {
//       return;
//     }

//     updateContent(href, () => {
//       history.pushState({ pageUrl: href }, '', href); // Update URL without reloading page
//     });
//   }

//   // Event listener for clicks on anchor tags
//   $('body').on('click', 'a', handleLinkClick);

//   // Event listener for popstate (back/forward navigation)
//   window.addEventListener('popstate', function (event) {
//     var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;
//     if (poppedUrl !== oldUrl) {
//       updateContent(poppedUrl);
//     }
//   });

//   // Event listener for full page reload or refresh
//   window.addEventListener('load', function () {
//     console.log('Page refreshed or fully loaded');
//     var currentUrl = window.location.pathname;
//     if (currentUrl !== oldUrl) {
//       updateContent(currentUrl);
//     }
//   });

// });


// $(document).ready(function () {

//   let oldUrl = window.location.pathname;

//   // Function to create spinner container
//   function createSpinnerContainer() {
//     const spinnerContainer = document.createElement('div');
//     spinnerContainer.style.position = 'fixed';
//     spinnerContainer.style.top = '50%';
//     spinnerContainer.style.left = '50%';
//     spinnerContainer.style.transform = 'translate(-50%, -50%)';
//     return spinnerContainer;
//   }

//   // Function to create spinner element
//   function createSpinnerElement(spinnerClass) {
//     const loadingSpinner = document.createElement('div');
//     loadingSpinner.classList.add('spinner-grow', spinnerClass);
//     loadingSpinner.setAttribute('role', 'status');
//     loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
//     return loadingSpinner;
//   }

//   // Function to preserve form values
//   function getFormData() {
//     const data = {};
//     $('form').serializeArray().forEach(({ name, value }) => {
//       data[name] = value;
//     });
//     return data;
//   }

//   // Function to restore form values
//   function setFormData(data) {
//     Object.keys(data).forEach(name => {
//       $('form [name="' + name + '"]').val(data[name]);
//     });
//   }

//   // Function to execute any inline scripts in the loaded content
//   function executeInlineScripts(response) {
//     $(response).find('script').each(function() {
//       if (this.src) {
//         // Dynamically load external scripts
//         $.getScript(this.src);
//       } else {
//         $.globalEval(this.text || this.textContent || this.innerHTML || '');
//       }
//     });
//   }

//   // Function to update content based on URL
//   function updateContent(url, callback) {
//     // Array of spinner classes
//     const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];

//     // Save form data before the request
//     const formData = getFormData();

//     // Create spinner container
//     const spinnerContainer = createSpinnerContainer();

//     // Loop through each spinner class and create spinner elements
//     spinnerClasses.forEach(spinnerClass => {
//       const loadingSpinner = createSpinnerElement(spinnerClass);
//       spinnerContainer.appendChild(loadingSpinner);
//     });

//     $.ajax({
//       url: url,
//       type: 'GET',
//       beforeSend: () => {
//         // Show loading spinner
//         $('#main').html('').append(spinnerContainer);
//       },
//       complete: () => {
//         // Remove loading spinner
//         spinnerContainer.remove();
//       },
//       success: function (response) {
//         console.log(response); // Debugging line to check the AJAX response

//         // Extract #main content from the response and sanitize it
//         const mainContent = $(response).find('#main').html();
//         const sanitizedContent = DOMPurify.sanitize(mainContent, { USE_PROFILES: { html: true } });

//         // Save the current scroll position
//         const scrollTop = $(window).scrollTop();

//         // Update #main content
//         $('#main').html(sanitizedContent);

//         // Restore the scroll position
//         $(window).scrollTop(scrollTop);

//         // Extract and update the document title
//         var title = $(response).filter('title').text(); // Extract title from the HTML response
//         document.title = title;

//         // Extract and update the meta description
//         var metaDescription = $(response).filter('meta[name="description"]').attr('content');
//         if (metaDescription) {
//           $('meta[name="description"]').attr('content', metaDescription);
//         }

//         // Execute inline scripts from the response
//         executeInlineScripts(response);

//         // Restore form values
//         setFormData(formData);

//         // Update oldUrl without pushing duplicate state
//         oldUrl = url;

//         // Set active link in sidebar
//         setActiveSidebarLink(url);

//         // Execute callback function if provided
//         if (callback && typeof callback === 'function') {
//           callback();
//         }
//       },
//       error: function (error) {
//         // Handle error response
//         console.error("Error:", error);

//         // Redirect to home page on error
//         window.location.href = '/';
//       },
//     });
//   }

//   // Function to set active sidebar link
//   function setActiveSidebarLink(url) {
//     $('.sb-sidenav-menu .nav-link').removeClass('active'); // Remove active class from all links
//     $('.sb-sidenav-menu .nav-link[href="' + url + '"]').addClass('active'); // Add active class to current link
//   }

//   // Function to handle link clicks
//   function handleLinkClick(event) {
//     var href = $(this).attr('href');
//     // Check if the link is a mailto link
//     if (href.startsWith('mailto:')) {
//       // Allow default behavior for mailto links (open email client)
//       return;
//     }

//     event.preventDefault(); // Prevent default link behavior

//     if (href === "#" || href === oldUrl) {
//       return;
//     }

//     updateContent(href, () => {
//       history.pushState({ pageUrl: href }, '', href); // Update URL without reloading page
//     });
//   }

//   // Event listener for clicks on anchor tags
//   $('body').on('click', 'a', handleLinkClick);

//   // Event listener for popstate (back/forward navigation)
//   window.addEventListener('popstate', function (event) {
//     var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;
//     if (poppedUrl !== oldUrl) {
//       updateContent(poppedUrl);
//     }
//   });

//   // Event listener for full page reload or refresh
//   window.addEventListener('load', function () {

//     console.log('Page refreshed or fully loaded');
//     var currentUrl = window.location.pathname;
//     if (currentUrl !== oldUrl) {
//       updateContent(currentUrl);
//     }
//   });

// });


// $(document).ready(function () {
//   let sessionExpired = false; // Flag to track session state
//   let oldUrl = window.location.pathname;

//   // Function to create an overlay for blocking interactions
//   function createOverlay() {
//     const overlay = document.createElement('div');
//     overlay.id = 'session-expired-overlay';
//     overlay.style.position = 'absolute';
//     overlay.style.top = '0';
//     overlay.style.left = '0';
//     overlay.style.width = '100%';
//     overlay.style.height = '100%';
//     overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
//     overlay.style.zIndex = '9999';
//     overlay.style.display = 'flex';
//     overlay.style.alignItems = 'center';
//     overlay.style.justifyContent = 'center';
//     overlay.style.pointerEvents = 'none'; // Allow clicks to pass through if needed
//     overlay.innerHTML = '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Redirecting...</span></div>';
//     return overlay;
//   }

//   // Function to handle session expiration and apply overlay
//   function handleSessionExpiration() {
//     sessionExpired = true; 
//     // Apply overlay to #main
//     $('#main').css('position', 'relative').append(createOverlay());

//     window.location.href = '/login';

//     // Redirect to login page after a short delay
//     setTimeout(() => {
//       window.location.href = '/login';
//     }, 100); // Short delay to ensure the overlay is visible before redirecting
//   }

//   // Function to check session status
//   function checkSession() {
//     return fetch('/checksession')
//       .then(response => response.json())
//       .then(data => {
//         if (data.session_expired) {
//           handleSessionExpiration(); // Handle session expiration
//           return false; // Session expired
//         }
//         return true; // Session valid
//       });

//   }

//   // Function to create spinner container
//   function createSpinnerContainer() {
//     const spinnerContainer = document.createElement('div');
//     spinnerContainer.style.position = 'fixed';
//     spinnerContainer.style.top = '50%';
//     spinnerContainer.style.left = '50%';
//     spinnerContainer.style.transform = 'translate(-50%, -50%)';
//     return spinnerContainer;
//   }

//   // Function to create spinner element
//   function createSpinnerElement(spinnerClass) {
//     const loadingSpinner = document.createElement('div');
//     loadingSpinner.classList.add('spinner-grow', spinnerClass);
//     loadingSpinner.setAttribute('role', 'status');
//     loadingSpinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
//     return loadingSpinner;
//   }

//   // Function to preserve form values
//   function getFormData() {
//     const data = {};
//     $('form').serializeArray().forEach(({ name, value }) => {
//       data[name] = value;
//     });
//     return data;
//   }

//   // Function to restore form values
//   function setFormData(data) {
//     Object.keys(data).forEach(name => {
//       $('form [name="' + name + '"]').val(data[name]);
//     });
//   }

//   // Function to execute any inline scripts in the loaded content
//   function executeInlineScripts(response) {
//     $(response).find('script').each(function() {
//       if (this.src) {
//         $.getScript(this.src);
//       } else {
//         $.globalEval(this.text || this.textContent || this.innerHTML || '');
//       }
//     });
//   }

//   // Function to update content based on URL
//   function updateContent(url, callback) {
//     const spinnerClasses = ['text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-dark'];

//     const formData = getFormData();
//     const spinnerContainer = createSpinnerContainer();

//     spinnerClasses.forEach(spinnerClass => {
//       const loadingSpinner = createSpinnerElement(spinnerClass);
//       spinnerContainer.appendChild(loadingSpinner);
//     });

//     $.ajax({
//       url: url,
//       type: 'GET',
//       beforeSend: () => {
//         $('#main').html('').append(spinnerContainer);
//       },
//       complete: () => {
//         spinnerContainer.remove();
//       },
//       success: function (response) {

//         const mainContent = $(response).find('#main').html();
//         const sanitizedContent = DOMPurify.sanitize(mainContent, { USE_PROFILES: { html: true } });

//         const scrollTop = $(window).scrollTop();
//         $('#main').html(sanitizedContent);
//         $(window).scrollTop(scrollTop);

//         const title = $(response).filter('title').text();
//         document.title = title;

//         const metaDescription = $(response).filter('meta[name="description"]').attr('content');
//         if (metaDescription) {
//           $('meta[name="description"]').attr('content', metaDescription);
//         }

//         executeInlineScripts(response);
//         setFormData(formData);

//         oldUrl = url;

//         setActiveSidebarLink(url);

//         if (callback && typeof callback === 'function') {
//           callback();
//         }
//       },
//       error: function (error) {
//         console.error("Error:", error);
//         window.location.href = '/';
//       },
//     });
//   }

//   // Function to set active sidebar link
//   function setActiveSidebarLink(url) {
//     $('.sb-sidenav-menu .nav-link').removeClass('active');
//     $('.sb-sidenav-menu .nav-link[href="' + url + '"]').addClass('active');
//   }

//   // Function to handle link clicks
//   function handleLinkClick(event) {
//     var href = $(this).attr('href');
//     if (href.startsWith('mailto:')) {
//       return;
//     }

//     event.preventDefault();

//     if (href === "#" || href === oldUrl) {
//       return;
//     }

//     updateContent(href, () => {
//       history.pushState({ pageUrl: href }, '', href);
//     });
//   }

//   // Event listener for clicks on anchor tags
//   $('body').on('click', 'a', handleLinkClick);

//   // Event listener for popstate (back/forward navigation)
//   window.addEventListener('popstate', function (event) {
//     if (sessionExpired) return; // Prevent further actions if session expired

//     var poppedUrl = event.state ? event.state.pageUrl : window.location.pathname;
//     if (poppedUrl !== oldUrl) {
//       updateContent(poppedUrl);
//     }
//   });

//   // // Event listener for page load
//   // window.addEventListener('load', function () {
//   //   console.log('Page refreshed or fully loaded');
//   //   var currentUrl = window.location.pathname;
//   //   if (currentUrl !== oldUrl) {
//   //     updateContent(currentUrl);
//   //   }
//   // });

//   // Start by checking the session
//   // checkSession().then(sessionValid => {
//   //   if (sessionValid) {
//   //     initializePage(); // Initialize the page if session is valid
//   //   }
//   // });
// });


$(document).ready(function () {
  let sessionExpired = false; // Flag to track session state
  let oldUrl = window.location.pathname;

  // Function to create spinner container
  function createSpinnerContainer() {
    const spinnerContainer = document.createElement('div');
    spinnerContainer.style.position = 'fixed';
    spinnerContainer.style.top = '50%';
    spinnerContainer.style.left = '50%';
    spinnerContainer.style.transform = 'translate(-50%, -50%)';
    spinnerContainer.style.display = 'flex';
    spinnerContainer.style.flexDirection = 'row'; // Align spinners horizontally
    spinnerContainer.style.justifyContent = 'center'; // Center spinners
    spinnerContainer.style.alignItems = 'center'; // Center spinners vertically
    spinnerContainer.style.width = '100vw'; // Full width
    spinnerContainer.style.height = '100vh'; // Full height
    spinnerContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.8)'; // Optional: Add a semi-transparent background
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
        console.log(response);
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


//    // Unbind previous click handlers to avoid multiple bindings
//    $(document).off('click', '.delete');
    
//    // Add event handlers for the delete buttons
//    $(document).on('click', '.delete', function () {
//        var id = $(this).data('id');
//        var url = $(this).data('url') + id; // Construct URL with dynamicTable ID

//        // Store the URL in a data attribute for the confirmation button
//        $('#confirmDeleteButton').data('url', url);

//        // Show the confirmation modal
//        $('#deleteConfirmationModal').modal('show');
//    });

//    // Add event handler for the confirmation button
//    $('#deleteConfirmationModal').off('click', '#confirmDeleteButton'); // Unbind previous handler
//    $('#deleteConfirmationModal').on('click', '#confirmDeleteButton', function () {
//        var url = $(this).data('url'); // Get the URL from the data attribute
//        deleteItem(url); // Call the delete function with the URL
//        $('#deleteConfirmationModal').modal('hide'); // Hide the modal after deletion
//    });

//    // Add event handler for the cancel button
//    $('#deleteConfirmationModal').off('click', '.btn-secondary'); // Unbind previous handler
//    $('#deleteConfirmationModal').on('click', '.btn-secondary', function () {
//        // Hide the modal when cancel is clicked
//        $('#deleteConfirmationModal').modal('hide');
//    });


//    function deleteItem(url) {
//     $.ajax({
//         url: url,
//         method: 'DELETE',
//         success: function (response) {
//             console.log('Server Response:', response); // Log the server response
//             // alert('Item deleted successfully');
//             // fetchData(currentPage); // Refresh the table
//         },
//         error: function (xhr, status, error) {
//             console.error('Error deleting item:', error);
//             console.error('Response:', xhr.responseText); // Log the server response text in case of error
//             alert('Error deleting item. Please try again.');
//         }
//     });
// }


});






