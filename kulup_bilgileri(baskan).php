<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Müzik Kulübü Üye Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        .btn-remove {
            color: white;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .btn-remove:hover {
            background-color: #bb2d3b;
        }
        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }
                 /* Sağ üstteki ikonlar için stil */
                 .top-icons {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .top-icons i {
            font-size: 1.5rem;
            margin-left: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
        <?php include 'includes/sidebar.php'; ?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Sağ Üst Köşe İkonlar -->
 <div class="top-icons">
    <i class="bi bi-moon"></i> <!-- Gece Modu İkonu -->
    <i class="bi bi-bell"></i> <!-- Bildirim Çanı İkonu -->
    <i class="bi bi-chat-dots"></i> <!-- Mesajlar İkonu -->
    <i class="bi bi-person-circle"></i> <!-- Profil İkonu -->
</div>
         
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Müzik Kulübü Üye Listesi</h1>
                </div>

                <!-- Club Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Müzik Kulübü Detayları</h5>
                        <p class="card-text">Toplam Üye Sayısı: <span class="fw-bold">25</span></p>
                        <p class="card-text">Aktif Etkinlik Sayısı: <span class="fw-bold">3</span></p>
                        <p class="card-text">Kulüp Başkanı: <span class="fw-bold">Ahmet Yılmaz</span></p>
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
                                    <th>Telefon</th>
                                    <th>E-posta</th>
                                    <th>Görev</th>
                                    <th>Aksiyon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Ahmet Yılmaz</td>
                                    <td>0555 123 4567</td>
                                    <td>ahmet@example.com</td>
                                    <td>Başkan</td>
                                    <td><button class="btn-remove">Üyeyi Çıkar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Ayşe Demir</td>
                                    <td>0555 987 6543</td>
                                    <td>ayse@example.com</td>
                                    <td>Üye</td>
                                    <td><button class="btn-remove">Üyeyi Çıkar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Mehmet Kaya</td>
                                    <td>0555 456 7890</td>
                                    <td>mehmet@example.com</td>
                                    <td>Üye</td>
                                    <td><button class="btn-remove">Üyeyi Çıkar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Fatma Çelik</td>
                                    <td>0555 321 9876</td>
                                    <td>fatma@example.com</td>
                                    <td>Üye</td>
                                    <td><button class="btn-remove">Üyeyi Çıkar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Ali Veli</td>
                                    <td>0555 654 3210</td>
                                    <td>ali@example.com</td>
                                    <td>Üye</td>
                                    <td><button class="btn-remove">Üyeyi Çıkar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
          document.getElementById("toggleSidebar").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("collapsed");
        });
    </script>
</body>

</html>
