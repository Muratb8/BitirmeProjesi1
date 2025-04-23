<?php
session_start();
require_once 'database.php'; // Veritabanı bağlantı dosyanız


if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açmanız gerekiyor']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $gpa = $_POST['gpa'] ?? '';
    $cgpa = $_POST['cgpa'] ?? '';
    $birth_place = $_POST['birth_place'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (!$user_id) {
        echo json_encode(["status" => "error", "message" => "Öğrenci seçilmedi."]);
        exit;
    }

    try {
        $db = new Database();
        $updateQuery = "UPDATE students SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        gpa = :gpa, 
                        cgpa = :cgpa, 
                        birth_place = :birth_place, 
                        birth_date = :birth_date, 
                        gender = :gender 
                        WHERE user_id = :user_id";

        $params = [
            ":user_id" => $user_id,
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":gpa" => $gpa,
            ":cgpa" => $cgpa,
            ":birth_place" => $birth_place,
            ":birth_date" => $birth_date,
            ":gender" => $gender
        ];

        $result = $db->execute($updateQuery, $params);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "Öğrenci bilgileri güncellendi."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Güncelleme başarısız."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Hata oluştu: " . $e->getMessage()]);
    }
}
