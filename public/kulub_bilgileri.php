<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulüp Üye Listesi</title>
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
$role = $_SESSION['role']; // Kullanıcının rolünü al

?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/mobil_menu.php'?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                       
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Kulüp Üyeleri</h1>
                </div>

                <!-- Club Members Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Kulüp Üye Sayıları</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-bg-primary mb-3">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Müzik Kulübü</h5>
                                        <p class="card-text display-6">25 Üye</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-bg-success mb-3">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Tiyatro Kulübü</h5>
                                        <p class="card-text display-6">30 Üye</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-bg-info mb-3">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Spor Kulübü</h5>
                                        <p class="card-text display-6">20 Üye</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Members List Section -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Üye Listesi</h5>
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Ad Soyad</th>
                                    <th>Kulüp</th>
                                    <th>Telefon</th>
                                    <th>E-posta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Ahmet Yılmaz</td>
                                    <td>Müzik Kulübü</td>
                                    <td>0555 123 4567</td>
                                    <td>ahmet@example.com</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Ayşe Demir</td>
                                    <td>Tiyatro Kulübü</td>
                                    <td>0555 987 6543</td>
                                    <td>ayse@example.com</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Mehmet Kaya</td>
                                    <td>Spor Kulübü</td>
                                    <td>0555 456 7890</td>
                                    <td>mehmet@example.com</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Fatma Çelik</td>
                                    <td>Müzik Kulübü</td>
                                    <td>0555 321 9876</td>
                                    <td>fatma@example.com</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Ali Veli</td>
                                    <td>Tiyatro Kulübü</td>
                                    <td>0555 654 3210</td>
                                    <td>ali@example.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
<script>
 
</script>
</body>

</html>
