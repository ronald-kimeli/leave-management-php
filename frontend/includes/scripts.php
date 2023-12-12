<!-- Smooth Scroll -->
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
<script>
var scroll = new SmoothScroll('a[href*="#"]');

function update_leave_status(leave_id, select_value) {
  window.location.href = '../../admin/display_applyleave?leave_id=' + leave_id + '&type=update&status=' + select_value;
}
</script>

<script src="/frontend/assets/js/jquery.min.js"></script>
<script src="/frontend/assets/js/bootstrap5.bundle.min.js"></script>
<script src="/frontend/assets/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.3/swiper-bundle.min.js"></script>

</body>

</html>