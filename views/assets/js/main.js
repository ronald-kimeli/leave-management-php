$(document).ready(function () {
  // Function to add active class to sidebar link
  function setActiveSidebarLink(currentUrl) {
      // Select all sidebar anchor tags
      $('.sb-sidenav-menu .nav-link').each(function () {
          // Check if the href attribute matches the current URL
          if ($(this).attr('href') === currentUrl) {
              // Add the active class to the matched sidebar link
              $(this).addClass('active');
          } else {
              // Remove active class from other sidebar links
              $(this).removeClass('active');
          }
      });
  }

  // Initial check when the document is ready
  var currentUrl = window.location.pathname;
  setActiveSidebarLink(currentUrl);

  // Listen for changes in the pathname
  $(window).on('popstate', function () {
      var newUrl = window.location.pathname;
      setActiveSidebarLink(newUrl);
  });

  // $('#leaveTypeForm').submit(function (e) {
  //   // Prevent the default form submission
  //   e.preventDefault();
  //
  //   // Get form data
  //   var formData = $(this).serialize();
  //
  //   // Make AJAX POST request
  //   $.ajax({
  //     type: 'POST',
  //     url: $(this).attr('action'),
  //     data: formData,
  //     success: function (response) {
  //       // Handle success response
  //       console.log(response);
  //     },
  //     error: function (xhr, status, error) {
  //       // Handle error response
  //       console.error(xhr.responseText);
  //     }
  //   });
  // });
});




