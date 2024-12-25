<?php
header("Content-Type: application/json");
session_start();
require_once '../config/database.php';

$response = array();

if (!isset($_SESSION['request_count'])) {
    $_SESSION['request_count'] = 0;
    $_SESSION['last_request_date'] = date('Y-m-d');
}

if ($_SESSION['last_request_date'] !== date('Y-m-d')) {
    $_SESSION['request_count'] = 0;
    $_SESSION['last_request_date'] = date('Y-m-d');
}

if ($_SESSION['request_count'] >= 200) {
    echo json_encode(['error' => 'You have reached the request limit of 200 per day.']);
    exit;
}

$_SESSION['request_count']++;

$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($type)) {
    echo json_encode(['error' => 'type is required']);
    exit;
}

$query = "SELECT id, name, creator, cover, link, caption, info, category, type 
                   FROM contents 
                   WHERE FIND_IN_SET(:type, type)";

if (!empty($id)) {
    $query .= " AND id = :id";
}

try {
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    if (!empty($id)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }

    $stmt->execute();
    $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($contents) {
        echo json_encode($contents);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching contents: ' . $e->getMessage()]);
    exit;
}
