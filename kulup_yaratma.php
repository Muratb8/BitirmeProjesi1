<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik Çizelgesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
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

        .badge-notify {
            background-color: red;
            position: absolute;
            top: 8px;
            right: 10px;
            font-size: 0.8em;
        }
        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }
        .content {
            flex-grow: 1;
            padding: 30px;
            margin-left: 220px;
            transition: margin-left 0.3s ease;
            width: 100%;
        }
        .content.shifted {
            margin-left: 0;
        }
        h2 {
            color: #007bff;
            margin-left: 200px; /* Başlığı sağa kaydır */
        }
        .toggle-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 1000;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 20px;
            text-align: left; /* Form elemanlarını sola hizala */
            padding-left: 30px; /* Formu biraz sola kaydır */
        }
        .card-body {
        margin-left: 10px; /* Daha sola çekmek için margin ayarlandı */
        padding: 20px; /* İç boşluğu dengeli tutmak için padding ekli */
        max-width: 400px; /* Genişliği sınırlandırarak kompakt bir görünüm sağlandı */
    }
    .form-container {
        margin-left: 200px; /* Kutucuğu sola çekmek için negatif margin */
        max-width: 400px; /* Daha kompakt bir genişlik ayarı */
        padding: 20px; /* İç boşluk dengesi */
        background-color: #f8f9fa; /* Arka plan rengi */
        border-radius: 8px; /* Köşeleri yuvarlama */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hafif gölge efekti */
    }
    </style>
</head>
<body>
  
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
    <div class="content" id="content">

        <h2>Kulüp Yaratma</h2>
        <div class="card mt-4 form-container">
            <div class="card-body">
                <h5 class="card-title">Kulüp Bilgileri</h5>
                <form>
                    <div class="mb-3">
                        <label for="clubName" class="form-label">Kulüp Adı</label>
                        <input type="text" class="form-control" id="clubName" placeholder="Kulüp adını giriniz">
                    </div>
                    <div class="mb-3">
                        <label for="presidentEmail" class="form-label">Başkan E-Posta</label>
                        <input type="email" class="form-control" id="presidentEmail" placeholder="E-posta adresini giriniz">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password" placeholder="Şifre giriniz">
                    </div>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
