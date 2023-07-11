<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>

<?php include('message.php'); ?>

<div class="container" id="container">
    <div class="row">
        <div id="mainf">
            <span id="message"></span>
            <div class="welcome text-center promo-title">
                Welcome to Leave Management System
            </div>
        </div>
    </div>
</div>

<!-- TESTIMONIALS-->
<section id="testimonials">
    <div class="container">
        <div class="row">
        <div class="text-center">
                  <h4 class="bold">
                  Customer Review
                  </h4>
            </div>
        </div>
        <div class="row offset-1">
            <div class="col-md-5 testimonials mb-2">
                <p>It is the best responsive Online Leave Management System which you can enjoy.</p>
                <img src="assets/images/user1.jpg" alt="">
                <p class="user-details"><b>Alicia</b><br>Co-founder at xyz</p>
            </div>
            <br >
            <div class="col-md-5 testimonials mb-2">
                <p>It was easy and friendly. I got status of my application within short period</p>
                <img src="assets/images/user2.jpg" alt="">
                <p class="user-details"><b>Rony Ryan</b><br>Managing Director</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer section -->
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-box">
                <img src="assets/images/leave2-logo.png" alt="">
                <p>Best Online Leave Management System. Apply at your own time,anywhere.</p>
            </div>
            <div class="col-md-4 footer-box">
                <p><b>CONTACT US</b></p>
                <p><i class="fa fa-map-marker"></i> Leave Tech Ltd, Kenya.</p>
                <p><i class="fa fa-phone"></i> +254 798298834</p>
                <p><i class="fa fa-envelope"></i> kimeliryans@gmail.com</p>
            </div>
            <div class="col-md-4 footer-box">
                <p><b>Let's talk</b></p>
                <input type="text" class="form-control" placeholder="Your Email">
                <textarea name="message" id="emailmessage" class="form-control" placeholder="Your Email" cols="auto" rows="auto">
                </textarea>
                <button type="button" class="btn btn-primary">Send</button>
            </div>
        </div>
        <hr>
        <p class="copyright">Copyright &copy;<?php echo date("Y"); ?><br>Website Designed By Rony Ryan</p>
    </div>
</section>

<?php
include('includes/footer.php');
?>