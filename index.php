<?php

session_start();

/* =====================================================
   LOGIN / SESSION
===================================================== */

$isLoggedIn = isset($_SESSION["user_id"]);

$role = $_SESSION["role"] ?? "";

$name = $_SESSION["name"] ?? "";


/* =====================================================
   DYNAMIC LINKS
===================================================== */

if ($isLoggedIn && $role === "patient") {

    $dashboardLink = "patient/dashboard.php";

    $appointmentLink = "patient/book-appointment.php";

} elseif ($isLoggedIn && $role === "doctor") {

    $dashboardLink = "doctor/dashboard.php";

    $appointmentLink = "doctor/dashboard.php";

} else {

    $dashboardLink = "auth/login.php";

    $appointmentLink = "auth/login.php";

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        SmartCare | Your Health, Our Priority
    </title>


    <!-- =================================================
         BOOTSTRAP
    ================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =================================================
         BOOTSTRAP ICONS
    ================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- =================================================
         SMARTCARE CSS
    ================================================== -->

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >


    <!-- =================================================
         EMERGENCY CALL POPUP CSS
    ================================================== -->

    <style>

        .call-modal-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0, 0, 0, 0.55);

            z-index: 9999;

            align-items: center;

            justify-content: center;

            padding: 20px;

        }


        .call-modal {

            width: 100%;

            max-width: 420px;

            background: #ffffff;

            border-radius: 20px;

            padding: 30px;

            text-align: center;

            box-shadow:
                0 15px 45px rgba(0, 0, 0, 0.25);

            animation: emergencyPopup 0.2s ease-out;

        }


        @keyframes emergencyPopup {

            from {

                opacity: 0;

                transform: scale(0.92);

            }

            to {

                opacity: 1;

                transform: scale(1);

            }

        }


        .call-modal-icon {

            width: 70px;

            height: 70px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #fde8e8;

            color: #dc3545;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 30px;

        }


        .call-modal h3 {

            margin-bottom: 10px;

            font-weight: 700;

            color: #222;

        }


        .call-modal p {

            color: #666;

            margin-bottom: 22px;

            line-height: 1.5;

        }


        .call-modal-actions {

            display: flex;

            gap: 10px;

            justify-content: center;

        }


        .call-modal-btn {

            border: none;

            border-radius: 8px;

            padding: 11px 20px;

            font-weight: 600;

            cursor: pointer;

            min-width: 120px;

        }


        .call-cancel-btn {

            background: #e9ecef;

            color: #333;

        }


        .call-confirm-btn {

            background: #dc3545;

            color: #ffffff;

            text-decoration: none;

        }


        .call-confirm-btn:hover {

            background: #bb2d3b;

            color: #ffffff;

        }


        @media (max-width: 500px) {

            .call-modal {

                padding: 25px 20px;

            }


            .call-modal-actions {

                flex-direction: column;

            }


            .call-modal-btn {

                width: 100%;

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
                        class="nav-link smart-nav-link active"
                    >
                        Home
                    </a>

                </li>


                <!-- SERVICES -->

                <li class="nav-item">

                    <a
                        href="#services"
                        class="nav-link smart-nav-link"
                    >
                        Services
                    </a>

                </li>


                <!-- ABOUT -->

                <li class="nav-item">

                    <a
                        href="about.php"
                        class="nav-link smart-nav-link"
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


                    <!-- USER -->

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
                            <?php
                            echo htmlspecialchars($name);
                            ?>

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
     HERO
===================================================== -->

<section class="hero-modern">

    <div class="container">

        <div class="row align-items-center">


            <!-- LEFT -->

            <div class="col-lg-7">

                <div class="hero-content">


                    <div class="hero-label">

                        <i class="bi bi-shield-check"></i>

                        Trusted Digital Healthcare

                    </div>


                    <h1>

                        Better Healthcare.
                        <br>

                        <span class="highlight">
                            Smarter Care.
                        </span>

                    </h1>


                    <p class="hero-description">

                        Connect with trusted doctors, book appointments,
                        manage your health records and access intelligent
                        healthcare services — all from one simple platform.

                    </p>


                    <div class="hero-actions">


                        <!-- GET STARTED -->

                        <a
                            href="<?php echo $isLoggedIn
                                ? htmlspecialchars($dashboardLink)
                                : 'auth/register.php'; ?>"
                            class="primary-action"
                        >

                            <?php

                            echo $isLoggedIn
                                ? "Go to Dashboard"
                                : "Get Started";

                            ?>

                            <i class="bi bi-arrow-right"></i>

                        </a>


                        <!-- BOOK APPOINTMENT -->

                        <a
                            href="<?php echo htmlspecialchars($appointmentLink); ?>"
                            class="secondary-action"
                        >

                            <i class="bi bi-calendar-check"></i>

                            Book Appointment

                        </a>


                    </div>


                    <div class="hero-trust">


                        <div class="trust-item">

                            <i class="bi bi-check-circle-fill"></i>

                            Trusted Doctors

                        </div>


                        <div class="trust-item">

                            <i class="bi bi-check-circle-fill"></i>

                            Secure Records

                        </div>


                        <div class="trust-item">

                            <i class="bi bi-check-circle-fill"></i>

                            Easy Access

                        </div>


                    </div>


                </div>

            </div>


            <!-- RIGHT -->

            <div class="col-lg-5">

                <div class="hero-visual">


                    <div class="availability-card">

                        <span class="online-dot"></span>

                        <div>

                            <strong>
                                Doctors Online
                            </strong>

                            <small>
                                Available now
                            </small>

                        </div>

                    </div>


                    <div class="doctor-card">

                        <div class="doctor-shape">

                            <i class="bi bi-person-badge-fill"></i>

                        </div>


                        <div class="doctor-body">

                            <i class="bi bi-heart-pulse-fill"></i>

                        </div>

                    </div>


                    <div class="appointment-floating">

                        <span class="mini-icon">

                            <i class="bi bi-calendar-check"></i>

                        </span>

                        <strong>
                            Easy Appointments
                        </strong>

                        <small>
                            Book in a few clicks
                        </small>

                    </div>


                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     STATS
===================================================== -->

<section class="stats-section">

    <div class="container">

        <div class="row">


            <div class="col-6 col-md-3">

                <div class="stat-box">

                    <div class="stat-number">
                        24/7
                    </div>

                    <div class="stat-label">
                        Healthcare Access
                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="stat-box">

                    <div class="stat-number">
                        Easy
                    </div>

                    <div class="stat-label">
                        Appointment Booking
                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="stat-box">

                    <div class="stat-number">
                        Secure
                    </div>

                    <div class="stat-label">
                        Health Records
                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="stat-box">

                    <div class="stat-number">
                        Smart
                    </div>

                    <div class="stat-label">
                        Healthcare Solutions
                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     SERVICES
===================================================== -->

<section
    id="services"
    class="services-section section-padding"
>

    <div class="container">


        <div class="text-center mb-5">

            <div class="section-eyebrow">
                Our Services
            </div>

            <h2 class="section-heading">
                Everything You Need for Better Healthcare
            </h2>

            <p class="section-description">

                SmartCare brings essential healthcare services
                together in one convenient platform.

            </p>

        </div>


        <div class="row g-4">


            <!-- APPOINTMENT -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-calendar2-check"></i>

                    </div>

                    <h5>
                        Doctor Appointments
                    </h5>

                    <p>

                        Find doctors and book appointments
                        according to your preferred schedule.

                    </p>

                </div>

            </div>


            <!-- DOCTORS -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-person-badge"></i>

                    </div>

                    <h5>
                        Find Doctors
                    </h5>

                    <p>

                        Explore doctors based on their
                        specialization and availability.

                    </p>

                </div>

            </div>


            <!-- RECORDS -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-file-earmark-medical"></i>

                    </div>

                    <h5>
                        Health Records
                    </h5>

                    <p>

                        Keep your important healthcare
                        information organized in one place.

                    </p>

                </div>

            </div>


            <!-- AI -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-robot"></i>

                    </div>

                    <h5>
                        AI Symptom Checker
                    </h5>

                    <p>

                        Get preliminary health guidance
                        based on your reported symptoms.

                    </p>

                </div>

            </div>


            <!-- HOSPITALS -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-geo-alt"></i>

                    </div>

                    <h5>
                        Nearby Hospitals
                    </h5>

                    <p>

                        Discover healthcare facilities
                        available around your location.

                    </p>

                </div>

            </div>


            <!-- EMERGENCY -->

            <div class="col-md-6 col-lg-4">

                <div class="service-card-modern">

                    <div class="service-icon-modern">

                        <i class="bi bi-telephone-forward"></i>

                    </div>

                    <h5>
                        Emergency Support
                    </h5>

                    <p>

                        Quickly access emergency healthcare
                        resources whenever required.

                    </p>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     WHY SMARTCARE
===================================================== -->

<section class="why-modern section-padding">

    <div class="container">

        <div class="row align-items-center g-5">


            <!-- VISUAL -->

            <div class="col-lg-6">

                <div class="why-visual">


                    <div class="why-floating one">

                        <i class="bi bi-shield-check text-success me-1"></i>

                        Secure Healthcare

                    </div>


                    <div class="why-circle">

                        <i class="bi bi-heart-pulse-fill"></i>

                    </div>


                    <div class="why-floating two">

                        <i class="bi bi-check-circle-fill text-success me-1"></i>

                        Better Care

                    </div>


                </div>

            </div>


            <!-- CONTENT -->

            <div class="col-lg-6">


                <div class="section-eyebrow">
                    Why SmartCare
                </div>


                <h2 class="section-heading">

                    Healthcare designed
                    around you.

                </h2>


                <p class="section-description text-start">

                    We bring patients, doctors and healthcare
                    services together through one easy-to-use
                    digital platform.

                </p>


                <div class="mt-4">


                    <div class="why-item">

                        <div class="why-check">

                            <i class="bi bi-clock"></i>

                        </div>


                        <div>

                            <h6>
                                Save Your Time
                            </h6>

                            <p>
                                Book appointments without
                                unnecessary waiting.
                            </p>

                        </div>

                    </div>


                    <div class="why-item">

                        <div class="why-check">

                            <i class="bi bi-shield-lock"></i>

                        </div>


                        <div>

                            <h6>
                                Secure Information
                            </h6>

                            <p>
                                Keep your health information
                                organized and protected.
                            </p>

                        </div>

                    </div>


                    <div class="why-item">

                        <div class="why-check">

                            <i class="bi bi-phone"></i>

                        </div>


                        <div>

                            <h6>
                                Access Anywhere
                            </h6>

                            <p>
                                Use SmartCare from your phone,
                                tablet or computer.
                            </p>

                        </div>

                    </div>


                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     AI FEATURE
===================================================== -->

<section class="ai-section">

    <div class="container">

        <div class="row align-items-center">


            <div class="col-lg-8">


                <span class="ai-badge">

                    <i class="bi bi-stars"></i>

                    SmartCare AI

                </span>


                <h2>
                    Not sure what your symptoms mean?
                </h2>


                <p class="mt-3 mb-0">

                    Our AI-powered symptom checker can provide
                    preliminary guidance and help you understand
                    when professional medical attention may be needed.

                </p>


                <a
                    href="symptom-checker.php"
                    class="ai-button"
                >

                    Try Symptom Checker

                    <i class="bi bi-arrow-right"></i>

                </a>


            </div>


            <div class="col-lg-4">

                <div class="ai-visual">

                    <div class="ai-circle">

                        <i class="bi bi-robot"></i>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     EMERGENCY
===================================================== -->

<section class="emergency-section">

    <div class="container">

        <div class="emergency-box">


            <div class="d-flex align-items-center gap-3">


                <div class="emergency-icon">

                    <i class="bi bi-telephone-fill"></i>

                </div>


                <div>

                    <h6>
                        Need Emergency Assistance?
                    </h6>

                    <p>

                        Use Emergency to share your location
                        with SmartCare or call 112 directly.

                    </p>

                </div>


            </div>


            <!-- =================================================
                 NEW DIRECT 112 CALL BUTTON
            ================================================== -->

            <button
                type="button"
                class="emergency-btn"
                id="emergencyCallBtn"
                style="
                    margin-left:10px;
                    background:#dc3545;
                    color:#ffffff;
                "
            >

                <i class="bi bi-telephone-fill me-1"></i>

                Emergency Call: 112

            </button>


            <!-- =================================================
                 LOCATION PREVIEW
            ================================================== -->

            <div
                id="locationPreview"
                style="
                    display:none;
                    width:100%;
                    margin-top:20px;
                "
            >

                <div
                    style="
                        background:#ffffff;
                        border-radius:16px;
                        padding:16px;
                        box-shadow:0 5px 20px rgba(0,0,0,0.08);
                    "
                >

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            margin-bottom:12px;
                        "
                    >

                        <i
                            class="bi bi-geo-alt-fill"
                            style="
                                color:#dc3545;
                                font-size:22px;
                            "
                        ></i>

                        <strong>
                            Your Current Location
                        </strong>

                    </div>


                    <!-- MAP -->

                    <div
                        id="locationMap"
                        style="
                            width:100%;
                            height:300px;
                            border-radius:12px;
                            overflow:hidden;
                            background:#f1f3f5;
                        "
                    ></div>


                    <!-- COORDINATES -->

                    <p
                        id="locationCoordinates"
                        style="
                            margin:12px 0 0;
                            font-size:14px;
                            color:#666;
                        "
                    ></p>


                    <!-- OPEN MAP -->

                    <a
                        id="openMapButton"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="
                            display:inline-block;
                            margin-top:10px;
                            color:#0d8abc;
                            font-weight:600;
                            text-decoration:none;
                        "
                    >

                        <i class="bi bi-map me-1"></i>

                        Open in Map

                    </a>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     112 CALL CONFIRMATION POPUP
===================================================== -->

<div
    id="callModalOverlay"
    class="call-modal-overlay"
>

    <div
        class="call-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="callModalTitle"
    >

        <div class="call-modal-icon">

            <i class="bi bi-telephone-fill"></i>

        </div>


        <h3 id="callModalTitle">
            Call Emergency Services?
        </h3>


        <p>

            You are about to call the emergency number
            <strong>112</strong>.

            <br>

            Continue only if you need emergency assistance.

        </p>


        <div class="call-modal-actions">


            <!-- CANCEL -->

            <button
                type="button"
                id="cancelCallBtn"
                class="call-modal-btn call-cancel-btn"
            >

                Cancel

            </button>


            <!-- CALL 112 -->

            <a
                href="tel:112"
                id="confirmCallBtn"
                class="call-modal-btn call-confirm-btn"
            >

                <i class="bi bi-telephone-fill me-1"></i>

                Call 112

            </a>


        </div>

    </div>

</div>



<!-- =====================================================
     FINAL CTA
===================================================== -->

<section class="final-cta text-center">

    <div class="container">


        <div class="section-eyebrow">
            Get Started Today
        </div>


        <h2 class="mt-2">

            Your health deserves
            smarter care.

        </h2>


        <p>

            <?php if ($isLoggedIn): ?>

                Welcome back!
                Continue managing your healthcare with SmartCare.

            <?php else: ?>

                Create your SmartCare account and take
                the first step towards simpler healthcare.

            <?php endif; ?>

        </p>


        <a
            href="<?php echo $isLoggedIn
                ? htmlspecialchars($dashboardLink)
                : 'auth/register.php'; ?>"
            class="primary-action"
        >

            <?php

            echo $isLoggedIn
                ? "Go to Dashboard"
                : "Create Your Account";

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
                    href="#services"
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



<!-- =====================================================
     BOOTSTRAP JS
===================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>



<!-- =====================================================
     EXISTING EMERGENCY LOCATION JAVASCRIPT
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        const emergencyBtn =
            document.getElementById(
                "emergencyBtn"
            );


        const locationPreview =
            document.getElementById(
                "locationPreview"
            );


        const locationMap =
            document.getElementById(
                "locationMap"
            );


        const locationCoordinates =
            document.getElementById(
                "locationCoordinates"
            );


        const openMapButton =
            document.getElementById(
                "openMapButton"
            );


        if (!emergencyBtn) {

            console.log(
                "Emergency button not found."
            );

            return;

        }


        /* =================================================
           EXISTING EMERGENCY BUTTON CLICK
        ================================================= */

        emergencyBtn.addEventListener(
            "click",
            function () {


                const button = this;


                button.disabled = true;


                button.innerHTML =
                    '<i class="bi bi-hourglass-split"></i> Getting Location...';


                /* =========================================
                   CHECK GEOLOCATION
                ========================================= */

                if (
                    !navigator.geolocation
                ) {

                    alert(
                        "Location services are not supported by this browser."
                    );


                    button.disabled = false;


                    button.innerHTML =
                        '<i class="bi bi-telephone me-1"></i> Emergency';


                    return;

                }


                /* =========================================
                   GET CURRENT LOCATION
                ========================================= */

                navigator.geolocation.getCurrentPosition(

                    function (position) {


                        const latitude =
                            position.coords.latitude;


                        const longitude =
                            position.coords.longitude;


                        console.log(
                            "Latitude:",
                            latitude
                        );


                        console.log(
                            "Longitude:",
                            longitude
                        );


                        /* =================================
                           SHOW LOCATION
                        ================================= */

                        showLocation(
                            latitude,
                            longitude
                        );


                        /* =================================
                           SAVE EMERGENCY
                        ================================= */

                        saveEmergency(
                            latitude,
                            longitude
                        );

                    },


                    function (error) {


                        console.error(
                            "Location error:",
                            error
                        );


                        let message =
                            "Unable to get your location.";


                        if (
                            error.code === 1
                        ) {

                            message =
                                "Location permission was denied. Please allow location access and try again.";

                        }


                        else if (
                            error.code === 2
                        ) {

                            message =
                                "Your location is currently unavailable. Please try again.";

                        }


                        else if (
                            error.code === 3
                        ) {

                            message =
                                "Location request timed out. Please try again.";

                        }


                        alert(message);


                        button.disabled = false;


                        button.innerHTML =
                            '<i class="bi bi-telephone me-1"></i> Emergency';

                    },


                    {
                        enableHighAccuracy: true,

                        timeout: 15000,

                        maximumAge: 0
                    }

                );


                /* =================================================
                   SHOW LOCATION
                ================================================= */

                function showLocation(
                    latitude,
                    longitude
                ) {


                    if (!locationPreview) {
                        return;
                    }


                    locationPreview.style.display =
                        "block";


                    /* =========================================
                       COORDINATES
                    ========================================= */

                    if (
                        locationCoordinates
                    ) {

                        locationCoordinates.innerHTML =

                            "<strong>Latitude:</strong> " +
                            latitude.toFixed(6) +

                            " &nbsp; | &nbsp; " +

                            "<strong>Longitude:</strong> " +
                            longitude.toFixed(6);

                    }


                    /* =========================================
                       OPENSTREETMAP URL
                    ========================================= */

                    const mapUrl =

                        "https://www.openstreetmap.org/" +
                        "?mlat=" +
                        encodeURIComponent(latitude) +
                        "&mlon=" +
                        encodeURIComponent(longitude) +
                        "#map=16/" +
                        encodeURIComponent(latitude) +
                        "/" +
                        encodeURIComponent(longitude);


                    /* =========================================
                       EMBED MAP
                    ========================================= */

                    const bboxSize =
                        0.005;


                    const left =
                        longitude - bboxSize;


                    const right =
                        longitude + bboxSize;


                    const bottom =
                        latitude - bboxSize;


                    const top =
                        latitude + bboxSize;


                    const embedUrl =

                        "https://www.openstreetmap.org/export/embed.html" +

                        "?bbox=" +

                        encodeURIComponent(left) +

                        "%2C" +

                        encodeURIComponent(bottom) +

                        "%2C" +

                        encodeURIComponent(right) +

                        "%2C" +

                        encodeURIComponent(top) +

                        "&layer=mapnik" +

                        "&marker=" +

                        encodeURIComponent(latitude) +

                        "%2C" +

                        encodeURIComponent(longitude);


                    if (locationMap) {

                        locationMap.innerHTML =

                            '<iframe ' +

                            'src="' +
                            embedUrl +
                            '" ' +

                            'style="' +
                            'width:100%;' +
                            'height:100%;' +
                            'border:0;' +
                            '" ' +

                            'loading="lazy" ' +

                            'title="Your Current Location">' +

                            '</iframe>';

                    }


                    /* =========================================
                       OPEN MAP BUTTON
                    ========================================= */

                    if (
                        openMapButton
                    ) {

                        openMapButton.href =
                            mapUrl;

                    }


                    /* =========================================
                       SCROLL TO LOCATION
                    ========================================= */

                    setTimeout(
                        function () {

                            locationPreview.scrollIntoView({
                                behavior: "smooth",
                                block: "center"
                            });

                        },
                        300
                    );

                }


                /* =================================================
                   SAVE EMERGENCY
               


        /* =====================================================
           112 CALL CONFIRMATION
        ===================================================== */

        const emergencyCallBtn =
            document.getElementById(
                "emergencyCallBtn"
            );


        const callModalOverlay =
            document.getElementById(
                "callModalOverlay"
            );


        const cancelCallBtn =
            document.getElementById(
                "cancelCallBtn"
            );


        const confirmCallBtn =
            document.getElementById(
                "confirmCallBtn"
            );


        /* =====================================================
           OPEN 112 CONFIRMATION POPUP
        ===================================================== */

        if (
            emergencyCallBtn &&
            callModalOverlay
        ) {

            emergencyCallBtn.addEventListener(
                "click",
                function () {

                    callModalOverlay.style.display =
                        "flex";

                }
            );

        }


        /* =====================================================
           CANCEL POPUP
        ===================================================== */

        if (cancelCallBtn) {

            cancelCallBtn.addEventListener(
                "click",
                function () {

                    callModalOverlay.style.display =
                        "none";

                }
            );

        }


        /* =====================================================
           CLICK OUTSIDE POPUP TO CLOSE
        ===================================================== */

        if (callModalOverlay) {

            callModalOverlay.addEventListener(
                "click",
                function (event) {

                    if (
                        event.target ===
                        callModalOverlay
                    ) {

                        callModalOverlay.style.display =
                            "none";

                    }

                }
            );

        }


        /* =====================================================
           ESC KEY TO CLOSE POPUP
        ===================================================== */

        document.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key === "Escape" &&
                    callModalOverlay &&
                    callModalOverlay.style.display === "flex"
                ) {

                    callModalOverlay.style.display =
                        "none";

                }

            }
        );


        /* =====================================================
           CALL BUTTON
        ===================================================== */

        if (confirmCallBtn) {

            confirmCallBtn.addEventListener(
                "click",
                function () {

                    /*
                     * Allow the tel:112 link to continue.
                     * The device/browser will handle the call.
                     */

                    callModalOverlay.style.display =
                        "none";

                }
            );

        }

    }
);

</script>


</body>

</html>
