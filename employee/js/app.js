var currentUrl = window.location.pathname;

var oldUrl;

var displayHTMLData = (currentUrl) => {
  // Check if the URL being clicked is the same as the currently displayed URL
  if (currentUrl === oldUrl) {
    return;
  }

  $.ajax({
    url: currentUrl,
    type: 'GET',
    beforeSend: () => {
      // setting a timeout
      $('#layoutSidenav_content').html('');
      $('#layoutSidenav_content').append('<div class="spinner-grow text-danger" role="status">\
                                             <span class="visually-hidden">Loading...</span>\
                         </div>');
    },
    complete: () => {
      // setting a timeout
      $('#layoutSidenav_content').remove('<div class="spinner-grow text-danger" role="status">\
      <span class="visually-hidden">Loading...</span>\
      </div>');
      $('#layoutSidenav_content').html('');
      document.getElementById("layoutSidenav_content").innerHTML = '';
    },
    success: function (response) {
      // console.log(response);
      document.getElementById("layoutSidenav_content").innerHTML = '';
      document.getElementById("layoutSidenav_content").innerHTML = response;

      oldUrl = currentUrl;
      window.history.pushState(null, null, currentUrl);
    },
    error: function (error) {
      // Handle error response here
      // console.error(error);
      oldUrl = currentUrl;
      // console.log(error.responseText);
      const response = JSON.parse(error.responseText);
      // console.error(response.message);
      window.history.pushState(null, null, '/');
    }
  });
}

// Define a function to handle link clicks
function handleLinkClick(e) {
  e.preventDefault(); // Prevent the default link behavior

  // Get the href attribute of the clicked link
  var href = $(this).attr('href');

  if (href === "#") {
    return;
  }

  // Load content dynamically based on the href
  displayHTMLData(href);
}

$('body').on('click', 'a', handleLinkClick);