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
    <!-- Custom CSS -->
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../public/giris.php");
    exit();
}

$role = $_SESSION['role']; // Kullanıcının rolünü al

?>
    <style>
     
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                        <td><img src="../uploads/apple.png" class="club-logo" alt="Kulüp 1"></td>
                        <td>Müzik Sevenler Kulübü</td>
                        <td class="status">Başvurulmadı</td>
                        <td><button class="btn btn-apply btn-custom" onclick="toggleApplication(this)">Başvur</button></td>
                    </tr>
                    <tr>
                        <td><img src="../uploads/facebook.png" class="club-logo" alt="Kulüp 2"></td>
                        <td>Kitap Kulübü</td>
                        <td class="status">Başvurulmadı</td>
                        <td><button class="btn btn-apply btn-custom" onclick="toggleApplication(this)">Başvur</button></td>
                    </tr>
                    <tr>
                        <td><img src="../uploads/instagram.png" class="club-logo" alt="Kulüp 3"></td>
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
