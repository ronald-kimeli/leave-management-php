
window.addEventListener('DOMContentLoaded', event => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
  
    if (sidebarToggle) {
        let status = false;
        // Uncomment Below to persist sidebar toggle between refreshes
        if (status === 'true') {
            document.body.classList.toggle('sb-sidenav-toggled');
            status = true;
        }else{
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            status = true;
        });
    }
    }

});



