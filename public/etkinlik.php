<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlikler</title>
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
        .event-container {
            position: absolute;
            top: 50px;
            left: 320px;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .event-box {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            font-size: 1.2rem;
            text-align: center;
            cursor: pointer;
            margin-bottom: 15px; /* Her etkinlik kutusu arasına boşluk eklendi */
            position: relative; /* Konumlandırma */
        }
        .event-box:hover {
            transform: scale(1.05);
            background-color: #f8f9fa;
        }
        .event-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .line {
            border-top: 2px solid #0d6efd;
            margin-bottom: 10px;
        }
        .event-details {
            font-size: 1rem;
        }
        .event-box .star {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            color: #0d6efd;
            cursor: pointer;
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
            </div>

            <main class="col-md-9 col-lg-10 p-4">
       
                <!-- Etkinlik Kutuları -->
                <div class="event-container">
                    <div class="event-box">
                        <i class="bi bi-star star"></i> <!-- Yıldız simgesi -->
                        <div class="event-title">Spor Etkinliği</div>
                        <div class="line"></div>
                        <div class="event-details">
                            <strong>Zaman:</strong> 15 Ocak 2024, 10:00<br>
                            <strong>Mekan:</strong> Spor Salonu A
                        </div>
                    </div>
                    <div class="event-box">
                        <i class="bi bi-star star"></i> <!-- Yıldız simgesi -->
                        <div class="event-title">Sanat Sergisi</div>
                        <div class="line"></div>
                        <div class="event-details">
                            <strong>Zaman:</strong> 18 Ocak 2024, 14:00<br>
                            <strong>Mekan:</strong> Kültür Merkezi
                        </div>
                    </div>
                    <div class="event-box">
                        <i class="bi bi-star star"></i> <!-- Yıldız simgesi -->
                        <div class="event-title">Bilim Fuarı</div>
                        <div class="line"></div>
                        <div class="event-details">
                            <strong>Zaman:</strong> 22 Ocak 2024, 09:00<br>
                            <strong>Mekan:</strong> Bilim Merkezi
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>

    <!-- Bootstrap JS, Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
    </script>
</body>
</html>
