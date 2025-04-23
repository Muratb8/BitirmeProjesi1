<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik Yaratma</title>
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
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: white !important;
        }
        .navbar-nav .nav-link {
            color: white !important;
        }
        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 30px;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        .form-check-label {
            font-size: 1.1rem;
        }
        .form-check {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">

        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/mobil_menu.php'?>
    <div class="container">
        <h2 class="form-title">Etkinlik Yaratma</h2>


        <form>
            <!-- Resim Ekleme -->
            <div class="mb-3">
                <label for="activityImage" class="form-label">Resim Ekle</label>
                <input type="file" class="form-control" id="activityImage" name="activityImage">
            </div>

            <!-- Aktivite Konusu -->
            <div class="mb-3">
                <label for="activityTopic" class="form-label">Aktivitenin Konusu</label>
                <input type="text" class="form-control" id="activityTopic" name="activityTopic" placeholder="Aktivitenin konusu" required>
            </div>

            <!-- Aktivite Tarihi -->
            <div class="mb-3">
                <label for="activityDate" class="form-label">Aktivite Tarihi</label>
                <input type="date" class="form-control" id="activityDate" name="activityDate" required>
            </div>

            <!-- Katılımcıların İsmi -->
            <div class="mb-3">
                <label for="participants" class="form-label">Katılımcıların İsmi</label>
                <input type="text" class="form-control" id="participants" name="participants" placeholder="Katılımcıların ismi" required>
            </div>

            <!-- İhtiyaçlar Başlığı -->
            <h4 class="form-section-title">İhtiyaçlar</h4>

             <!-- Salon Rezervasyonu -->
             <div class="form-check">
                <input class="form-check-input" type="checkbox" value="salonRezervasyonu" id="salonRezervasyonu" onchange="toggleSalonInput()">
                <label class="form-check-label" for="salonRezervasyonu">
                    Salon Rezervasyonu
                </label>
            </div>

            <!-- Salon Rezervasyonu Text Alanı -->
            <div class="mb-3" id="salonInput" style="display:none;">
                <label for="salonDetails" class="form-label">Salon Rezervasyonu Detayları</label>
                <textarea class="form-control" id="salonDetails" name="salonDetails" placeholder="Salon rezervasyonu için detayları girin..."></textarea>
            </div>

            <div class="form-group">
                <input type="checkbox" id="banner" name="banner">
                <label for="banner">Pankart</label>
                <div class="additional-input" id="bannerInput" style="display:none;">
                    <label for="bannerDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="bannerDetails" name="bannerDetails">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="printing" name="printing">
                <label for="printing">Baskı</label>
                <div class="additional-input" id="printingInput" style="display:none;">
                    <label for="printingDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="printingDetails" name="printingDetails">
                </div>
            </div>

        <div class="form-group">
                <input type="checkbox" id="flowers" name="flowers">
                <label for="flowers">Çiçek</label>
                <div class="additional-input" id="flowersInput" style="display:none;">
                    <label for="flowersDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="flowersDetails" name="flowersDetails">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="plaque" name="plaque">
                <label for="plaque">Plaket</label>
                <div class="additional-input" id="plaqueInput" style="display:none;">
                    <label for="plaqueDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="plaqueDetails" name="plaqueDetails">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="medal" name="medal">
                <label for="medal">Madalya</label>
                <div class="additional-input" id="medalInput" style="display:none;">
                    <label for="medalDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="medalDetails" name="medalDetails">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="food" name="food">
                <label for="food">Yiyecek</label>
                <div class="additional-input" id="foodInput" style="display:none;">
                    <label for="foodDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="foodDetails" name="foodDetails">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="drink" name="drink">
                <label for="drink">İçecek</label>
                <div class="additional-input" id="drinkInput" style="display:none;">
                    <label for="drinkDetails">Detayları Giriniz:</label>
                    <input type="text" class="form-control" id="drinkDetails" name="drinkDetails">
                </div>
            </div>

        <!-- Konaklama -->
        <div class="form-group">
            <input type="checkbox" id="accommodation" name="accommodation">
            <label for="accommodation">Konaklama</label>
            <div class="additional-input" id="accommodationInput" style="display:none;">
                <label for="accommodationDetails">Detayları Giriniz:</label>
                <input type="text" class="form-control" id="accommodationDetails" name="accommodationDetails">
            </div>
        </div>

        <!-- Yurtdışı Ulaşımı -->
        <div class="form-group">
            <input type="checkbox" id="abroadTransport" name="abroadTransport">
            <label for="abroadTransport">Yurtdışı Ulaşımı</label>
            <div class="additional-input" id="abroadTransportInput" style="display:none;">
                <label for="abroadTransportDetails">Detayları Giriniz:</label>
                <input type="text" class="form-control" id="abroadTransportDetails" name="abroadTransportDetails">
            </div>
        </div>

        <!-- Ulaşım (Hareket Yeri, Gidiş Saati, Dönüş Saati) -->
        <div class="form-group">
            <input type="checkbox" id="transport" name="transport">
            <label for="transport">Ulaşım (Hareket Yeri, Gidiş Saati, Dönüş Saati)</label>
            <div class="additional-input" id="transportInput" style="display:none;">
                <label for="transportDetails">Detayları Giriniz:</label>
                <input type="text" class="form-control" id="transportDetails" name="transportDetails">
            </div>
        </div>

        <!-- Ulaşım Talep No -->
        <div class="form-group">
            <input type="checkbox" id="transportRequestNo" name="transportRequestNo">
            <label for="transportRequestNo">Ulaşım Talep No</label>
            <div class="additional-input" id="transportRequestNoInput" style="display:none;">
                <label for="transportRequestNoDetails">Detayları Giriniz:</label>
                <input type="text" class="form-control" id="transportRequestNoDetails" name="transportRequestNoDetails">
            </div>
        </div>

        <!-- Diğer -->
        <div class="form-group">
            <input type="checkbox" id="other" name="other">
            <label for="other">Diğer</label>
            <div class="additional-input" id="otherInput" style="display:none;">
                <label for="otherDetails">Detayları Giriniz:</label>
                <input type="text" class="form-control" id="otherDetails" name="otherDetails">
            </div>
        </div>


            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4">Etkinliği Oluştur</button>
        </form>
    </div>

</div>
</div>
<?php include_once '../includes/right_top_menu.php'; ?>

    <!-- Bootstrap JS, Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Etkinlik için ekstra detay inputlarını gösterme/gizleme
        function toggleSalonInput() {
            var salonInput = document.getElementById('salonInput');
            var salonCheckbox = document.getElementById('salonRezervasyonu');
            salonInput.style.display = salonCheckbox.checked ? 'block' : 'none';
        }

        // Diğer ihtiyaçlar için inputları gösterme/gizleme
        document.getElementById('banner').addEventListener('change', toggleAdditionalInput);
        document.getElementById('printing').addEventListener('change', toggleAdditionalInput);
        document.getElementById('flowers').addEventListener('change', toggleAdditionalInput);
        document.getElementById('plaque').addEventListener('change', toggleAdditionalInput);
        document.getElementById('medal').addEventListener('change', toggleAdditionalInput);
        document.getElementById('food').addEventListener('change', toggleAdditionalInput);
        document.getElementById('drink').addEventListener('change', toggleAdditionalInput);
        document.getElementById('accommodation').addEventListener('change', toggleAdditionalInput);
        document.getElementById('abroadTransport').addEventListener('change', toggleAdditionalInput);
        document.getElementById('transport').addEventListener('change', toggleAdditionalInput);
        document.getElementById('transportRequestNo').addEventListener('change', toggleAdditionalInput);
        document.getElementById('other').addEventListener('change', toggleAdditionalInput);

        function toggleAdditionalInput(event) {
            var inputId = event.target.id + 'Input';
            var inputField = document.getElementById(inputId);
            inputField.style.display = event.target.checked ? 'block' : 'none';
        }
    </script>
</body>
</html>
