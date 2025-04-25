<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlar</title>
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
    

    require_once 'database.php';
    $db = new Database();
    $db->getConnection();

    $president_id = $_SESSION['id'];

  
    $president = $db->getRow("SELECT president_id FROM clubpresidents WHERE user_id  = ?", [$president_id]);
    
    // Filtreleme parametrelerini al
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
    $filter_sender = isset($_GET['filter_sender']) ? $_GET['filter_sender'] : '';

    // SQL sorgusunu oluştur
    $sql = "SELECT m.*, s.first_name, s.last_name 
            FROM messages m 
            INNER JOIN students s ON m.student_id = s.student_id 
            WHERE m.president_id = ?";

    $params = [$president['president_id']];

    // Arama filtresi
    if (!empty($search)) {
        $sql .= " AND (m.message LIKE ? OR s.first_name LIKE ? OR s.last_name LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
    }

    // Tarih filtresi
    if (!empty($filter_date)) {
        $sql .= " AND DATE(m.date) = ?";
        $params[] = $filter_date;
    }

    // Gönderen filtresi
    if (!empty($filter_sender)) {
        $sql .= " AND m.student_id = ?";
        $params[] = $filter_sender;
    }

    $sql .= " ORDER BY m.date DESC";
    $messages = $db->getAllRecords($sql, $params);

    // Benzersiz gönderenleri al
    $unique_senders = $db->getAllRecords(
        "SELECT DISTINCT s.first_name, s.last_name, s.student_id
         FROM messages m 
         INNER JOIN students s ON m.student_id = s.student_id 
         WHERE m.president_id = ? 
         ORDER BY s.first_name, s.last_name",
        [$president['president_id']]
    );

    // Mesaj silme işlemi
    if (isset($_POST['delete_message']) && isset($_POST['message_id'])) {
        $message_id = $_POST['message_id'];
        $delete_sql = "DELETE FROM messages WHERE id = ? AND president_id = ?";
        $db->execute($delete_sql, [$message_id, $president['president_id']]);
        
        // Sayfayı yeniden yükle
        header("Location: messages.php");
        exit();
    }
    ?>
    <!-- Harici CSS dosyası -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .notification-card {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .notification-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .notification-card .notification-header {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .notification-card .notification-body {
            font-size: 1rem;
            color: #555;
        }
        .notification-card .notification-time {
            font-size: 0.9rem;
            color: #777;
            text-align: right;
        }
        .notification-card .notification-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0d6efd;
            display: inline-block;
            margin-right: 10px;
        }
        .notification-card .join-button {
            background-color: #28a745; /* Yeşil renk */
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .notification-card .join-button:hover {
            background-color: #218838; /* Hover durumunda daha koyu yeşil */
        }
        .notification-card.read {
            opacity: 0.7;
        }
        .notification-card.read .notification-dot {
            background-color: #6c757d;
        }
        .filter-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .filter-group {
            margin-bottom: 10px;
        }
        
        .filter-label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #495057;
        }
        
        .filter-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .filter-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }
        
        .filter-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .filter-button:hover {
            background-color: #0b5ed7;
        }
        
        .clear-filters {
            color: #6c757d;
            text-decoration: none;
            margin-left: 10px;
        }
        
        .clear-filters:hover {
            color: #0d6efd;
        }
        
        .message-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9rem;
        }
        
        .delete-button:hover {
            background-color: #c82333;
        }
        
        .delete-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
            <nav class="navbar navbar-dark bg-dark d-md-none">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Menü</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
         
            <div class="collapse d-md-none" id="mobileMenu">
                <a href="index.html" class="d-block text-dark bg-light p-2">Ana Sayfa</a>
                <a href="kulub.html" class="d-block text-dark bg-light p-2">Kulüpler</a>
                <a href="message_room.html" class="d-block text-dark bg-light p-2">Sohbet Odası</a>
                <a href="bildirim.html" class="d-block text-dark bg-light p-2">Bildirimler</a>
                <a href="etkinlik.html" class="d-block text-dark bg-light p-2">Etkinlikler</a>
                <a href="ders_cizergesi.html" class="d-block text-dark bg-light p-2">Ders Çizergesi</a>
            </div>

            <!-- Bildirimler Sayfası -->
            <main class="col-md-9 col-lg-10 p-4">
                <!-- Sağ Üst Köşe İkonlar -->
                <div class="top-icons">
                    <i class="bi bi-moon"></i> <!-- Gece Modu İkonu -->
                    <i class="bi bi-bell"></i> <!-- Bildirim Çanı İkonu -->
                    <i class="bi bi-chat-dots"></i> <!-- Mesajlar İkonu -->
                    <i class="bi bi-person-circle"></i> <!-- Profil İkonu -->
                </div>
                <!-- Arama ve Profil Alanı -->
                <button id="toggleSidebar" class="btn btn-primary position-fixed" style="top: 10px; left: 10px; z-index: 1000;">
                    <i class="bi bi-list"></i>
                </button>
                <h2>Mesajlar</h2>
                
                <!-- Filtreleme Formu -->
                <div class="filter-container">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label class="filter-label">Mesaj veya Kişi Ara</label>
                                <input type="text" name="search" class="filter-input" 
                                       value="<?php echo htmlspecialchars($search); ?>" 
                                       placeholder="Mesaj veya kişi adı...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Tarih</label>
                                <input type="date" name="filter_date" class="filter-input" 
                                       value="<?php echo htmlspecialchars($filter_date); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Gönderen</label>
                                <select name="filter_sender" class="filter-select">
                                    <option value="">Tümü</option>
                                    <?php foreach ($unique_senders as $sender): 
                                        ?>
                                        <option value="<?php echo $sender['student_id']; ?>"
                                                <?php echo ($filter_sender == $sender['student_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($sender['first_name'] . ' ' . $sender['last_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter-group" style="margin-top: 24px;">
                                <button type="submit" class="filter-button">Filtrele</button>
                                <a href="messages.php" class="clear-filters">Temizle</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <?php if (empty($messages)): ?>
                    <div class="alert alert-info">
                        <?php if (!empty($search) || !empty($filter_date) || !empty($filter_sender)): ?>
                            Filtre kriterlerine uygun mesaj bulunamadı.
                        <?php else: ?>
                            Henüz mesajınız bulunmamaktadır.
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="notification-card">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="bi bi-person-circle"></i>
                                    <span class="notification-header"><?php echo htmlspecialchars($message['first_name'] . ' ' . $message['last_name']); ?></span>
                                </div>
                                <div class="notification-time">
                                    <?php 
                                        $date = new DateTime($message['date']);
                                        echo $date->format('d.m.Y H:i');
                                    ?>
                                </div>
                            </div>
                            <div class="notification-body">
                                <?php echo htmlspecialchars($message['message']); ?>
                            </div>
                            <div class="message-actions">
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Bu mesajı silmek istediğinizden emin misiniz?');">
                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                    <button type="submit" name="delete_message" class="delete-button">
                                        <i class="bi bi-trash"></i> Sil
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        document.getElementById("toggleSidebar").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("collapsed");
        });
    </script>
</body>
</html>
