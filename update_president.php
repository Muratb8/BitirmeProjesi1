<?php
require_once 'database.php'; // Veritabanı bağlantı dosyanız

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $ad = $_POST['ad'] ?? '';
    $soyad = $_POST['soyad'] ?? '';


    if (!$user_id) {
        echo json_encode(["status" => "error", "message" => "Başkan seçilmedi."]);
        exit;
    }

    try {
        $db = new Database();
        $updateQuery = "UPDATE clubpresidents SET 
                        ad = :ad, 
                        soyad= :soyad 
                        WHERE user_id = :user_id";

        $params = [
            ":user_id" => $user_id,
            ":ad" => $ad,
            ":soyad" => $soyad
        ];

        $result = $db->execute($updateQuery, $params);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "Başkan bilgileri güncellendi."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Güncelleme başarısız."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Hata oluştu: " . $e->getMessage()]);
    }
}
