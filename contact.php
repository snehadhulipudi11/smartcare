<?php

session_start();

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| LOGIN INFORMATION
|--------------------------------------------------------------------------
*/

$isLoggedIn = isset($_SESSION["user_id"]);
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";


/*
|--------------------------------------------------------------------------
| DYNAMIC DASHBOARD LINK
|--------------------------------------------------------------------------
*/

if ($isLoggedIn && $role === "patient") {

    $dashboardLink = "patient/dashboard.php";

} elseif ($isLoggedIn && $role === "doctor") {

    $dashboardLink = "doctor/dashboard.php";

} elseif ($isLoggedIn && $role === "admin") {

    $dashboardLink = "admin/dashboard.php";

} else {

    $dashboardLink = "auth/login.php";

}


/*
|--------------------------------------------------------------------------
| CONTACT FORM
|--------------------------------------------------------------------------
*/

$successMessage = "";
$errorMessage = "";

$oldName = "";
$oldEmail = "";
$oldSubject = "";
$oldMessage = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $oldName = trim($_POST["full_name"] ?? "");
    $oldEmail = trim($_POST["email"] ?? "");
    $oldSubject = trim($_POST["subject"] ?? "");
    $oldMessage = trim($_POST["message"] ?? "");


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        empty($oldName) ||
        empty($oldEmail) ||
        empty($oldSubject) ||
        empty($oldMessage)
    ) {

        $errorMessage = "Please fill in all fields.";

    } elseif (
        !filter_var(
            $oldEmail,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $errorMessage = "Please enter a valid email address.";

    } elseif (strlen($oldName) > 100) {

        $errorMessage = "Full name is too long.";

    } elseif (strlen($oldSubject) > 255) {

        $errorMessage = "Subject is too long.";

    } else {


        /*
        |--------------------------------------------------------------------------
        | SAVE MESSAGE TO DATABASE
        |--------------------------------------------------------------------------
        */

        try {

            $stmt = $pdo->prepare("
                INSERT INTO contact_messages
                (
                    full_name,
                    email,
                    subject,
                    message,
                    status
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    'unread'
                )
            ");


            $stmt->execute([
                $oldName,
                $oldEmail,
                $oldSubject,
                $oldMessage
            ]);


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            $successMessage =
                "Thank you, " .
                htmlspecialchars(
                    $oldName,
                    ENT_QUOTES,
                    "UTF-8"
                ) .
                "! Your message has been sent successfully. Our support team will get back to you soon.";


            /*
            |--------------------------------------------------------------------------
            | CLEAR FORM
            |--------------------------------------------------------------------------
            */

            $oldName = "";
            $oldEmail = "";
            $oldSubject = "";
            $oldMessage = "";


        } catch (PDOException $e) {

            $errorMessage =
                "Sorry, we could not send your message right now. Please try again later.";

        }

    }

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
        Contact SmartCare | Get in Touch
    </title>


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
           CONTACT HERO
        ===================================================== */

        .contact-hero {

            padding: 85px 0 75px;

            background:
                linear-gradient(
                    135deg,
                    #eefaff 0%,
                    #ffffff 55%,
                    #eafaf5 100%
                );

        }


        .contact-hero h1 {

            color: #123b52;

            font-size: 52px;

            font-weight: 800;

            line-height: 1.15;

        }


        .contact-hero h1 span {

            color: #0d8abc;

        }


        .contact-hero p {

            max-width: 720px;

            margin: 20px auto 0;

            color: #687b85;

            font-size: 18px;

            line-height: 1.8;

        }


        /* =====================================================
           CONTACT MAIN
        ===================================================== */

        .contact-section {

            padding: 90px 0;

            background: #ffffff;

        }


        /* =====================================================
           CONTACT INFORMATION
        ===================================================== */

        .contact-info-card {

            height: 100%;

            padding: 40px;

            border-radius: 25px;

            background:
                linear-gradient(
                    145deg,
                    #f1fbfd,
                    #ffffff
                );

            border: 1px solid #e7f0f3;

        }


        .contact-info-card h2 {

            color: #173f52;

            font-weight: 800;

        }


        .contact-info-card > p {

            color: #71818a;

            line-height: 1.8;

        }


        .contact-info-item {

            display: flex;

            align-items: flex-start;

            gap: 18px;

            margin-top: 30px;

        }


        .contact-info-icon {

            min-width: 52px;

            width: 52px;

            height: 52px;

            border-radius: 15px;

            background: #e5f7fc;

            color: #0d8abc;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 22px;

        }


        .contact-info-item h6 {

            color: #173f52;

            font-weight: 700;

            margin-bottom: 5px;

        }


        .contact-info-item p {

            color: #71818a;

            margin: 0;

            line-height: 1.6;

        }


        .contact-info-item a {

            color: #71818a;

            text-decoration: none;

            transition: 0.2s ease;

        }


        .contact-info-item a:hover {

            color: #0d8abc;

        }


        /* CALL BUTTON */

        .call-link {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            color: #0d8abc !important;

            font-weight: 700;

        }


        .call-link:hover {

            color: #08749d !important;

        }


        /* =====================================================
           CONTACT FORM
        ===================================================== */

        .contact-form-card {

            padding: 40px;

            border-radius: 25px;

            background: #ffffff;

            border: 1px solid #edf2f4;

            box-shadow:
                0 15px 45px
                rgba(13, 138, 188, 0.08);

        }


        .contact-form-card h2 {

            color: #173f52;

            font-weight: 800;

        }


        .contact-form-card > p {

            color: #71818a;

        }


        .contact-form-card label {

            color: #294c5d;

            font-weight: 600;

            margin-bottom: 8px;

        }


        .contact-form-card .form-control {

            min-height: 52px;

            border-radius: 12px;

            border: 1px solid #dce8ec;

            padding: 12px 15px;

        }


        .contact-form-card textarea.form-control {

            min-height: 145px;

            resize: vertical;

        }


        .contact-form-card .form-control:focus {

            border-color: #0d8abc;

            box-shadow:
                0 0 0 0.2rem
                rgba(13, 138, 188, 0.10);

        }


        .contact-submit {

            border: none;

            border-radius: 12px;

            background: #0d8abc;

            color: #ffffff;

            padding: 13px 25px;

            font-weight: 700;

            transition: 0.25s ease;

        }


        .contact-submit:hover {

            background: #08749d;

            transform: translateY(-2px);

        }


        /* =====================================================
           ALERTS
        ===================================================== */

        .contact-alert {

            border-radius: 12px;

            padding: 14px 18px;

            margin-bottom: 25px;

        }


        /* =====================================================
           SUPPORT CTA
        ===================================================== */

        .contact-support {

            padding: 80px 0;

            background: #f5fbfc;

        }


        .support-box {

            padding: 50px;

            border-radius: 28px;

            background:
                linear-gradient(
                    135deg,
                    #0d8abc,
                    #08749d
                );

            color: #ffffff;

            box-shadow:
                0 20px 50px
                rgba(13, 138, 188, 0.18);

        }


        .support-box h2 {

            font-weight: 800;

        }


        .support-box p {

            color: rgba(255,255,255,.88);

            line-height: 1.8;

        }


        .support-icon {

            width: 90px;

            height: 90px;

            margin: 0 auto 20px;

            border-radius: 50%;

            background: rgba(255,255,255,.15);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 42px;

        }


        .support-button {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 12px 23px;

            border-radius: 12px;

            background: #ffffff;

            color: #08749d;

            text-decoration: none;

            font-weight: 700;

            transition: 0.25s ease;

        }


        .support-button:hover {

            background: #eafaff;

            color: #08749d;

            transform: translateY(-2px);

        }


        /* =====================================================
           FAQ
        ===================================================== */

        .faq-section {

            padding: 90px 0;

            background: #ffffff;

        }


        .faq-item {

            border: 1px solid #e8eef0;

            border-radius: 15px;

            margin-bottom: 15px;

            overflow: hidden;

        }


        .faq-item button {

            width: 100%;

            border: none;

            background: #ffffff;

            padding: 20px;

            text-align: left;

            color: #173f52;

            font-weight: 700;

            font-size: 16px;

        }


        .faq-item button:focus {

            box-shadow: none;

        }


        .faq-answer {

            padding: 0 20px 20px;

            color: #71818a;

            line-height: 1.7;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {

            .contact-hero {

                padding: 65px 0;

            }


            .contact-hero h1 {

                font-size: 38px;

            }


            .contact-hero p {

                font-size: 16px;

            }


            .contact-section,
            .contact-support,
            .faq-section {

                padding: 65px 0;

            }


            .contact-info-card,
            .contact-form-card {

                padding: 28px 22px;

            }


            .support-box {

                padding: 35px 25px;

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


                <li class="nav-item">

                    <a
                        href="index.php"
                        class="nav-link smart-nav-link"
                    >
                        Home
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="index.php#services"
                        class="nav-link smart-nav-link"
                    >
                        Services
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="about.php"
                        class="nav-link smart-nav-link"
                    >
                        About
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        href="contact.php"
                        class="nav-link smart-nav-link active"
                    >
                        Contact
                    </a>

                </li>


                <?php if ($isLoggedIn): ?>


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
                            <?= htmlspecialchars(
                                $name,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>

                        </span>

                    </li>


                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                        <a
                            href="<?= htmlspecialchars(
                                $dashboardLink,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>"
                            class="btn login-btn"
                        >

                            <i class="bi bi-grid-1x2 me-1"></i>

                            Dashboard

                        </a>

                    </li>


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


                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                        <a
                            href="auth/login.php"
                            class="btn login-btn"
                        >
                            Login
                        </a>

                    </li>


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
     CONTACT HERO
===================================================== -->

<section class="contact-hero text-center">

    <div class="container">

        <div class="section-eyebrow">
            Contact SmartCare
        </div>


        <h1>

            We're here to

            <br>

            <span>
                help you.
            </span>

        </h1>


        <p>

            Have a question, suggestion or need help with
            SmartCare? Send us a message and our support team
            will be happy to assist you.

        </p>

    </div>

</section>



<!-- =====================================================
     CONTACT MAIN
===================================================== -->

<section class="contact-section">

    <div class="container">

        <div class="row g-5">


            <!-- =================================================
                 CONTACT INFORMATION
            ================================================== -->

            <div class="col-lg-5">

                <div class="contact-info-card">

                    <div class="section-eyebrow">
                        Get in Touch
                    </div>


                    <h2 class="mt-2">

                        Let's talk about your healthcare needs.

                    </h2>


                    <p class="mt-3">

                        Whether you need assistance with your account,
                        appointments or any SmartCare feature, feel
                        free to contact us.

                    </p>


                    <!-- EMAIL -->

                    <div class="contact-info-item">

                        <div class="contact-info-icon">

                            <i class="bi bi-envelope"></i>

                        </div>


                        <div>

                            <h6>
                                Email Us
                            </h6>


                            <p>

                                <a
                                    href="mailto:support@smartcare.com"
                                >
                                    support@smartcare.com
                                </a>

                            </p>

                        </div>

                    </div>



                    <!-- PHONE -->

                    <div class="contact-info-item">

                        <div class="contact-info-icon">

                            <i class="bi bi-telephone"></i>

                        </div>


                        <div>

                            <h6>
                                Call Us
                            </h6>


                            <p>

                                <a
                                    href="tel:+917997877567"
                                    class="call-link"
                                >

                                    <i class="bi bi-telephone-fill"></i>

                                    +91 7997877567

                                </a>

                            </p>

                        </div>

                    </div>



                    <!-- LOCATION -->

                    <div class="contact-info-item">

                        <div class="contact-info-icon">

                            <i class="bi bi-geo-alt"></i>

                        </div>


                        <div>

                            <h6>
                                Our Location
                            </h6>


                            <p>

                                SmartCare Healthcare Center<br>

                                Andhra Pradesh, India

                            </p>

                        </div>

                    </div>



                    <!-- SUPPORT HOURS -->

                    <div class="contact-info-item">

                        <div class="contact-info-icon">

                            <i class="bi bi-clock"></i>

                        </div>


                        <div>

                            <h6>
                                Support Hours
                            </h6>


                            <p>

                                Monday - Saturday<br>

                                9:00 AM - 6:00 PM

                            </p>

                        </div>

                    </div>


                </div>

            </div>



            <!-- =================================================
                 CONTACT FORM
            ================================================== -->

            <div class="col-lg-7">

                <div class="contact-form-card">

                    <div class="section-eyebrow">
                        Send a Message
                    </div>


                    <h2 class="mt-2">
                        How can we help?
                    </h2>


                    <p class="mt-2 mb-4">

                        Fill out the form below and we'll get back
                        to you as soon as possible.

                    </p>


                    <!-- SUCCESS -->

                    <?php if (!empty($successMessage)): ?>

                        <div
                            class="alert alert-success contact-alert"
                            role="alert"
                        >

                            <i class="bi bi-check-circle-fill me-2"></i>

                            <?= $successMessage ?>

                        </div>

                    <?php endif; ?>


                    <!-- ERROR -->

                    <?php if (!empty($errorMessage)): ?>

                        <div
                            class="alert alert-danger contact-alert"
                            role="alert"
                        >

                            <i class="bi bi-exclamation-circle-fill me-2"></i>

                            <?= htmlspecialchars(
                                $errorMessage,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <!-- FORM -->

                    <form
                        method="POST"
                        action=""
                    >


                        <!-- NAME -->

                        <div class="mb-3">

                            <label
                                for="full_name"
                                class="form-label"
                            >
                                Full Name
                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="full_name"
                                name="full_name"
                                placeholder="Enter your full name"
                                value="<?= htmlspecialchars(
                                    $oldName,
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email Address
                            </label>


                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                value="<?= htmlspecialchars(
                                    $oldEmail,
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- SUBJECT -->

                        <div class="mb-3">

                            <label
                                for="subject"
                                class="form-label"
                            >
                                Subject
                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="subject"
                                name="subject"
                                placeholder="What is your message about?"
                                value="<?= htmlspecialchars(
                                    $oldSubject,
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- MESSAGE -->

                        <div class="mb-4">

                            <label
                                for="message"
                                class="form-label"
                            >
                                Message
                            </label>


                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                placeholder="Write your message here..."
                                required
                            ><?= htmlspecialchars(
                                $oldMessage,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?></textarea>

                        </div>


                        <!-- SUBMIT -->

                        <button
                            type="submit"
                            class="contact-submit"
                        >

                            <i class="bi bi-send me-2"></i>

                            Send Message

                        </button>


                    </form>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     SUPPORT CTA
===================================================== -->

<section class="contact-support">

    <div class="container">

        <div class="support-box text-center">


            <div class="support-icon">

                <i class="bi bi-headset"></i>

            </div>


            <h2>
                Need urgent assistance?
            </h2>


            <p class="mt-3 mb-4">

                For life-threatening medical emergencies,
                please contact your local emergency services
                immediately.

            </p>


            <a
                href="tel:112"
                class="support-button"
            >

                <i class="bi bi-telephone-fill"></i>

                Emergency: 112

            </a>


        </div>

    </div>

</section>



<!-- =====================================================
     FAQ
===================================================== -->

<section class="faq-section">

    <div class="container">


        <div class="text-center mb-5">

            <div class="section-eyebrow">
                FAQ
            </div>


            <h2 class="section-heading">
                Frequently Asked Questions
            </h2>


            <p class="section-description">

                Quick answers to some common questions
                about SmartCare.

            </p>

        </div>


        <div class="row justify-content-center">

            <div class="col-lg-9">


                <!-- FAQ 1 -->

                <div class="faq-item">

                    <button
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faqOne"
                        aria-expanded="true"
                        aria-controls="faqOne"
                    >

                        How can I book a doctor appointment?

                        <i class="bi bi-chevron-down float-end"></i>

                    </button>


                    <div
                        id="faqOne"
                        class="collapse show"
                    >

                        <div class="faq-answer">

                            You can log in to your SmartCare account,
                            open the appointment section, select a
                            doctor and choose an available date and time.

                        </div>

                    </div>

                </div>


                <!-- FAQ 2 -->

                <div class="faq-item">

                    <button
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faqTwo"
                        aria-expanded="false"
                        aria-controls="faqTwo"
                    >

                        Is SmartCare available for patients and doctors?

                        <i class="bi bi-chevron-down float-end"></i>

                    </button>


                    <div
                        id="faqTwo"
                        class="collapse"
                    >

                        <div class="faq-answer">

                            Yes. SmartCare provides separate features
                            and dashboards for patients and doctors.

                        </div>

                    </div>

                </div>


                <!-- FAQ 3 -->

                <div class="faq-item">

                    <button
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faqThree"
                        aria-expanded="false"
                        aria-controls="faqThree"
                    >

                        Can I manage my healthcare information?

                        <i class="bi bi-chevron-down float-end"></i>

                    </button>


                    <div
                        id="faqThree"
                        class="collapse"
                    >

                        <div class="faq-answer">

                            SmartCare is designed to help users
                            organize and access their healthcare
                            information through their account.

                        </div>

                    </div>

                </div>


                <!-- FAQ 4 -->

                <div class="faq-item">

                    <button
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faqFour"
                        aria-expanded="false"
                        aria-controls="faqFour"
                    >

                        How can I contact SmartCare support?

                        <i class="bi bi-chevron-down float-end"></i>

                    </button>


                    <div
                        id="faqFour"
                        class="collapse"
                    >

                        <div class="faq-answer">

                            You can use the contact form on this page
                            or email us at support@smartcare.com.

                        </div>

                    </div>

                </div>


            </div>

        </div>

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
                        href="<?= htmlspecialchars(
                            $dashboardLink,
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>"
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



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>
