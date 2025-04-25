<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik Çizelgesi</title>
        <!-- Harici CSS dosyası -->
        <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../public/giris.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$excludePages = ['giris.php'];

if (!in_array($currentPage, $excludePages)) {
    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
}
$role = $_SESSION['role']; // Kullanıcının rolünü al
// Sadece "manager" veya "developer" rolüne izin ver
if ($role !== 'manager' && $role !== 'developer') {
    // Eğer daha önceki sayfa kayıtlıysa oraya dön
    if (isset($_SESSION['previous_page'])) {
        header("Location: " . $_SESSION['previous_page']);
    } else {
        // Önceki sayfa yoksa varsayılan sayfaya gönder
        header("Location: ../index.php");
    }
    exit();
}


?>
    <style>
        .content {
            flex-grow: 1;
            padding: 30px;
            margin-left: 220px;
            transition: margin-left 0.3s ease;
        }
        .content.shifted {
            margin-left: 0;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-bordered {
            border: 2px solid #007bff;
        }
        .table-light {
            background-color: #e9ecef;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        h2 {
            color: #007bff;
        }
        .table td {
            background-color: #ffffff;
        }
        .table td:hover {
            background-color: #f1f1f1;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .nav-item:hover {
            background-color: #495057;
            border-radius: 4px;
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
        .box {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer; /* Tıklama simgesini aktif eder */
    transition: background-color 0.3s ease; /* Arka plan rengi geçişi için animasyon */
}

/* Hover efekti ile kutucuğun arka planını mavi yapmak */
.box:hover {
    background-color: #5bc0de; /* Mavi renk */
    color: white; /* Yazıyı beyaz yapar */
}
        .box h5 {
            color: #007bff;
            font-size: 1.2rem;
        }
        .box p {
            font-size: 1rem;
            color: #333;
        }
      
        @media (max-width: 768px) {
            .row {
                margin-left: 0; /* Mobilde margin kaldırılacak */
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
<div class="row">
<?php include '../includes/sidebar.php'; ?>
<?php include '../includes/mobil_menu.php'?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4" id="content">
    <div class="content" id="content">
        <div class="container">
            <h2>Etkinlik Çizelgesi</h2>
            <div class="row">
                <!-- Etkinlik ve Kulüp Adı Kutucukları -->
                <div class="col-md-4">
                    <div class="box">
                        <h5>Etkinlik Adı: Konferans</h5>
                        <p>Kulüp Adı: Teknoloji Kulübü</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <h5>Etkinlik Adı: Seminer</h5>
                        <p>Kulüp Adı: Sağlık Kulübü</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <h5>Etkinlik Adı: Atölye</h5>
                        <p>Kulüp Adı: Tasarım Kulübü</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    </script>

 
</body>
</html>
