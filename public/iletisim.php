<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik Çizelgesi</title>
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
.content {
    flex-grow: 1;
    padding: 30px;
    width: 100%; /* İçerik kısmını %100 genişlikte tutuyoruz */
    overflow-x: hidden; /* İçeriğin taşmasını engeller */
    transition: transform 0.3s ease; /* Transform ile içerik kısmını kaydırabiliriz */
}

.content.shifted {
    transform: translateX(220px); /* Sidebar açıldığında içerik kısmını sabit bırakıp sadece sidebar'ı kaydırıyoruz */
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

.team-member-card {
    margin-bottom: 20px;
    width: 100%; /* Card genişliğini %100 yaparak büyümeyi engeller */
    max-width: 300px; /* Maksimum genişlik vererek kartların fazla genişlemesini engeller */
}

.card-body {
    padding: 15px;
}

.card-img-top {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .content {
        margin-left: 0;
        width: 100%;
    }

    .sidebar {
        width: 100%;
        transform: translateX(-100%);
    }

    .sidebar.open {
        transform: translateX(0);
    }
}

    </style>
</head>
<body>

<?php include '../includes/sidebar.php'; ?>
    <button id="toggleSidebar" class="btn btn-primary position-fixed" style="top: 10px; left: 10px; z-index: 1000;">
        <i class="bi bi-list"></i>
    </button>

    <div class="content" id="content">
        <h2>Önemli Kişiler</h2>
        
        <!-- Bootstrap Card Structure -->
        <div class="row">
            <div class="col-md-4">
                <div class="card team-member-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Member Image">
                    <div class="card-body">
                        <h5 class="card-title">Ali Veli</h5>
                        <p class="card-text">Başkan</p>
                        <div class="contact-info">
                            <p><i class="bi bi-phone"></i> +90 555 123 45 67</p>
                            <p><i class="bi bi-envelope"></i> ali.veli@email.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card team-member-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Member Image">
                    <div class="card-body">
                        <h5 class="card-title">Ayşe Demir</h5>
                        <p class="card-text">Başkan Yardımcısı</p>
                        <div class="contact-info">
                        <p><i class="bi bi-phone"></i> +90 555 234 56 78</p>
                        <p><i class="bi bi-envelope"></i> ayse.demir@email.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card team-member-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Member Image">
                    <div class="card-body">
                        <h5 class="card-title">Mehmet Can</h5>
                        <p class="card-text">Organizasyon Sorumlusu</p>
                        <div class="contact-info">
                            <p><i class="bi bi-phone"></i> +90 555 345 67 89</p>
                            <p><i class="bi bi-envelope"></i> mehmet.can@email.com</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <script>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
