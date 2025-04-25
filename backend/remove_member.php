<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

// Oturum ve yetki kontrolü
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açmanız gerekiyor']);
    exit();
}

// POST verilerini al
$user_id = $_POST['user_id'] ?? null;
$club_id = $_POST['club_id'] ?? null;

if (!$user_id || !$club_id) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz veri']);
    exit();
}

try {
    $db = new Database();
    $db->getConnection();

    // Üyeyi kulüpten çıkar
    $sql = "DELETE FROM clubmembers WHERE user_id = ? AND club_id = ?";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$user_id, $club_id]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Üye başarıyla çıkarıldı']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Üye çıkarılırken bir hata oluştu']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Hata: ' . $e->getMessage()]);
}
?> 