<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Çizergesi</title>
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
if ($role !== 'student' && $role !== 'club_president' && $role !== 'developer') {
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
        .table th, .table td {
            text-align: center;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }
        .table-header {
            background-color: #0d6efd;
            color: white;
        }
        .table-body {
            background-color: #ffffff;
        }
        .footer {
            background-color: #212529;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        td {
            cursor: pointer; /* Tıklanabilir simgeyi ayarladık */
            vertical-align: middle;
        }
        td:first-child {
            cursor: default;
        }
        td:first-child, th:first-child {
            cursor: default;
        }

        th:nth-child(n+2) {
            cursor: default;
        }
        .editable-cell input {
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .editable-cell {
            text-align: center;
        }
          /* Ders adı girildikten sonra rengi gece mavisi yapalım */
          .edited {
            background-color: #2c3e50; /* Gece mavisi */
            color: white;
        }
        td, th {
            cursor: pointer; /* Tıklanabilir simgeyi ayarladık */
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">

        <?php include '../includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
            <?php include '../includes/mobil_menu.php'?>

            <!-- Ders Çizergesi Sayfası -->
            <main class="col-md-9 col-lg-10 p-4">
        
              
                <h2>Ders Çizergesi</h2>
                <table class="table table-bordered">
                    <thead class="table-header">
                        <tr>
                            <th>Saatler</th>
                            <th>Pazartesi</th>
                            <th>Salı</th>
                            <th>Çarşamba</th>
                            <th>Perşembe</th>
                            <th>Cuma</th>
                            <th>Cumartesi</th>
                            <th>Pazar</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        <tr>
                            <td>08:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>09:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>09:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>10:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>10:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>11:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>11:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>12:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>12:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>13:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>13:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>14:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>14:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>15:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>15:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>16:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>16:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>17:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>17:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>18:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>18:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>19:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>19:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>20:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>20:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>21:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>21:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>22:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>22:30</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>23:00</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                        <tr>
                            <td>23:20</td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                            <td class="editable-cell" onclick="editCell(this)"></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <?php include_once '../includes/right_top_menu.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
    
        function editCell(cell) {
            // Eğer hücrede zaten bir input varsa, çık
            if (cell.querySelector("input")) return;

            // Hücreye bir input ekle
            let input = document.createElement("input");
            input.type = "text";
            input.placeholder = "Ders Adı";
            cell.innerHTML = "";
            cell.appendChild(input);
            
            // Input'a odaklan
            input.focus();
            
            // Kullanıcı input'a yazdıktan sonra, input'u kaydet
            input.addEventListener("blur", function() {
                // Input'tan gelen değeri hücreye kaydet
                cell.innerHTML = input.value || ""; // Eğer input boş bırakılırsa hücreyi boş bırak
                  // Hücreyi gece mavisi yap
                  if (input.value) {
                    cell.classList.add("edited");
                }
            });

            // Enter'a basıldığında da kaydet
            input.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    cell.innerHTML = input.value || "";
                    // Hücreyi gece mavisi yap
                    if (input.value) {
                        cell.classList.add("edited");
                    }
                }
            });
        }
    </script>
</body>
</html>
