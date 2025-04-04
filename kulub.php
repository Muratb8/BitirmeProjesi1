<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulüpler</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: giris.php");
    exit();
}

$role = $_SESSION['role']; // Kullanıcının rolünü al
?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .sidebar {
            background-color: #2E49A5;
            color: white;
            min-height: 100vh;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0E315A;
            color: white;
            border-left: 4px solid #0d6efd;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #0d6efd;
            object-fit: cover;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .search-bar {
            border: 2px solid #0d6efd;
            border-radius: 50px;
            padding: 8px 15px;
        }
        .badge-notify {
            background-color: red;
            position: absolute;
            top: 8px;
            right: 10px;
            font-size: 0.8em;
        }
        footer {
            background-color: #212529;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .club-logo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        .btn-custom {
            width: 100px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
        table {
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #fff;
        }
        thead {
            background-color: #0d6efd;
            color: white;
        }
        th {
            border: none;
            font-weight: 600;
        }
        td {
            vertical-align: middle;
            border: none;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status {
            font-weight: bold;
            color: #dc3545;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        .btn-reject:hover {
            background-color: #c82333;
        }
        .btn-apply {
            background-color: #28a745;
            color: white;
        }
        .btn-apply:hover {
            background-color: #218838;
        }
        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }
                 /* Sağ üstteki ikonlar için stil */
                 .top-icons {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .top-icons i {
            font-size: 1.5rem;
            margin-left: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
          <!-- Sidebar -->
          <nav class="col-md-3 col-lg-2 sidebar d-none d-md-block position-relative" id="sidebar">
            <h4 class="text-center py-4"><img src="DAÜ.png"></h4>

            <!-- Öğrenci rolü için menü öğeleri -->
   <?php if ($role === 'student'): ?>
                <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
                <a href="kulub.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
                <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
                <a href="bildirim.php" class="position-relative">
                    <i class="bi bi-bell-fill"></i> Bildirimler
                    <span class="badge badge-notify">3</span>
                </a>
                <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
                <a href="ders_cizergesi.php"><i class="bi bi-layout-text-sidebar-reverse"></i> Ders Çizergesi</a>
            <?php elseif ($role === 'club_president'): ?>
                <!-- Kulüp Başkanı rolü için menü öğeleri -->
                <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
                <a href="kulub.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
                <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
                <a href="bildirim.php" class="position-relative">
                    <i class="bi bi-bell-fill"></i> Bildirimler
                    <span class="badge badge-notify">3</span>
                </a>
                <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
                <a href="kulup_bilgileri(baskan).php"><i class="bi bi-info-circle-fill"></i> Kulüp Bilgileri</a>
                <a href="basvuru.php"><i class="bi bi-file-earmark-person-fill"></i> Başvurular</a>
            <?php elseif ($role === 'manager'): ?>
                <!-- Manager rolü için menü öğeleri -->
                <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
                <a href="kulub.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
                <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
                <a href="bildirim.php" class="position-relative">
                    <i class="bi bi-bell-fill"></i> Bildirimler
                    <span class="badge badge-notify">3</span>
                </a>
                <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
                <a href="aktivite_merkezi_sorumlusu.php"><i class="bi bi-person-badge-fill"></i> Aktivite Merkezi Sorumlusu</a>
                <a href="istek.php"><i class="bi bi-box-arrow-in-down"></i> İstek</a>
            <?php elseif ($role === 'developer'): ?>
                <!-- Developer rolü için tüm menü öğeleri -->
                <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
                <a href="kulub.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
                <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
                <a href="bildirim.php" class="position-relative">
                    <i class="bi bi-bell-fill"></i> Bildirimler
                    <span class="badge badge-notify">3</span>
                </a>
                <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
                <a href="Etkinlik_yaratma.php"><i class="bi bi-plus-circle-fill"></i> Etkinlik Yaratma</a>
                <a href="duyuru_yaratma.php"><i class="bi bi-megaphone-fill"></i> Duyuru Yaratma</a>
                <a href="kulup_bilgileri(baskan).php"><i class="bi bi-info-circle-fill"></i> Kulüp Bilgileri</a>
                <a href="basvuru.php"><i class="bi bi-file-earmark-person-fill"></i> Başvurular</a>
                <a href="kulub_bilgileri.php"><i class="bi bi-clipboard-data-fill"></i> Kulüp Bilgileri</a>
            <?php endif; ?>
        </nav>
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

           
            <main class="col-md-9 col-lg-10 p-4">
                <!-- Sağ Üst Köşe İkonlar -->
 <div class="top-icons">
    <i class="bi bi-moon"></i> <!-- Gece Modu İkonu -->
    <i class="bi bi-bell"></i> <!-- Bildirim Çanı İkonu -->
    <i class="bi bi-chat-dots"></i> <!-- Mesajlar İkonu -->
    <i class="bi bi-person-circle"></i> <!-- Profil İkonu -->
</div>
             

            <!-- Kulüpler Tablosu -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Kulüp Adı</th>
                        <th>Üyelik Durumu</th>
                        <th>Başvuru</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="apple.png" class="club-logo" alt="Kulüp 1"></td>
                        <td>Müzik Sevenler Kulübü</td>
                        <td class="status">Başvurulmadı</td>
                        <td><button class="btn btn-apply btn-custom" onclick="toggleApplication(this)">Başvur</button></td>
                    </tr>
                    <tr>
                        <td><img src="facebook.png" class="club-logo" alt="Kulüp 2"></td>
                        <td>Kitap Kulübü</td>
                        <td class="status">Başvurulmadı</td>
                        <td><button class="btn btn-apply btn-custom" onclick="toggleApplication(this)">Başvur</button></td>
                    </tr>
                    <tr>
                        <td><img src="instagram.png" class="club-logo" alt="Kulüp 3"></td>
                        <td>Spor Kulübü</td>
                        <td class="status">Başvurulmadı</td>
                        <td><button class="btn btn-apply btn-custom" onclick="toggleApplication(this)">Başvur</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
        function toggleApplication(button) {
            var row = button.closest("tr");
            var statusCell = row.querySelector(".status");
            if (statusCell.innerHTML === "Başvurulmadı") {
                statusCell.innerHTML = "Değerlendiriliyor";
                button.innerHTML = "Reddet";
                button.classList.add("btn-reject");
                button.classList.remove("btn-apply");
            } else if (statusCell.innerHTML === "Değerlendiriliyor") {
                statusCell.innerHTML = "Başvurulmadı";
                button.innerHTML = "Başvur";
                button.classList.add("btn-apply");
                button.classList.remove("btn-reject");
            }
        }
    </script>
</body>
</html>
