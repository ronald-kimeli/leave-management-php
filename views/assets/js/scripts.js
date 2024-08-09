window.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.querySelector('#sidebarToggle');
    const sidebarLinks = document.querySelectorAll('#sidenavAccordion .nav-link');

    if (sidebarToggle) {
        // Toggle sidebar visibility function
        const toggleSidebar = () => {
            document.body.classList.toggle('sb-sidenav-toggled');
        };

        // Sidebar toggle button click event listener
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            toggleSidebar();
        });

        // Sidebar links click event listeners
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
             // Check if the screen size matches 'sm' or 'xs'
             if (window.matchMedia('(max-width: 576px)').matches || window.matchMedia('(max-width: 768px)').matches) {
                toggleSidebar(); // Close sidebar
            }
            });
        });
    }
});





