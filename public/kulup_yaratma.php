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
$role = $_SESSION['role']; // Kullanıcının rolünü al
?>
    <style>
        .content {
            margin-left:120px;
            width: 100%;
        }
        h2 {
            color: #007bff;
            margin-left: 200px; /* Başlığı sağa kaydır */
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
<div class="container-fluid">
  <div class="row">

  <?php include '../includes/sidebar.php'; ?>
  <?php include '../includes/mobil_menu.php'?>
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4" id="content">
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
        
        </main>
 
    </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
