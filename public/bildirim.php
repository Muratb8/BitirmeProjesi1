<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bildirimler</title>
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../public/giris.php");
    exit();
}

$role = $_SESSION['role']; // Kullanıcının rolünü al

?>
    <!-- Harici CSS dosyası -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
       
  
        .notification-card {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .notification-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .notification-card .notification-header {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .notification-card .notification-body {
            font-size: 1rem;
            color: #555;
        }
        .notification-card .notification-time {
            font-size: 0.9rem;
            color: #777;
            text-align: right;
        }
        .notification-card .notification-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0d6efd;
            display: inline-block;
            margin-right: 10px;
        }
        .notification-card .join-button {
            background-color: #28a745; /* Yeşil renk */
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .notification-card .join-button:hover {
            background-color: #218838; /* Hover durumunda daha koyu yeşil */
        }
      
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <?php include '../includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
            <nav class="navbar navbar-dark bg-dark d-md-none">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Menü</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
         
            <div class="collapse d-md-none" id="mobileMenu">
                <a href="index.html" class="d-block text-dark bg-light p-2">Ana Sayfa</a>
                <a href="kulub.html" class="d-block text-dark bg-light p-2">Kulüpler</a>
                <a href="message_room.html" class="d-block text-dark bg-light p-2">Sohbet Odası</a>
                <a href="bildirim.html" class="d-block text-dark bg-light p-2">Bildirimler</a>
                <a href="etkinlik.html" class="d-block text-dark bg-light p-2">Etkinlikler</a>
                <a href="ders_cizergesi.html" class="d-block text-dark bg-light p-2">Ders Çizergesi</a>
            </div>

            <!-- Bildirimler Sayfası -->
            <main class="col-md-9 col-lg-10 p-4">
                <!-- Sağ Üst Köşe İkonlar -->
 <div class="top-icons">
    <i class="bi bi-moon"></i> <!-- Gece Modu İkonu -->
    <i class="bi bi-bell"></i> <!-- Bildirim Çanı İkonu -->
    <i class="bi bi-chat-dots"></i> <!-- Mesajlar İkonu -->
    <i class="bi bi-person-circle"></i> <!-- Profil İkonu -->
</div>
                 <!-- Arama ve Profil Alanı -->

                <h2>Bildirimler</h2>
                <div class="notification-card" id="notification-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="notification-dot"></span>
                            <span class="notification-header">Yeni Etkinlik: Spor Turnuvası</span>
                        </div>
                        <div class="notification-time">3 saat önce</div>
                    </div>
                    <div class="notification-body">
                        Spor kulübü tarafından düzenlenen yıl sonu turnuvası hakkında detayları öğrenmek için tıklayın.
                    </div>
                    <button class="join-button" onclick="joinEvent('notification-1')">Katıl</button>
                </div>
                <div class="notification-card" id="notification-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="notification-dot"></span>
                            <span class="notification-header">Sanat Galerisi Açılışı</span>
                        </div>
                        <div class="notification-time">1 gün önce</div>
                    </div>
                    <div class="notification-body">
                        Sanat kulübü yeni açılacak galerisini tanıtmak için bir etkinlik düzenliyor. Katılımınızı bekliyoruz!
                    </div>
                    <button class="join-button" onclick="joinEvent('notification-2')">Katıl</button>
                </div>
                <div class="notification-card" id="notification-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="notification-dot"></span>
                            <span class="notification-header">Bilimsel Konferans</span>
                        </div>
                        <div class="notification-time">2 gün önce</div>
                    </div>
                    <div class="notification-body">
                        Bilim kulübü tarafından düzenlenen konferansın detaylarına göz atın.
                    </div>
                    <button class="join-button" onclick="joinEvent('notification-3')">Katıl</button>
                </div>
            </main>
        </div>
    </div>

      <?php include_once '../includes/right_top_menu.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function joinEvent(notificationId) {
            // Tıklanan bildirim kartını gizle
            var notificationCard = document.getElementById(notificationId);
            notificationCard.style.display = 'none';
        }
    </script>
</body>
</html>
