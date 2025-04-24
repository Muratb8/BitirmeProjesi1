<?php

require_once 'database.php';
session_start();
// JSON yanıtı
header('Content-Type: application/json');

// Oturum kontrolü
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açmanız gerekiyor']);
    exit();
}

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek']);
    exit();
}

// POST verilerini al
$club_id = $_POST['club_id'] ?? null;
$message = $_POST['message'] ?? null;
$clubpresident_id = $_POST['clubpresident_id'] ?? null;
$user_id = $_SESSION['id'];

// Veri kontrolü
if (!$club_id || !$message || !$clubpresident_id) {
    echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurun']);
    exit();
}

if (!is_numeric($club_id) || !is_numeric($clubpresident_id)) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz kulüp veya başkan ID']);
    exit();
}

if (strlen($message) > 500) {
    echo json_encode(['success' => false, 'message' => 'Mesaj 500 karakteri aşmamalı']);
    exit();
}

// Giriş temizliği (XSS riskine karşı, DB'ye değil ama çıkışta yine filtrelenmeli)
$clean_message = htmlspecialchars(trim($message), ENT_QUOTES, 'UTF-8');

try {
    $db = new Database();
    $db->getConnection();

    // Öğrenci kimliğini al
    $student = $db->getRow("SELECT student_id FROM students WHERE user_id = ?", [$user_id]);

    if (!$student) {
        echo json_encode(['success' => false, 'message' => 'Öğrenci bulunamadı']);
        exit();
    }

    $student_id = $student['student_id'];

    // Veritabanına ekle
    $data = [
        'student_id' => $student_id,
        'president_id' => $clubpresident_id,
        'message' => $clean_message,
        'date' => date('Y-m-d H:i:s')
    ];

    $result = $db->insertData('messages', $data);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Mesajınız başarıyla gönderildi']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Mesaj gönderilirken bir hata oluştu']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Hata: ' . $e->getMessage()]);
}
?>
