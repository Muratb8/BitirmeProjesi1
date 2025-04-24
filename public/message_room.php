<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulüpler</title>
      <!-- Harici CSS dosyası -->
      <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../public/giris.php");
    exit();
}
$role = $_SESSION['role']; // Kullanıcının rolünü al

// Veritabanı bağlantısı ve kulüpleri çekme
require_once '../backend/database.php';
$db = new Database();
$db->getConnection();
$clubs = $db->getData('clubs', 'id, name, clubpresident_id');
?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <?php include '../includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
        <?php include '../includes/mobil_menu.php'?>
        
            <main class="col-md-9 col-lg-10 p-4">

    <h1 class="mb-4">Kulüple ilgili istek/dilek/şikayet</h1>
    <form>
    <!-- Kulüp Adları -->
    <div class="mb-3">
        <label for="clubName" class="form-label">Kulüp Adı</label>
        <select class="form-select" id="clubName">
            <option value="" disabled selected>Bir kulüp seçin</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?php echo $club['id']; ?>"  data-president-id="<?php echo $club['clubpresident_id']; ?>"><?php echo htmlspecialchars($club['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="clubNameHelp" class="form-text">Kulüp adını doğru seçtiğinizden emin olun.</div>
    </div>
    <!-- Açıklama Yazısı -->
    <div class="mb-3">
        <label for="clubDescription" class="form-label">Açıklama</label>
        <textarea class="form-control" id="clubDescription" rows="3" placeholder="Kulüple ilgili İsteklerinizi, şikayetlerinizi ve fikirlerinizi belirtin"></textarea>
        <div id="clubDescriptionHelp" class="form-text">Kulüple ilgili şikayetlerinizi ve fikirlerinizi belirtin</div>
    </div>
    <!-- Gönder Butonu -->
    <button type="button" class="btn btn-primary" id="sendMessage" >Gönder</button>
    <div id="messageResponse" class="mt-3"></div>
</form>
</main>
        </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <!-- Bootstrap JS (Optional for some functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
     
     document.getElementById("sendMessage").addEventListener("click", function () {
            const clubId = document.getElementById("clubName").value;
            const message = document.getElementById("clubDescription").value;
            const responseDiv = document.getElementById("messageResponse");
            const selectedOption = document.getElementById("clubName").options[document.getElementById("clubName").selectedIndex];
            const clubpresident_id = selectedOption.getAttribute("data-president-id");

            if (!clubId || !message) {
                responseDiv.innerHTML = '<div class="alert alert-danger">Lütfen tüm alanları doldurun!</div>';
                return;
            }
            // AJAX isteği gönder
            $.ajax({
                url: '../backend/message_send.php',
                type: 'POST',
                data: {
                    club_id: clubId,
                    message: message,
                    clubpresident_id: clubpresident_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        responseDiv.innerHTML = '<div class="alert alert-success">' + response.message + '</div>';
                        document.getElementById("clubDescription").value = '';
                        document.getElementById("clubName").value = '';
                    } else {
                        responseDiv.innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    responseDiv.innerHTML = '<div class="alert alert-danger">Bir hata oluştu. Lütfen tekrar deneyin.</div>';
                }
            });
        });
    </script>
</body>
</html>
