<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Yaratma</title>
    <?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: giris.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$excludePages = ['giris.php'];

if (!in_array($currentPage, $excludePages)) {
    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
}
$role = $_SESSION['role']; // Kullanıcının rolünü al
// Sadece "manager" veya "developer" rolüne izin ver
if ($role !== 'club_president' && $role !== 'developer') {
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

    <!-- Harici CSS dosyası -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
       
        .container {
            margin-top: 50px;
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">

        <?php include '../includes/sidebar.php'; ?>
                  <!-- Mobil Hamburger Menü -->
                  <?php include_once '../includes/mobil_menu.php'; ?>
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="container">
                    <h2 class="form-title">Duyuru Yaratma</h2>
                    <form id="announcementForm">
                        <!-- Duyuru Başlığı -->
                        <div class="mb-3">
                            <label for="announcementTitle" class="form-label">Duyuru Başlığı</label>
                            <input type="text" class="form-control" id="announcementTitle" name="title" placeholder="Duyuru başlığını girin" required>
                            <div id="announcementTitleHelp" class="form-text">Duyuru başlığını doğru girin, başlık önemlidir.</div>
                        </div>

                        <!-- Duyuru İçeriği -->
                        <div class="mb-3">
                            <label for="announcementContent" class="form-label">Duyuru İçeriği</label>
                            <textarea class="form-control" id="announcementContent" name="content" rows="4" placeholder="Duyuru içeriğini buraya yazın" required></textarea>
                            <div id="announcementContentHelp" class="form-text">Duyuru içeriğini ayrıntılı bir şekilde yazın.</div>
                        </div>

                        <!-- Duyuru Kategorisi -->
                        <div class="mb-3">
                            <label for="announcementCategory" class="form-label">Duyuru Kategorisi</label>
                            <select class="form-select" id="announcementCategory" name="category" required>
                                <option value="" disabled selected>Bir kategori seçin</option>
                                <option value="general">Genel</option>
                                <option value="event">Etkinlik</option>
                                <option value="meeting">Toplantı</option>
                                <option value="news">Haberler</option>
                            </select>
                            <div id="announcementCategoryHelp" class="form-text">Duyuru kategorisini seçin.</div>
                        </div>

                        <!-- Gönderme Zamanı -->
                        <div class="mb-3">
                            <label for="announcementDate" class="form-label">Etkinliğin Tarihi</label>
                            <input type="datetime-local" class="form-control" id="announcementDate" name="date" required>
                            <div id="announcementDateHelp" class="form-text">Etkinliğin tarihi ve saati seçin.</div>
                        </div>

                        <!-- Gönder Butonu -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Duyuruyu Gönder</button>
                        </div>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <!-- Bootstrap JS ve Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#announcementForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = {
                    title: $('#announcementTitle').val(),
                    content: $('#announcementContent').val(),
                    category: $('#announcementCategory').val(),
                    date: $('#announcementDate').val()
                };

                $.ajax({
                    url: '../backend/announcement_send.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#announcementForm')[0].reset();
                        } else {
                            $('#responseMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#responseMessage').html('<div class="alert alert-danger">Bir hata oluştu. Lütfen tekrar deneyin.</div>');
                        console.log('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
