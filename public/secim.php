<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulüp Başkan Oylaması</title>
      <!-- Harici CSS dosyası -->
      <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
if ($role !== 'student' && $role !== 'developer') {
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

</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/mobil_menu.php'?>
   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <!-- Sağ Üst Köşe İkonlar -->
<?php include '../includes/right_top_menu.php'?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2">Kulüp Başkan Oylaması</h1>
    </div>

    <!-- Voting Section -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Başkan Adaylarını Oyla</h5>
            <p>En fazla 5 başkan adayı seçebilirsiniz.</p>
            <form id="votingForm">
                <div class="mb-3">
                    <label for="clubSelect" class="form-label">Kulüp Seç</label>
                    <select class="form-select" id="clubSelect" required>
                        <option value="">Kulüp seçiniz</option>
                        <option value="1">Müzik Kulübü</option>
                        <option value="2">Tiyatro Kulübü</option>
                        <option value="3">Spor Kulübü</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adaylar</label>
                    <div class="form-check">
                        <input class="form-check-input candidate-checkbox" type="checkbox" value="Ahmet Yılmaz" id="candidate1">
                        <label class="form-check-label" for="candidate1">
                            Ahmet Yılmaz
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input candidate-checkbox" type="checkbox" value="Ayşe Demir" id="candidate2">
                        <label class="form-check-label" for="candidate2">
                            Ayşe Demir
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input candidate-checkbox" type="checkbox" value="Mehmet Kaya" id="candidate3">
                        <label class="form-check-label" for="candidate3">
                            Mehmet Kaya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input candidate-checkbox" type="checkbox" value="Ali Veli" id="candidate4">
                        <label class="form-check-label" for="candidate4">
                            Ali Veli
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input candidate-checkbox" type="checkbox" value="Fatma Çelik" id="candidate5">
                        <label class="form-check-label" for="candidate5">
                            Fatma Çelik
                        </label>
                    </div>
                </div>
                <p id="selectionInfo" class="text-danger">Seçtiğiniz aday sayısı: 0/5</p>
                <button type="submit" class="btn btn-primary" disabled id="submitButton">Oy Ver</button>
            </form>
        </div>
    </div>

</main>
        </div>
        </div>
        <?php include_once '../includes/right_top_menu.php'; ?>
        <script>
            const checkboxes = document.querySelectorAll('.candidate-checkbox');
            const selectionInfo = document.getElementById('selectionInfo');
            const submitButton = document.getElementById('submitButton');
            let selectedCount = 0;
    
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        selectedCount++;
                    } else {
                        selectedCount--;
                    }
                    selectionInfo.textContent = `Seçtiğiniz aday sayısı: ${selectedCount}/5`;
                    submitButton.disabled = selectedCount === 0 || selectedCount > 5;
    
                    if (selectedCount > 5) {
                        selectionInfo.classList.add('text-danger');
                    } else {
                        selectionInfo.classList.remove('text-danger');
                    }
                });
            });
    
            document.getElementById('votingForm').addEventListener('submit', event => {
                event.preventDefault();
                alert('Oy başarıyla kaydedildi!');
            });
        </script>
</body>
</html>
