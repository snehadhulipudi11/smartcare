<?php

session_start();

require_once __DIR__ . "/config/database.php";

header("Content-Type: application/json");


/* =====================================================
   LOGIN CHECK
===================================================== */

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Please login first."
    ]);

    exit;
}


/* =====================================================
   GET USER ID
===================================================== */

$userId = $_SESSION["user_id"];


/* =====================================================
   PATIENT ROLE CHECK
===================================================== */

if (!isset($_SESSION["role"]) || empty($_SESSION["role"])) {

    echo json_encode([
        "success" => false,
        "message" => "User role not found. Please login again."
    ]);

    exit;
}


/*
 * Convert role to lowercase so:
 *
 * patient
 * Patient
 * PATIENT
 *
 * are all treated as patient.
 */

$userRole = strtolower(trim($_SESSION["role"]));


if ($userRole !== "patient") {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access."
    ]);

    exit;
}


/* =====================================================
   GET LOCATION
===================================================== */

$latitude = isset($_POST["latitude"])
    ? trim($_POST["latitude"])
    : null;

$longitude = isset($_POST["longitude"])
    ? trim($_POST["longitude"])
    : null;


/* =====================================================
   BASIC LOCATION VALIDATION
===================================================== */

if ($latitude === "" || $longitude === "") {

    $latitude = null;
    $longitude = null;
}


/* =====================================================
   SAVE EMERGENCY REQUEST
===================================================== */

try {

    $stmt = $pdo->prepare("
        INSERT INTO emergency_requests
        (
            patient_id,
            emergency_type,
            latitude,
            longitude,
            status
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");


    $stmt->execute([
        $userId,
        "Medical Emergency",
        $latitude,
        $longitude,
        "ACTIVE"
    ]);


    /* =================================================
       SUCCESS RESPONSE
    ================================================== */

    echo json_encode([
        "success" => true,
        "message" => "Emergency request recorded successfully.",
        "emergency_id" => $pdo->lastInsertId()
    ]);

    exit;


} catch (PDOException $e) {

    /* =================================================
       DATABASE ERROR
    ================================================== */

    echo json_encode([
        "success" => false,
        "message" => "Unable to save emergency request."
    ]);

    exit;
}

?>
