<?php

session_start();

require_once "config/database.php";


/* =====================================================
   LOGIN INFORMATION
===================================================== */

$isLoggedIn = isset($_SESSION["user_id"]);

$role = $_SESSION["role"] ?? "";

$loggedInName = "";


if ($isLoggedIn) {

    $userStmt = $pdo->prepare("
        SELECT name
        FROM users
        WHERE id = ?
    ");

    $userStmt->execute([
        $_SESSION["user_id"]
    ]);

    $loggedInUser =
        $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($loggedInUser) {

        $loggedInName =
            $loggedInUser["name"];

    }

}


/* =====================================================
   DASHBOARD LINK
===================================================== */

if ($role === "patient") {

    $dashboardLink =
        "patient/dashboard.php";

} elseif ($role === "doctor") {

    $dashboardLink =
        "doctor/dashboard.php";

} elseif ($role === "admin") {

    $dashboardLink =
        "admin/dashboard.php";

} else {

    $dashboardLink =
        "auth/login.php";

}


/* =====================================================
   AI RECOMMENDED SPECIALIZATION
===================================================== */

$recommendedSpecialization =
    trim(
        $_GET["specialization"] ?? ""
    );


/* =====================================================
   NORMALIZE TEXT
===================================================== */

function normalizeText($value)
{

    $value =
        strtolower(
            trim(
                (string) $value
            )
        );

    $value =
        str_replace(
            [
                "&",
                "/",
                "\\",
                "-",
                "_",
                ","
            ],
            [
                " and ",
                " ",
                " ",
                " ",
                " ",
                " "
            ],
            $value
        );

    $value =
        preg_replace(
            "/\s+/",
            " ",
            $value
        );

    return trim($value);

}


/* =====================================================
   SPECIALIZATION MAP
===================================================== */

$specializationMap = [

    "cardiologist" => [
        "cardiologist",
        "cardiology",
        "cardiac specialist",
        "heart specialist",
        "heart doctor",
        "cardiac physician"
    ],

    "gynecologist" => [
        "gynecologist",
        "gynaecologist",
        "gynecology",
        "gynaecology",
        "obstetrician gynecology",
        "obstetrician gynecologist",
        "obstetrics and gynecology",
        "ob gyn",
        "obgyn",
        "womens health specialist",
        "women health specialist"
    ],

    "general physician" => [
        "general physician",
        "general medicine",
        "general practitioner",
        "physician",
        "primary care physician",
        "primary care doctor",
        "primary care",
        "internal medicine"
    ],

    "dermatologist" => [
        "dermatologist",
        "dermatology",
        "skin specialist",
        "skin doctor"
    ],

    "neurologist" => [
        "neurologist",
        "neurology",
        "nerve specialist",
        "brain and nerve specialist",
        "brain specialist"
    ],

    "orthopedic" => [
        "orthopedic",
        "orthopedist",
        "orthopedic doctor",
        "orthopaedic",
        "orthopaedist",
        "bone specialist",
        "joint specialist",
        "musculoskeletal specialist"
    ],

    "gastroenterologist" => [
        "gastroenterologist",
        "gastroenterology",
        "digestive specialist",
        "digestive system specialist",
        "stomach specialist"
    ],

    "urologist" => [
        "urologist",
        "urology",
        "urinary specialist",
        "urinary system specialist",
        "urinary tract specialist"
    ],

    "nephrologist" => [
        "nephrologist",
        "nephrology",
        "kidney specialist",
        "kidney doctor",
        "renal specialist",
        "renal doctor"
    ],

    "pulmonologist" => [
        "pulmonologist",
        "pulmonology",
        "chest specialist",
        "lung specialist",
        "respiratory specialist",
        "chest physician"
    ],

    "ophthalmologist" => [
        "ophthalmologist",
        "ophthalmology",
        "eye specialist",
        "eye doctor",
        "vision specialist"
    ],

    "ent specialist" => [
        "ent specialist",
        "ent doctor",
        "ent",
        "otolaryngologist",
        "otolaryngology",
        "ear nose throat specialist",
        "ear nose and throat specialist",
        "ear nose and throat doctor"
    ],

    "pediatrician" => [
        "pediatrician",
        "paediatrician",
        "pediatrics",
        "paediatrics",
        "child specialist",
        "child doctor",
        "children doctor"
    ],

    "psychiatrist" => [
        "psychiatrist",
        "psychiatry",
        "mental health specialist",
        "mental health doctor"
    ],

    "psychologist" => [
        "psychologist",
        "psychology",
        "clinical psychologist"
    ],

    "endocrinologist" => [
        "endocrinologist",
        "endocrinology",
        "hormone specialist",
        "hormonal specialist",
        "diabetes specialist",
        "diabetes doctor"
    ],

    "oncologist" => [
        "oncologist",
        "oncology",
        "cancer specialist",
        "cancer doctor"
    ],

    "rheumatologist" => [
        "rheumatologist",
        "rheumatology",
        "arthritis specialist",
        "autoimmune specialist",
        "joint inflammation specialist"
    ],

    "hematologist" => [
        "hematologist",
        "hematology",
        "blood specialist",
        "blood disorder specialist"
    ],

    "allergist" => [
        "allergist",
        "allergy specialist",
        "allergy doctor",
        "immunologist",
        "allergy and immunology"
    ],

    "dentist" => [
        "dentist",
        "dentistry",
        "dental specialist",
        "dental doctor"
    ],

    "surgeon" => [
        "surgeon",
        "general surgeon",
        "general surgery",
        "surgical specialist"
    ],

    "neurosurgeon" => [
        "neurosurgeon",
        "neurosurgery",
        "brain surgeon",
        "neuro surgeon"
    ],

    "plastic surgeon" => [
        "plastic surgeon",
        "plastic surgery",
        "reconstructive surgeon"
    ],

    "anesthesiologist" => [
        "anesthesiologist",
        "anaesthesiologist",
        "anesthesiology",
        "anaesthesiology",
        "anesthesia specialist",
        "anaesthesia specialist"
    ],

    "radiologist" => [
        "radiologist",
        "radiology",
        "imaging specialist",
        "medical imaging specialist"
    ],

    "pathologist" => [
        "pathologist",
        "pathology",
        "laboratory medicine specialist"
    ],

    "geriatrician" => [
        "geriatrician",
        "geriatrics",
        "elderly care specialist",
        "senior care specialist"
    ],

    "infectious disease specialist" => [
        "infectious disease specialist",
        "infectious diseases",
        "infectious disease doctor",
        "infection specialist"
    ],

    "physiotherapist" => [
        "physiotherapist",
        "physiotherapy",
        "physical therapist",
        "physical therapy",
        "rehabilitation specialist"
    ],

    "cardiothoracic surgeon" => [
        "cardiothoracic surgeon",
        "cardiothoracic surgery",
        "cardiac surgeon",
        "heart surgeon",
        "thoracic surgeon"
    ],

    "vascular surgeon" => [
        "vascular surgeon",
        "vascular surgery",
        "vascular specialist",
        "blood vessel specialist"
    ],

    "pain management specialist" => [
        "pain management specialist",
        "pain specialist",
        "pain medicine specialist",
        "pain management"
    ],

    "sleep specialist" => [
        "sleep specialist",
        "sleep medicine specialist",
        "sleep doctor",
        "sleep medicine"
    ]

];


/* =====================================================
   GET SPECIALIZATION CATEGORY
===================================================== */

function getSpecializationCategory(
    $specialization,
    $specializationMap
) {

    $specialization =
        normalizeText(
            $specialization
        );

    if ($specialization === "") {

        return "";

    }


    foreach (
        $specializationMap as
        $category => $aliases
    ) {

        foreach (
            $aliases as $alias
        ) {

            if (
                $specialization ===
                normalizeText($alias)
            ) {

                return $category;

            }

        }

    }


    return "";

}


/* =====================================================
   GET DOCTORS
===================================================== */

$stmt = $pdo->prepare("
    SELECT

        d.id AS doctor_id,

        u.name,
        u.email,
        u.phone,

        d.specialization,
        d.qualification,
        d.experience,
        d.consultation_fee,

        d.hospital_name,
        d.address,
        d.city,
        d.state,
        d.pincode,

        d.bio,

        COALESCE(
            AVG(dr.rating),
            0
        ) AS average_rating,

        COUNT(dr.id) AS review_count

    FROM doctors d

    INNER JOIN users u
        ON d.user_id = u.id

    LEFT JOIN doctor_reviews dr
        ON d.id = dr.doctor_id

    WHERE
        u.role = 'doctor'
        AND d.status = 'active'

    GROUP BY

        d.id,
        u.name,
        u.email,
        u.phone,

        d.specialization,
        d.qualification,
        d.experience,
        d.consultation_fee,

        d.hospital_name,
        d.address,
        d.city,
        d.state,
        d.pincode,

        d.bio

    ORDER BY
        u.name ASC
");

$stmt->execute();

$doctors =
    $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );


/* =====================================================
   UNIQUE SPECIALIZATIONS
===================================================== */

$specializations = [];


foreach (
    $doctors as $doctor
) {

    $value =
        trim(
            $doctor["specialization"] ?? ""
        );


    if (
        $value !== "" &&
        !in_array(
            $value,
            $specializations,
            true
        )
    ) {

        $specializations[] =
            $value;

    }

}


sort(
    $specializations,
    SORT_NATURAL |
    SORT_FLAG_CASE
);


/* =====================================================
   UNIQUE LOCATIONS
===================================================== */

$locations = [];


foreach (
    $doctors as $doctor
) {

    $city =
        trim(
            $doctor["city"] ?? ""
        );

    $state =
        trim(
            $doctor["state"] ?? ""
        );


    /*
     * IMPORTANT:
     *
     * Location dropdown contains ONLY
     * City + State.
     *
     * Address / Hospital / Pincode
     * are NOT included.
     */

    if (
        $city !== "" &&
        $state !== ""
    ) {

        $location =
            $city .
            ", " .
            $state;

    } elseif (
        $city !== ""
    ) {

        $location =
            $city;

    } elseif (
        $state !== ""
    ) {

        $location =
            $state;

    } else {

        $location = "";

    }


    if (
        $location !== "" &&
        !in_array(
            $location,
            $locations,
            true
        )
    ) {

        $locations[] =
            $location;

    }

}


sort(
    $locations,
    SORT_NATURAL |
    SORT_FLAG_CASE
);


/* =====================================================
   AI MATCH CALCULATION
===================================================== */

$recommendedCategory =
    getSpecializationCategory(
        $recommendedSpecialization,
        $specializationMap
    );


$matchedSpecializations = [];


if (
    $recommendedSpecialization !== ""
) {

    foreach (
        $doctors as $doctor
    ) {

        $doctorSpecialization =
            trim(
                $doctor["specialization"] ?? ""
            );


        if (
            $doctorSpecialization === ""
        ) {

            continue;

        }


        $doctorCategory =
            getSpecializationCategory(
                $doctorSpecialization,
                $specializationMap
            );


        /*
         * CATEGORY MATCH
         */

        if (
            $recommendedCategory !== "" &&
            $doctorCategory ===
            $recommendedCategory
        ) {

            if (
                !in_array(
                    $doctorSpecialization,
                    $matchedSpecializations,
                    true
                )
            ) {

                $matchedSpecializations[] =
                    $doctorSpecialization;

            }

            continue;

        }


        /*
         * DIRECT MATCH
         */

        if (
            normalizeText(
                $doctorSpecialization
            ) ===
            normalizeText(
                $recommendedSpecialization
            )
        ) {

            if (
                !in_array(
                    $doctorSpecialization,
                    $matchedSpecializations,
                    true
                )
            ) {

                $matchedSpecializations[] =
                    $doctorSpecialization;

            }

        }

    }

}


$hasAIRecommendation =
    $recommendedSpecialization !== "";


$aiMatchValues =
    array_values(
        $matchedSpecializations
    );


$displaySpecialization =
    $recommendedSpecialization;


if (
    !empty(
        $matchedSpecializations
    )
) {

    $displaySpecialization =
        implode(
            " / ",
            $matchedSpecializations
        );

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
        SmartCare | Find Doctors
    </title>


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
        href="assets/css/doctors.css"
    >

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

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

            <ul
                class="navbar-nav ms-auto align-items-lg-center"
            >


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


                <?php if ($isLoggedIn): ?>


                    <li class="nav-item ms-lg-3">

                        <span
                            class="nav-link doctor-user-name"
                        >

                            <i
                                class="bi bi-person-circle me-1"
                            ></i>

                            Hi,

                            <?php
                            echo htmlspecialchars(
                                $loggedInName ?: "User"
                            );
                            ?>

                        </span>

                    </li>


                    <li class="nav-item ms-lg-2">

                        <a
                            href="<?php
                            echo htmlspecialchars(
                                $dashboardLink
                            );
                            ?>"
                            class="btn login-btn"
                        >

                            <i
                                class="bi bi-grid-1x2 me-1"
                            ></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item ms-lg-2">

                        <a
                            href="auth/logout.php"
                            class="btn register-btn"
                        >

                            <i
                                class="bi bi-box-arrow-right me-1"
                            ></i>

                            Logout

                        </a>

                    </li>


                <?php else: ?>


                    <li class="nav-item ms-lg-3">

                        <a
                            href="auth/login.php"
                            class="btn login-btn"
                        >
                            Login
                        </a>

                    </li>


                    <li class="nav-item ms-lg-2">

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
     HEADER
===================================================== -->

<section class="doctors-header">

    <div class="container">

        <div class="text-center">


            <div class="section-eyebrow">

                <?php if (
                    $hasAIRecommendation
                ): ?>

                    Recommended Doctors

                <?php else: ?>

                    Find Doctors

                <?php endif; ?>

            </div>


            <h1>

                <?php if (
                    $hasAIRecommendation
                ): ?>

                    Doctors Recommended for You

                <?php else: ?>

                    Find the Right Doctor for You

                <?php endif; ?>

            </h1>


            <p>

                <?php if (
                    $hasAIRecommendation
                ): ?>

                    Based on your AI symptom analysis,
                    doctors related to

                    <strong>

                        <?php
                        echo htmlspecialchars(
                            $displaySpecialization
                        );
                        ?>

                    </strong>

                    are shown below.

                <?php else: ?>

                    Explore our doctors and choose a healthcare
                    professional based on specialization,
                    location, experience and consultation fee.

                <?php endif; ?>

            </p>


        </div>

    </div>

</section>


<!-- =====================================================
     DOCTORS SECTION
===================================================== -->

<section class="doctors-section">

    <div class="container">


        <?php if (
            empty($doctors)
        ): ?>


            <div class="empty-doctors">

                <div class="empty-icon">

                    <i class="bi bi-person-x"></i>

                </div>


                <h4>
                    No Doctors Available
                </h4>


                <p>

                    There are currently no active doctors
                    registered on SmartCare.

                </p>

            </div>


        <?php else: ?>


            <!-- =================================================
                 SEARCH + FILTERS
            ================================================= -->

            <div class="doctor-search-area">


                <!-- SEARCH -->

                <div class="doctor-search-box">

                    <i class="bi bi-search"></i>


                    <input
                        type="text"
                        id="doctorSearch"
                        placeholder="Search doctor, specialization or location..."
                        autocomplete="off"
                    >

                </div>


                <!-- SPECIALIZATION -->

                <div class="doctor-filter-box">

                    <i class="bi bi-funnel"></i>


                    <select
                        id="specializationFilter"

                        data-ai-active="<?php
                        echo $hasAIRecommendation
                            ? "true"
                            : "false";
                        ?>"

                        data-ai-matches="<?php
                        echo htmlspecialchars(
                            json_encode(
                                $aiMatchValues,
                                JSON_UNESCAPED_UNICODE |
                                JSON_UNESCAPED_SLASHES
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"
                    >


                        <option value="all">
                            All Specializations
                        </option>


                        <?php foreach (
                            $specializations
                            as $specialization
                        ): ?>


                            <option
                                value="<?php
                                echo htmlspecialchars(
                                    normalizeText(
                                        $specialization
                                    ),
                                    ENT_QUOTES,
                                    "UTF-8"
                                );
                                ?>"
                            >

                                <?php
                                echo htmlspecialchars(
                                    $specialization
                                );
                                ?>

                            </option>


                        <?php endforeach; ?>


                    </select>

                </div>


                <!-- LOCATION -->

                <div class="doctor-filter-box">

                    <i class="bi bi-geo-alt"></i>


                    <select
                        id="locationFilter"
                    >

                        <option value="all">
                            All Locations
                        </option>


                        <?php foreach (
                            $locations as $location
                        ): ?>

                            <option
                                value="<?php
                                echo htmlspecialchars(
                                    normalizeText(
                                        $location
                                    ),
                                    ENT_QUOTES,
                                    "UTF-8"
                                );
                                ?>"
                            >

                                <?php
                                echo htmlspecialchars(
                                    $location
                                );
                                ?>

                            </option>

                        <?php endforeach; ?>


                    </select>

                </div>


            </div>


            <!-- =================================================
                 AI INFO
            ================================================= -->

            <?php if (
                $hasAIRecommendation
            ): ?>

                <div
                    class="alert alert-info mt-3"
                    role="alert"
                >

                    <i
                        class="bi bi-stars me-2"
                    ></i>

                    Showing doctors related to:

                    <strong>

                        <?php
                        echo htmlspecialchars(
                            $displaySpecialization
                        );
                        ?>

                    </strong>

                </div>

            <?php endif; ?>


            <!-- =================================================
                 RESULT COUNT
            ================================================= -->

            <div class="doctor-results-info">

                <span id="doctorResultCount">

                    Showing

                    <?php
                    echo count($doctors);
                    ?>

                    doctors

                </span>

            </div>


            <!-- =================================================
                 DOCTOR LIST
            ================================================= -->

            <div
                class="row g-4"
                id="doctorList"
            >


                <?php foreach (
                    $doctors as $doctor
                ): ?>


                    <?php

                    $doctorName =
                        trim(
                            $doctor["name"] ?? ""
                        );


                    $doctorSpecialization =
                        trim(
                            $doctor["specialization"] ?? ""
                        );


                    $doctorCity =
                        trim(
                            $doctor["city"] ?? ""
                        );


                    $doctorState =
                        trim(
                            $doctor["state"] ?? ""
                        );


                    $doctorAddress =
                        trim(
                            $doctor["address"] ?? ""
                        );


                    $doctorHospital =
                        trim(
                            $doctor["hospital_name"] ?? ""
                        );


                    $doctorPincode =
                        trim(
                            $doctor["pincode"] ?? ""
                        );


                    $doctorQualification =
                        trim(
                            $doctor["qualification"] ?? ""
                        );


                    $doctorBio =
                        trim(
                            $doctor["bio"] ?? ""
                        );


                    /* =========================================
                       AI MATCH
                    ========================================= */

                    $doctorCategory =
                        getSpecializationCategory(
                            $doctorSpecialization,
                            $specializationMap
                        );


                    $isAIMatch = false;


                    if (
                        $hasAIRecommendation &&
                        $recommendedCategory !== "" &&
                        $doctorCategory ===
                        $recommendedCategory
                    ) {

                        $isAIMatch = true;

                    }


                    if (
                        $hasAIRecommendation &&
                        !$isAIMatch &&
                        normalizeText(
                            $doctorSpecialization
                        ) ===
                        normalizeText(
                            $recommendedSpecialization
                        )
                    ) {

                        $isAIMatch = true;

                    }


                    /* =========================================
                       RATING
                    ========================================= */

                    $averageRating =
                        (float)(
                            $doctor[
                                "average_rating"
                            ] ?? 0
                        );


                    $reviewCount =
                        (int)(
                            $doctor[
                                "review_count"
                            ] ?? 0
                        );


                    /* =========================================
                       LOCATION DISPLAY
                    ========================================= */

                    $locationParts = [];


                    if (
                        $doctorCity !== ""
                    ) {

                        $locationParts[] =
                            $doctorCity;

                    }


                    if (
                        $doctorState !== "" &&
                        strcasecmp(
                            $doctorState,
                            $doctorCity
                        ) !== 0
                    ) {

                        $locationParts[] =
                            $doctorState;

                    }


                    $displayLocation =
                        implode(
                            ", ",
                            $locationParts
                        );


                    /* =========================================
                       SEARCH LOCATION
                    ========================================= */

                    $combinedLocation =
                        trim(
                            $doctorCity .
                            " " .
                            $doctorState .
                            " " .
                            $doctorAddress .
                            " " .
                            $doctorHospital .
                            " " .
                            $doctorPincode
                        );


                    /* =========================================
                       IMPORTANT LOCATION KEY
                       
                       ONLY CITY + STATE
                       
                       This MUST match the dropdown value.
                    ========================================= */

                    $locationKey =
                        normalizeText(
                            trim(
                                $doctorCity .
                                " " .
                                $doctorState
                            )
                        );

                    ?>


                    <!-- =================================================
                         DOCTOR ITEM
                    ================================================= -->

                    <div
                        class="col-md-6 col-xl-4 doctor-item"

                        data-name="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorName
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-specialization="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorSpecialization
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-city="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorCity
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-state="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorState
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-location-key="<?php
                        echo htmlspecialchars(
                            $locationKey,
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-address="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorAddress
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-hospital="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorHospital
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-pincode="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $doctorPincode
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-location="<?php
                        echo htmlspecialchars(
                            normalizeText(
                                $combinedLocation
                            ),
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>"

                        data-ai-match="<?php
                        echo $isAIMatch
                            ? "true"
                            : "false";
                        ?>"
                    >


                        <div class="doctor-list-card">


                            <!-- TOP -->

                            <div class="doctor-card-top">


                                <div class="doctor-avatar">

                                    <i
                                        class="bi bi-person-badge-fill"
                                    ></i>

                                </div>


                                <div>

                                    <h5>

                                        Dr.

                                        <?php
                                        echo htmlspecialchars(
                                            $doctorName
                                        );
                                        ?>

                                    </h5>


                                    <span
                                        class="specialization"
                                    >

                                        <?php
                                        echo htmlspecialchars(
                                            $doctorSpecialization
                                        );
                                        ?>

                                    </span>

                                </div>

                            </div>


                            <!-- RATING -->

                            <div
                                class="doctor-rating"
                                style="
                                    margin:10px 0;
                                    display:flex;
                                    align-items:center;
                                    gap:6px;
                                    color:#f59e0b;
                                    font-size:14px;
                                "
                            >

                                <i
                                    class="bi bi-star-fill"
                                ></i>


                                <strong>

                                    <?php
                                    echo number_format(
                                        $averageRating,
                                        1
                                    );
                                    ?>

                                </strong>


                                <span
                                    style="
                                        color:#64748b;
                                        font-size:12px;
                                    "
                                >

                                    (

                                    <?php
                                    echo $reviewCount;
                                    ?>

                                    <?php
                                    echo
                                        $reviewCount === 1
                                        ? " review"
                                        : " reviews";
                                    ?>

                                    )

                                </span>

                            </div>


                            <!-- LOCATION -->

                            <?php if (
                                $displayLocation !== "" ||
                                $doctorHospital !== ""
                            ): ?>


                                <div
                                    class="doctor-location"
                                    style="
                                        display:flex;
                                        align-items:flex-start;
                                        gap:7px;
                                        margin-bottom:12px;
                                        color:#64748b;
                                        font-size:12px;
                                    "
                                >

                                    <i
                                        class="bi bi-geo-alt-fill"
                                        style="
                                            color:#0d9488;
                                        "
                                    ></i>


                                    <div>


                                        <?php if (
                                            $displayLocation !== ""
                                        ): ?>

                                            <div>

                                                <?php
                                                echo htmlspecialchars(
                                                    $displayLocation
                                                );
                                                ?>

                                            </div>

                                        <?php endif; ?>


                                        <?php if (
                                            $doctorHospital !== ""
                                        ): ?>

                                            <div>

                                                <?php
                                                echo htmlspecialchars(
                                                    $doctorHospital
                                                );
                                                ?>

                                            </div>

                                        <?php endif; ?>


                                    </div>

                                </div>


                            <?php endif; ?>


                            <!-- DETAILS -->

                            <div class="doctor-details">


                                <div
                                    class="doctor-detail-item"
                                >

                                    <i
                                        class="bi bi-mortarboard"
                                    ></i>


                                    <div>

                                        <small>
                                            Qualification
                                        </small>


                                        <strong>

                                            <?php
                                            echo htmlspecialchars(
                                                $doctorQualification
                                                ?: "Not specified"
                                            );
                                            ?>

                                        </strong>

                                    </div>

                                </div>


                                <div
                                    class="doctor-detail-item"
                                >

                                    <i
                                        class="bi bi-briefcase"
                                    ></i>


                                    <div>

                                        <small>
                                            Experience
                                        </small>


                                        <strong>

                                            <?php
                                            echo (int)(
                                                $doctor[
                                                    "experience"
                                                ] ?? 0
                                            );
                                            ?>

                                            years

                                        </strong>

                                    </div>

                                </div>


                                <div
                                    class="doctor-detail-item"
                                >

                                    <i
                                        class="bi bi-cash-stack"
                                    ></i>


                                    <div>

                                        <small>
                                            Consultation Fee
                                        </small>


                                        <strong>

                                            ₹

                                            <?php
                                            echo number_format(
                                                (float)(
                                                    $doctor[
                                                        "consultation_fee"
                                                    ] ?? 0
                                                ),
                                                2
                                            );
                                            ?>

                                        </strong>

                                    </div>

                                </div>


                            </div>


                            <!-- BIO -->

                            <?php if (
                                $doctorBio !== ""
                            ): ?>


                                <p class="doctor-bio">

                                    <?php
                                    echo htmlspecialchars(
                                        $doctorBio
                                    );
                                    ?>

                                </p>


                            <?php endif; ?>


                            <!-- FOOTER -->

                            <div
                                class="doctor-card-footer"
                            >

                                <a
                                    href="patient/book_appointment.php?doctor_id=<?php
                                    echo (int)
                                        $doctor["doctor_id"];
                                    ?>"
                                    class="doctor-book-btn"
                                >

                                    <i
                                        class="bi bi-calendar-check"
                                    ></i>

                                    Book Appointment

                                </a>

                            </div>


                        </div>

                    </div>


                <?php endforeach; ?>


            </div>


            <!-- =================================================
                 NO RESULTS
            ================================================= -->

            <div
                class="doctor-no-results"
                id="doctorNoResults"
            >

                <div class="empty-icon">

                    <i class="bi bi-search"></i>

                </div>


                <h4>
                    No Doctors Found
                </h4>


                <p>

                    Try another doctor name,
                    specialization or location.

                </p>

            </div>


        <?php endif; ?>


    </div>

</section>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="smart-footer">

    <div class="container">


        <div class="row g-5">


            <div class="col-lg-5">

                <div class="footer-logo">

                    <i
                        class="bi bi-heart-pulse-fill"
                    ></i>

                    Smart<span>Care</span>

                </div>


                <p class="mt-3">

                    A smarter digital healthcare platform
                    connecting patients with better care.

                </p>

            </div>


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


            <div class="col-6 col-lg-4">

                <h6>
                    Account
                </h6>


                <?php if (
                    $isLoggedIn
                ): ?>


                    <a
                        href="<?php
                        echo htmlspecialchars(
                            $dashboardLink
                        );
                        ?>"
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


            </div>


        </div>


        <div class="footer-bottom">

            ©

            <?php
            echo date("Y");
            ?>

            SmartCare. All rights reserved.

        </div>


    </div>

</footer>


<!-- =====================================================
     BOOTSTRAP
===================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<!-- =====================================================
     DOCTORS JS
===================================================== -->

<script
    src="assets/js/doctors.js"
></script>


</body>

</html>
