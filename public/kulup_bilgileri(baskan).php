<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulüp Üye Listesi</title>
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

require_once '../backend/database.php';
$db = new Database();


// Kulüp başkanının bilgilerini güvenli şekilde al
try {
    $sql = "SELECT * FROM clubpresidents WHERE user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();

    $president = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($president) {
        $kulup_ids = $president['kulup_id'];
        $club_manager_name = htmlspecialchars($president['ad'] . " " . $president['soyad']);
    } else {
        // Kullanıcı clubpresidents tablosunda kayıtlı değilse
        die("Hata: Kulüp başkanı bilgisi bulunamadı.");
    }
} catch (PDOException $e) {
    // Loglama veya kullanıcı dostu hata mesajı
    error_log("DB Hatası: " . $e->getMessage());
    die("Veri alınırken bir hata oluştu.");
}

try {
    $clubmembers_sql = "SELECT * FROM clubmembers WHERE club_id = :club_id";
    $clubmembers_stmt = $db->prepare($clubmembers_sql);
    $clubmembers_stmt->bindParam(':club_id', $kulup_ids, PDO::PARAM_INT);
    $clubmembers_stmt->execute();

    $clubmembers = $clubmembers_stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_members = count($clubmembers);
    $member_ids = array_column($clubmembers, 'user_id');
} catch (PDOException $e) {
    error_log("Üye bilgileri çekilirken hata oluştu: " . $e->getMessage());
    die("Kulüp üyeleri alınamadı.");
}

try {
    $students = [];

    if (!empty($member_ids)) {
        // Placeholder dizisi oluşturuluyor (:id1, :id2, ...)
        $placeholders = [];
        $params = [];
        foreach ($member_ids as $index => $id) {
            $key = ":id" . $index;
            $placeholders[] = $key;
            $params[$key] = $id;
        }

        $sql = "SELECT s.*, u.email, 'Üye' as role
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.user_id IN (" . implode(',', $placeholders) . ")
                UNION
                SELECT s.*, u.email, 'Başkan' as role
                FROM students s
                JOIN users u ON s.user_id = u.id
                JOIN clubpresidents cp ON cp.user_id = u.id
                WHERE cp.kulup_id = :kulup_id";

        $params[':kulup_id'] = $kulup_ids;

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Sadece başkan varsa (üyeler yoksa)
        $sql = "SELECT s.*, u.email, 'Başkan' as role
                FROM students s
                JOIN users u ON s.user_id = u.id
                JOIN clubpresidents cp ON cp.user_id = u.id
                WHERE cp.kulup_id = :kulup_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':kulup_id', $kulup_ids, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log("Öğrenci bilgileri alınırken hata: " . $e->getMessage());
    die("Öğrenci bilgileri yüklenemedi.");
}

try {
    $events_sql = "SELECT COUNT(*) as event_count FROM events WHERE club_id = :club_id";
    $events = $db->prepare($events_sql);
    $events->bindParam(':club_id', $kulup_ids, PDO::PARAM_INT);
    $events->execute();

    $event_result = $events->fetch(PDO::FETCH_ASSOC);
    $event_count = $event_result ? $event_result['event_count'] : 0;
} catch (PDOException $e) {
    error_log("Etkinlik sayısı alınamadı: " . $e->getMessage());
    $event_count = 0;
}
?>
  <link rel="stylesheet" href="../assets/css/style.css">
    <style>

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

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
        <?php include_once '../includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
            <?php include_once '../includes/mobil_menu.php'; ?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
     
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Kulüp Üye Listesi</h1>
                </div>

                <!-- Club Details -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Toplam Üye</h5>
                                        <p class="card-text display-6 fw-bold"><?php echo $total_members; ?></p>
                                    </div>
                                    <i class="bi bi-people-fill display-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Aktif Etkinlik</h5>
                                        <p class="card-text display-6 fw-bold"><?php echo $event_count; ?></p>
                                    </div>
                                    <i class="bi bi-calendar-event-fill display-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Kulüp Başkanı</h5>
                                        <p class="card-text display-6 fw-bold"><?php echo htmlspecialchars($club_manager_name); ?></p>
                                    </div>
                                    <i class="bi bi-person-badge-fill display-4"></i>
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
                                    <th>Telefon</th>
                                    <th>E-posta</th>
                                    <th>Görev</th>
                                    <th>Aksiyon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><b><?php echo htmlspecialchars($club_manager_name); ?></b></td>
                                    <td></td>
                                    <td></td>
                                    <td>Başkan</td>
                                    <td>-</td>
                                </tr>
                                <?php if ($students) : ?>
                                        <?php foreach ($students as $key=>$student) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $key+2; ?></th>
                                        <td><?php echo htmlspecialchars($student['first_name'] . " " . $student['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td>Üye</td>
                                        <td>
                                            <button class="btn-remove" onclick="removeMember(<?php echo $student['user_id']; ?>)">Üyeyi Çıkar</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Kulüpte üye bulunamadı</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <?php include_once '../includes/right_top_menu.php'; ?>
    <script>
      

        function removeMember(userId) {
            if (confirm('Bu üyeyi kulüpten çıkarmak istediğinizden emin misiniz?')) {
                fetch('remove_member.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'user_id=' + userId + '&club_id=<?php echo $kulup_ids; ?>'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Üye başarıyla çıkarıldı');
                        location.reload(); // Sayfayı yenile
                    } else {
                        alert('Hata: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Bir hata oluştu');
                });
            }
        }
    </script>
</body>

</html>
