<?php

session_start();

$isLoggedIn = isset($_SESSION["user_id"]);
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";

/*
|--------------------------------------------------------------------------
| Dynamic Dashboard Link
|--------------------------------------------------------------------------
*/

if ($isLoggedIn && $role === "patient") {

    $dashboardLink = "patient/dashboard.php";

} elseif ($isLoggedIn && $role === "doctor") {

    $dashboardLink = "doctor/dashboard.php";

} else {

    $dashboardLink = "auth/login.php";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About SmartCare | Smart Digital Healthcare</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- SmartCare CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <style>

        /* =====================================================
           ABOUT HERO
        ===================================================== */

        .about-hero {
            padding: 90px 0 80px;
            background: linear-gradient(
                135deg,
                #eefaff 0%,
                #ffffff 55%,
                #eafaf5 100%
            );
        }

        .about-hero h1 {
            color: #123b52;
            font-size: 52px;
            font-weight: 800;
            line-height: 1.15;
        }

        .about-hero h1 span {
            color: #0d8abc;
        }

        .about-hero p {
            max-width: 720px;
            margin: 20px auto 0;
            color: #687b85;
            font-size: 18px;
            line-height: 1.8;
        }


        /* =====================================================
           ABOUT INTRO
        ===================================================== */

        .about-intro {
            padding: 90px 0;
            background: #ffffff;
        }

        .about-image {
            min-height: 430px;
            border-radius: 30px;
            background: linear-gradient(
                145deg,
                #e7f8fc,
                #f7fffd
            );
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .about-heart {
            width: 190px;
            height: 190px;
            border-radius: 50%;
            background: #0d8abc;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 90px;
            box-shadow: 0 25px 60px rgba(13, 138, 188, 0.25);
        }

        .about-floating {
            position: absolute;
            background: #ffffff;
            padding: 14px 20px;
            border-radius: 14px;
            color: #23485a;
            font-weight: 600;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .about-floating i {
            color: #0d8abc;
        }

        .about-floating.one {
            top: 45px;
            left: 30px;
        }

        .about-floating.two {
            right: 30px;
            bottom: 45px;
        }


        /* =====================================================
           FEATURE CARDS
        ===================================================== */

        .about-feature {
            height: 100%;
            padding: 30px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid #edf2f4;
            box-shadow: 0 10px 35px rgba(13, 138, 188, 0.07);
            transition: 0.25s ease;
        }

        .about-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(13, 138, 188, 0.12);
        }

        .about-feature-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: #e8f8fc;
            color: #0d8abc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .about-feature h5 {
            color: #173f52;
            font-weight: 700;
        }

        .about-feature p {
            color: #71818a;
            line-height: 1.7;
            margin-bottom: 0;
        }


        /* =====================================================
           MISSION
        ===================================================== */

        .mission-section {
            padding: 90px 0;
            background: #f5fbfc;
        }

        .mission-box {
            padding: 55px;
            border-radius: 28px;
            color: #ffffff;
            background: linear-gradient(
                135deg,
                #0d8abc,
                #08749d
            );
            box-shadow: 0 20px 50px rgba(13, 138, 188, 0.18);
        }

        .mission-box h2 {
            font-weight: 800;
            line-height: 1.3;
        }

        .mission-box p {
            color: rgba(255,255,255,.88);
            line-height: 1.8;
        }

        .mission-icon {
            font-size: 110px;
            opacity: 0.9;
        }


        /* =====================================================
           VALUES
        ===================================================== */

        .values-section {
            padding: 90px 0;
            background: #ffffff;
        }

        .value-item {
            display: flex;
            gap: 18px;
            margin-bottom: 30px;
        }

        .value-icon {
            min-width: 52px;
            width: 52px;
            height: 52px;
            border-radius: 15px;
            background: #e9f8f3;
            color: #18a477;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .value-item h6 {
            color: #173f52;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .value-item p {
            color: #74838b;
            line-height: 1.7;
            margin: 0;
        }


        /* =====================================================
           CTA
        ===================================================== */

        .about-cta {
            padding: 90px 0;
            background: #f7fcfd;
        }

        .about-cta h2 {
            color: #123b52;
            font-weight: 800;
        }

        .about-cta p {
            color: #71818a;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {

            .about-hero {
                padding: 65px 0;
            }

            .about-hero h1 {
                font-size: 38px;
            }

            .about-hero p {
                font-size: 16px;
            }

            .about-intro,
            .mission-section,
            .values-section,
            .about-cta {
                padding: 65px 0;
            }

            .about-image {
                min-height: 330px;
            }

            .about-heart {
                width: 145px;
                height: 145px;
                font-size: 65px;
            }

            .mission-box {
                padding: 35px 25px;
            }

            .mission-icon {
                font-size: 80px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<nav class="navbar navbar-expand-lg smart-navbar sticky-top">

    <div class="container">

        <!-- LOGO -->

        <a
            href="index.php"
            class="navbar-brand smart-logo"
        >

            <span class="logo-icon">

                <i class="bi bi-heart-pulse-fill"></i>

            </span>

            Smart<span>Care</span>

        </a>


        <!-- MOBILE TOGGLER -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#smartNavbar"
            aria-controls="smartNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- NAVIGATION -->

        <div
            class="collapse navbar-collapse"
            id="smartNavbar"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">


                <!-- HOME -->

                <li class="nav-item">

                    <a
                        href="index.php"
                        class="nav-link smart-nav-link"
                    >

                        Home

                    </a>

                </li>


                <!-- SERVICES -->

                <li class="nav-item">

                    <a
                        href="index.php#services"
                        class="nav-link smart-nav-link"
                    >

                        Services

                    </a>

                </li>


                <!-- ABOUT -->

                <li class="nav-item">

                    <a
                        href="about.php"
                        class="nav-link smart-nav-link active"
                    >

                        About

                    </a>

                </li>


                <!-- CONTACT -->

                <li class="nav-item">

                    <a
                        href="contact.php"
                        class="nav-link smart-nav-link"
                    >

                        Contact

                    </a>

                </li>


                <?php if ($isLoggedIn): ?>


                    <!-- USER NAME -->

                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                        <span
                            class="nav-link"
                            style="
                                color:#0d8abc;
                                font-weight:600;
                            "
                        >

                            <i class="bi bi-person-circle me-1"></i>

                            Hi,
                            <?php echo htmlspecialchars($name); ?>

                        </span>

                    </li>


                    <!-- DASHBOARD -->

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                        <a
                            href="<?php echo htmlspecialchars($dashboardLink); ?>"
                            class="btn login-btn"
                        >

                            <i class="bi bi-grid-1x2 me-1"></i>

                            Dashboard

                        </a>

                    </li>


                    <!-- LOGOUT -->

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                        <a
                            href="auth/logout.php"
                            class="btn register-btn"
                        >

                            <i class="bi bi-box-arrow-right me-1"></i>

                            Logout

                        </a>

                    </li>


                <?php else: ?>


                    <!-- LOGIN -->

                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                        <a
                            href="auth/login.php"
                            class="btn login-btn"
                        >

                            Login

                        </a>

                    </li>


                    <!-- REGISTER -->

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                        <a
                            href="auth/register.php"
                            class="btn register-btn"
                        >

                            Register

                        </a>

                    </li>


                <?php endif; ?>


            </ul>

        </div>

    </div>

</nav>



<!-- =====================================================
     ABOUT HERO
===================================================== -->

<section class="about-hero text-center">

    <div class="container">

        <div class="section-eyebrow">

            About SmartCare

        </div>


        <h1>

            Healthcare made

            <br>

            <span>
                simple & smarter.
            </span>

        </h1>


        <p>

            SmartCare is a digital healthcare platform designed
            to make healthcare more accessible, convenient and
            organized for patients and healthcare professionals.

        </p>

    </div>

</section>



<!-- =====================================================
     WHO WE ARE
===================================================== -->

<section class="about-intro">

    <div class="container">

        <div class="row align-items-center g-5">


            <!-- VISUAL -->

            <div class="col-lg-6">

                <div class="about-image">


                    <div class="about-floating one">

                        <i class="bi bi-shield-check me-1"></i>

                        Secure Healthcare

                    </div>


                    <div class="about-heart">

                        <i class="bi bi-heart-pulse-fill"></i>

                    </div>


                    <div class="about-floating two">

                        <i class="bi bi-check-circle-fill me-1"></i>

                        Better Care

                    </div>


                </div>

            </div>



            <!-- CONTENT -->

            <div class="col-lg-6">

                <div class="section-eyebrow">

                    Who We Are

                </div>


                <h2 class="section-heading">

                    Connecting people with
                    better healthcare.

                </h2>


                <p class="section-description text-start">

                    SmartCare brings patients, doctors and essential
                    healthcare services together through one
                    easy-to-use digital platform.

                </p>


                <p class="section-description text-start mt-3">

                    From finding doctors and booking appointments
                    to managing health information, SmartCare helps
                    simplify everyday healthcare needs.

                </p>


                <a
                    href="contact.php"
                    class="primary-action mt-3"
                >

                    Contact Us

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     WHAT WE OFFER
===================================================== -->

<section class="services-section section-padding">

    <div class="container">


        <div class="text-center mb-5">

            <div class="section-eyebrow">

                What We Offer

            </div>


            <h2 class="section-heading">

                Designed for Better Healthcare

            </h2>


            <p class="section-description">

                SmartCare combines useful healthcare features
                into one simple and connected experience.

            </p>

        </div>



        <div class="row g-4">


            <!-- FEATURE 1 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-calendar2-check"></i>

                    </div>


                    <h5>

                        Easy Appointments

                    </h5>


                    <p>

                        Find doctors and manage appointments
                        without unnecessary complexity.

                    </p>

                </div>

            </div>



            <!-- FEATURE 2 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-person-badge"></i>

                    </div>


                    <h5>

                        Doctor Discovery

                    </h5>


                    <p>

                        Explore healthcare professionals based
                        on specialization and availability.

                    </p>

                </div>

            </div>



            <!-- FEATURE 3 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-file-earmark-medical"></i>

                    </div>


                    <h5>

                        Health Records

                    </h5>


                    <p>

                        Keep important healthcare information
                        organized and easily accessible.

                    </p>

                </div>

            </div>



            <!-- FEATURE 4 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-robot"></i>

                    </div>


                    <h5>

                        Smart Technology

                    </h5>


                    <p>

                        Use intelligent digital tools to support
                        better healthcare decisions.

                    </p>

                </div>

            </div>



            <!-- FEATURE 5 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-shield-lock"></i>

                    </div>


                    <h5>

                        Privacy Focused

                    </h5>


                    <p>

                        We aim to provide a secure environment
                        for managing healthcare information.

                    </p>

                </div>

            </div>



            <!-- FEATURE 6 -->

            <div class="col-md-6 col-lg-4">

                <div class="about-feature">

                    <div class="about-feature-icon">

                        <i class="bi bi-phone"></i>

                    </div>


                    <h5>

                        Access Anywhere

                    </h5>


                    <p>

                        Access SmartCare from your phone,
                        tablet or computer.

                    </p>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     OUR MISSION
===================================================== -->

<section class="mission-section">

    <div class="container">

        <div class="mission-box">

            <div class="row align-items-center g-4">


                <div class="col-lg-8">

                    <div class="ai-badge bg-white text-primary">

                        <i class="bi bi-stars"></i>

                        Our Mission

                    </div>


                    <h2 class="mt-3">

                        Making healthcare accessible,
                        convenient and connected.

                    </h2>


                    <p class="mt-3 mb-0">

                        Our mission is to use technology to reduce
                        unnecessary complexity in healthcare and
                        help patients connect with the right
                        healthcare resources more easily.

                    </p>

                </div>


                <div class="col-lg-4 text-center">

                    <i
                        class="bi bi-heart-pulse-fill mission-icon"
                    ></i>

                </div>


            </div>

        </div>

    </div>

</section>



<!-- =====================================================
     CORE VALUES
===================================================== -->

<section class="values-section">

    <div class="container">


        <div class="text-center mb-5">

            <div class="section-eyebrow">

                What We Believe

            </div>


            <h2 class="section-heading">

                Our Core Values

            </h2>


            <p class="section-description">

                The principles that guide the SmartCare
                healthcare experience.

            </p>

        </div>



        <div class="row g-5">


            <!-- VALUE 1 -->

            <div class="col-lg-6">

                <div class="value-item">

                    <div class="value-icon">

                        <i class="bi bi-person-heart"></i>

                    </div>


                    <div>

                        <h6>

                            Patient First

                        </h6>


                        <p>

                            We design our platform around the
                            needs, convenience and experience
                            of patients.

                        </p>

                    </div>

                </div>


                <div class="value-item">

                    <div class="value-icon">

                        <i class="bi bi-shield-lock"></i>

                    </div>


                    <div>

                        <h6>

                            Privacy & Security

                        </h6>


                        <p>

                            Healthcare information should be
                            handled carefully and responsibly.

                        </p>

                    </div>

                </div>

            </div>



            <!-- VALUE 2 -->

            <div class="col-lg-6">

                <div class="value-item">

                    <div class="value-icon">

                        <i class="bi bi-stars"></i>

                    </div>


                    <div>

                        <h6>

                            Innovation

                        </h6>


                        <p>

                            We use modern technology to create
                            useful and meaningful healthcare tools.

                        </p>

                    </div>

                </div>


                <div class="value-item">

                    <div class="value-icon">

                        <i class="bi bi-hand-thumbs-up"></i>

                    </div>


                    <div>

                        <h6>

                            Simplicity

                        </h6>


                        <p>

                            Healthcare technology should be
                            simple, clear and easy to use.

                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     FINAL CTA
===================================================== -->

<section class="about-cta text-center">

    <div class="container">


        <div class="section-eyebrow">

            Start Your Journey

        </div>


        <h2 class="mt-2">

            Experience smarter healthcare today.

        </h2>


        <p class="mt-3">

            Join SmartCare and make managing your healthcare
            simpler and more convenient.

        </p>


        <a
            href="<?php echo $isLoggedIn
                ? htmlspecialchars($dashboardLink)
                : 'auth/register.php'; ?>"
            class="primary-action mt-3"
        >

            <?php

            echo $isLoggedIn
                ? "Go to Dashboard"
                : "Get Started";

            ?>

            <i class="bi bi-arrow-right"></i>

        </a>

    </div>

</section>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="smart-footer">

    <div class="container">


        <div class="row g-5">


            <!-- BRAND -->

            <div class="col-lg-5">

                <div class="footer-logo">

                    <i class="bi bi-heart-pulse-fill"></i>

                    Smart<span>Care</span>

                </div>


                <p class="mt-3">

                    A smarter digital healthcare platform
                    connecting patients with better care.

                </p>

            </div>



            <!-- QUICK LINKS -->

            <div class="col-6 col-lg-3">

                <h6>

                    Quick Links

                </h6>


                <a
                    href="index.php"
                    class="footer-link"
                >

                    Home

                </a>


                <a
                    href="index.php#services"
                    class="footer-link"
                >

                    Services

                </a>


                <a
                    href="about.php"
                    class="footer-link"
                >

                    About

                </a>


                <a
                    href="contact.php"
                    class="footer-link"
                >

                    Contact

                </a>

            </div>



            <!-- ACCOUNT -->

            <div class="col-6 col-lg-4">

                <h6>

                    Account

                </h6>


                <?php if ($isLoggedIn): ?>


                    <a
                        href="<?php echo htmlspecialchars($dashboardLink); ?>"
                        class="footer-link"
                    >

                        Dashboard

                    </a>


                    <a
                        href="auth/logout.php"
                        class="footer-link"
                    >

                        Logout

                    </a>


                <?php else: ?>


                    <a
                        href="auth/login.php"
                        class="footer-link"
                    >

                        Login

                    </a>


                    <a
                        href="auth/register.php"
                        class="footer-link"
                    >

                        Register

                    </a>


                <?php endif; ?>


                <a
                    href="contact.php"
                    class="footer-link"
                >

                    Contact Support

                </a>


                <p class="mt-3">

                    <i class="bi bi-envelope me-2"></i>

                    support@smartcare.com

                </p>

            </div>


        </div>



        <div class="footer-bottom">

            © 2026 SmartCare. All rights reserved.

        </div>


    </div>

</footer>



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>
