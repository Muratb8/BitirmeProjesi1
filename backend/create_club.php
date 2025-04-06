<?php
session_start();
include_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $db->getConnection(); // Veritabanı bağlantısını sağla

    // Verileri al
    $clubName = $_POST['clubName'];
    $clubDescription = $_POST['clubDescription'];
    $clubLogo = $_FILES['clubLogo']['name'];
    $clubPresident = $_POST['clubPresident']; // Seçilen kulüp başkanı


    // Logo yükleme işlemi
    if ($_FILES['clubLogo']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["clubLogo"]["name"]);
        move_uploaded_file($_FILES["clubLogo"]["tmp_name"], $targetFile);
    }

    // Kulüp verisini ekle
    $data = [
        'name' => $clubName,
        'description' => $clubDescription,
        'logo' => $clubLogo,
        'clubpresident_id' => $clubPresident, // Seçilen kulüp başkanı
    ];
    
    // Kulüp ekleme işlemi
    if ($db->insertData('clubs', $data)) {
        $_SESSION['message'] = ['text' => 'kulüp başarıyla kaydedildi!', 'type' => 'success'];
    } else {
        $_SESSION['message'] = ['text' => "Kulüp eklenirken bir hata oluştu!", 'type' => "danger"];
    }
    header("Location: index.php");
}
?>
