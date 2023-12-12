$(document).ready(function () {

  $('#addDepartment').on('submit', function (e) {
    e.preventDefault();

    var formData = {
      dpname: $("#name").val(),
    };

    const fetchPostcodes = (formData) => {
      $.ajax({
        type: "POST",
        url: "/admin/updateu",
        data: formData,
        dataType: "json",
        success: function (response) {
          console.log(response);
          if (!response.success) {
            if (response.errors.name) {
              $("#dpname-group").addClass("has-error");
              $("#dpname-group").append(
                '<div class="help-block">' + response.errors.name + "</div>"
              );
            }
          } else {
            $("form").html(
              '<div class="alert alert-success">' + response.message + "</div>"
            );
          }
        },
        error: function (jqXHR, status, error) {

          console.error(JSON.parse(error));
          // window.history.pushState(null, null, '/');
          $("form").html(
            '<div class="alert alert-danger">Could not reach server, please try again later.</div>'
          );
        }
      });
    }

    fetchPostcodes(formData);

  });
});