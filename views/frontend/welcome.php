<?php
require __DIR__ . "/messages/message.php";
?>

<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <a href="/" class="logo me-auto"><img src="/views/assets/frontend/images/leave2-logo.png" alt="leave-logo"
                class="img-fluid"></a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link bg-red-500" href="/login">Login</a></li>
                <li><a class="getstarted scrollto" href="/register">Get Started</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>

<section id="hero" class="d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                data-aos="fade-up" data-aos-delay="200">
                <h1>Better Solution For Managing and Applying Leave</h1>
                <h2>Welcome to Leave Management System. Apply and track the progress at your own
                    time.</h2>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="/views/assets/frontend/images/home2.png" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>
</section>

<main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Importance</h2>
            </div>

            <div class="row content">
                <div class="col-lg-6">
                    <p>
                        Ensuring limited paper work saves time and resources. Apply leave wherever you are with
                        user-friendly application.
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-all"></i>Easy and convenient user guide.
                        </li>
                        <li><i class="bi bi-check2-all"></i>User-friendly employee dashboard.</li>
                        <li><i class="bi bi-check2-all"></i>Consistent notifications accross the system.
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <p>
                        Applying atleast 30days before commencement of both Anual and Maternity Leaves is highly
                        encouraged.
                    </p>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
                <p>Leave management system is a software tool that enables employees to request time off and managers
                    or HR staff to approve or deny it.</p>
            </div>

            <div class="faq-list">
                <ul>
                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bi bi-question-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                            data-bs-target="#faq-list-1">What are the key features of a leave management system? <i
                                class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></a>
                        <div id="faq-list-1" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Employees can submit requests for different types of leave (sick leave,
                                vacation, personal days, etc.).
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-question-circle icon-help"></i> <a data-bs-toggle="collapse"
                            data-bs-target="#faq-list-2" class="collapsed"> How does it benefit employees?
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></a>
                        <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                <strong>Ease to Request:</strong> They can easily submit leave requests online,
                                eliminating paperwork and
                                manual processes.</br>
                                <strong>Transparency:</strong> Access to leave balances and status of their requests
                                ensures
                                clarity.</br>
                                <strong>Convenience:</strong> Allows for better planning by viewing team availability on
                                the shared
                                calendar.
                            </p>
                        </div>
                    </li>
                    <li data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-question-circle icon-help"></i> <a data-bs-toggle="collapse"
                            data-bs-target="#faq-list-3" class="collapsed">How does it benefit managers/HR?
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></a>
                        <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                <strong>Efficiency:</strong> Automates the approval process, saving time spent on manual
                                tracking and
                                processing.</br>
                                <strong>Accuracy:</strong> Reduces errors in leave calculations and ensures compliance
                                with company
                                policies.</br>
                                <strong>Visibility:</strong> Offers a comprehensive view of team availability, making it
                                easier to manage
                                workloads and schedules.
                            </p>
                        </div>
                    </li>
                    <li data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-question-circle icon-help"></i> <a data-bs-toggle="collapse"
                            data-bs-target="#faq-list-5" class="collapsed"> Is a leave management system secure?
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></a>
                        <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Yes, these system implement robust security measures to protect employee data, often
                                using encryption, access controls, and secure authentication protocols.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section><!-- End Frequently Asked Questions Section -->
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php require __DIR__ . '/./components/footer.php'; ?>