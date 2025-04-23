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
require_once 'database.php';
$db = new Database();
$db->getConnection();
$clubs = $db->getData('clubs', 'id, name, clubpresident_id');
?>
    <!-- Custom CSS -->
    <style>
       
        .club-container {
            position: absolute;
            top: 50px;
            left: 320px; /* Biraz daha sağa kaydırıldı */
            display: flex;
            flex-direction: column;
        }
        .club-box {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px 60px; /* Dikey küçültüldü, yatay büyütüldü */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            font-size: 1.2rem;
            text-align: center;
            cursor: pointer;
        }
        .club-box + .club-box {
            margin-top: 0; /* Aradaki boşluk kaldırıldı */
        }
        .club-box:hover {
            transform: scale(1.05);
            background-color: #f8f9fa;
        }
        .club-box.active {
            background-color: #0d6efd;
            color: white;
        }
        footer {
            background-color: #212529;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .notification-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background-color: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            line-height: 20px;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .club-box {
            position: relative; /* Kareyi doğru konumlandırmak için relative konumlandırma */
        }

        .club-box.active::after {
            background-color: #0d6efd; /* Tıklandığında kare görünür hale gelir */
        }

        .selected-box {
            position: absolute;
            width: 200px;
            height: 200px;
            background-color: rgba(0, 123, 255, 0.5);
            border: 2px solid #007bff;
            display: none; /* Başlangıçta görünmez */
            z-index: 10;
            transition: all 0.3s ease-in-out;
        }
        .chat-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 70%;
            background-color: #ffffff;
            border: 2px solid #0d6efd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none; /* Başlangıçta görünmez */
            overflow: hidden;
        }

        .chat-box-header {
            background-color: #0d6efd;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .chat-box-content {
            padding: 20px;
            overflow-y: auto;
            height: calc(100% - 60px);
            font-size: 1rem;
        }
     
    </style>
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
