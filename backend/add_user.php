<?php

include_once 'database.php';
session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açmanız gerekiyor']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $db = new Database();
    $db->getConnection(); // Veritabanı bağlantısını sağla
    // Verileri al
    $userEmail = $_POST['userEmail'];
    $userRole = $_POST['userRole'];

     // E-posta adresinin daha önce kullanılıp kullanılmadığını kontrol et
     $existingUser = $db->getRow("SELECT * FROM users WHERE email = ?", [$userEmail]);

     if ($existingUser) {
        // Eğer e-posta zaten varsa, oturuma hata mesajı ekle
        $_SESSION['message'] = ['text' => 'Bu e-posta adresi zaten kayıtlı!', 'type' => 'danger'];
        header("Location: ../public/index.php");
        exit;
    }
    // Yeni kullanıcı ekle
    $data = [
        'email' => $userEmail, // email'yi de eklemeyi unutmayın
        'PASSWORD' => '1', // Şifreyi doğrudan "1" olarak ayarla
        'role' => $userRole,
    ];

    $userId = $db->insertData('users', $data);

    // Eğer öğrenci ise, 'students' tablosuna ekle
    if ($userRole == 'student') {
        $db->insertData('students', ['user_id' => $userId]);
    }
    
    // Eğer kulüp başkanı ise, 'club_presidents' tablosuna ekle
    if ($userRole == 'club_president') {
        $db->insertData('clubpresidents', ['user_id' => $userId]);
    }
      // Başarılı bir şekilde kullanıcı eklediysen, oturuma başarı mesajı ekle
      $_SESSION['message'] = ['text' => 'Kullanıcı başarıyla kaydedildi!', 'type' => 'success'];
      
    // Kullanıcıyı index sayfasına yönlendirmek için header kullanılabilir
    header("Location: ../public/index.php");
}
?>
