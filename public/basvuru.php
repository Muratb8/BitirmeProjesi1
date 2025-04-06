<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvurular</title>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Icons (isteğe bağlı) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<div class="container-fluid">
<div class="row">   
<?php include '../includes/sidebar.php'; ?>
<main class="col-md-9 col-lg-10 p-4"> 
      <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="text-center">Başvurular</h2>

                <!-- Başvuru Tablosu -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Öğrenci Adı</th>
                            <th>Başvuru Tarihi</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="basvuruTablosu">
                        <!-- Başvurular buraya eklenecek -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
        </main>
    </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Script -->
    <script>
        $(document).ready(function() {
            // Başvuru verilerini simüle etmek için bir array oluşturuyoruz.
            var basvurular = [
                { id: 1, ogrenciAdi: 'Ali Yılmaz', basvuruTarihi: '2024-12-15', durum: 'Beklemede' },
                { id: 2, ogrenciAdi: 'Ayşe Demir', basvuruTarihi: '2024-12-16', durum: 'Beklemede' },
                { id: 3, ogrenciAdi: 'Mehmet Çelik', basvuruTarihi: '2024-12-17', durum: 'Beklemede' },
            ];

            // Başvuruları tabloya ekleme fonksiyonu
            function basvurularıListele() {
                $('#basvuruTablosu').empty(); // Tablodaki mevcut verileri temizle

                $.each(basvurular, function(index, basvuru) {
                    var durum = basvuru.durum === 'Beklemede' ? '<span class="badge bg-warning">Beklemede</span>' : '';
                    var row = '<tr>' +
                        '<td>' + basvuru.id + '</td>' +
                        '<td>' + basvuru.ogrenciAdi + '</td>' +
                        '<td>' + basvuru.basvuruTarihi + '</td>' +
                        '<td>' + durum + '</td>' +
                        '<td>' +
                            '<button class="btn btn-success onaylaBtn" data-id="' + basvuru.id + '">Onayla</button> ' +
                            '<button class="btn btn-danger reddetBtn" data-id="' + basvuru.id + '">Reddet</button>' +
                        '</td>' +
                    '</tr>';
                    $('#basvuruTablosu').append(row);
                });
            }

            // Başvuruları sayfada yükle
            basvurularıListele();

            // Onayla butonuna tıklama olayını dinleme
            $(document).on('click', '.onaylaBtn', function() {
                var basvuruId = $(this).data('id');
                // Başvuru durumunu 'Onaylandı' olarak güncelle
                basvurular.forEach(function(basvuru) {
                    if (basvuru.id === basvuruId) {
                        basvuru.durum = 'Onaylandı';
                    }
                });
                // Tabloyu yeniden listele
                basvurularıListele();
                // İlgili satırı kaldır
                $(this).closest('tr').fadeOut(function() {
                    $(this).remove();
                });
            });

            // Reddet butonuna tıklama olayını dinleme
            $(document).on('click', '.reddetBtn', function() {
                var basvuruId = $(this).data('id');
                // Başvuru durumunu 'Reddedildi' olarak güncelle
                basvurular.forEach(function(basvuru) {
                    if (basvuru.id === basvuruId) {
                        basvuru.durum = 'Reddedildi';
                    }
                });
                // Tabloyu yeniden listele
                basvurularıListele();
                // İlgili satırı kaldır
                $(this).closest('tr').fadeOut(function() {
                    $(this).remove();
                });
            });
        });
    </script>
</body>
</html>
