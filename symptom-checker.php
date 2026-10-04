<?php

session_start();

$isLoggedIn = isset($_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>SmartCare | AI Symptom Checker</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/symptom-checker.css"
    >

</head>

<body>


<nav class="navbar navbar-expand-lg smart-navbar sticky-top">

    <div class="container">

        <a
            href="index.php"
            class="navbar-brand smart-logo"
        >

            <span class="logo-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </span>

            Smart<span>Care</span>

        </a>


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
                        class="nav-link smart-nav-link"
                    >
                        Contact
                    </a>

                </li>

                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                    <a
                        href="index.php"
                        class="btn login-btn"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Back to SmartCare

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>



<main class="symptom-page">

    <div class="container">


        <div class="symptom-header">

            <span class="symptom-badge">

                <i class="bi bi-stars"></i>

                SmartCare AI

            </span>


            <h1>

                Understand Your Symptoms.
                <br>

                <span>Find the Right Specialist.</span>

            </h1>


            <p>

                Describe the symptoms you are experiencing in
                your own words. SmartCare AI will provide
                preliminary guidance and suggest the type of
                medical specialist you may consider consulting.

            </p>

        </div>



        <div class="symptom-card">

            <label
                for="symptoms"
                class="symptom-label"
            >

                <i class="bi bi-chat-left-text"></i>

                Describe Your Symptoms

            </label>


            <textarea
                id="symptoms"
                class="symptom-input"
                placeholder="Example: I have pain near my kidney and I feel dizzy..."
            ></textarea>


            <div class="symptom-help">

                You can describe one or multiple symptoms.
                Please provide as much detail as possible.

            </div>


            <button
                type="button"
                id="analyzeBtn"
                class="analyze-btn"
            >

                <i class="bi bi-stars"></i>

                Analyze Symptoms

            </button>


            <div
                id="errorBox"
                class="error-box"
            ></div>


            <div
                id="loadingBox"
                class="loading-box"
            >

                <div
                    class="spinner-border"
                    role="status"
                ></div>

                <div>
                    Analyzing your symptoms...
                </div>

            </div>

        </div>



        <div
            id="resultCard"
            class="result-card"
        >


            <div class="result-title">

                <div class="result-title-icon">

                    <i class="bi bi-clipboard2-pulse"></i>

                </div>

                AI Symptom Analysis

            </div>



            <div class="result-box">

                <h6>
                    Possible Health Area
                </h6>

                <p id="healthArea">
                    —
                </p>

            </div>



            <div class="result-box specialist-box">

                <h6>
                    Recommended Specialist
                </h6>

                <p
                    id="specialist"
                    class="specialist-name"
                >
                    —
                </p>


                <button
                    type="button"
                    id="recommendedDoctorsBtn"
                    class="recommended-doctors-btn"
                    style="display:none;"
                >

                    <span class="recommended-btn-icon">

                        <i class="bi bi-person-badge-fill"></i>

                    </span>

                    <span class="recommended-btn-text">
                        View Recommended Doctors
                    </span>

                    <i class="bi bi-arrow-right recommended-btn-arrow"></i>

                </button>

            </div>



            <div class="result-box">

                <h6>
                    Why This Specialist?
                </h6>

                <p id="reason">
                    —
                </p>

            </div>



            <div
                id="urgencyBox"
                class="result-box urgency-box"
                style="display:none;"
            >

                <h6>
                    Urgency
                </h6>

                <p id="urgency">
                    —
                </p>

            </div>



            <div
                id="emergencyBox"
                class="emergency-warning"
                style="display:none;"
            >

                <i class="bi bi-exclamation-triangle-fill"></i>

                <span id="emergencyMessage"></span>

            </div>



            <div class="disclaimer">

                <i class="bi bi-info-circle-fill"></i>

                This tool provides preliminary health guidance
                and does not provide a medical diagnosis.
                Please consult a qualified healthcare
                professional for proper evaluation.

            </div>

        </div>

    </div>

</main>



<script>

    window.smartCareLoggedIn =
        <?php echo $isLoggedIn ? "true" : "false"; ?>;

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<script
    src="assets/js/symptom-checker.js"
></script>

</body>

</html>
