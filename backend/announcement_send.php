<?php
session_start();
require_once 'database.php';
header('Content-Type: application/json');

// 1. Oturum ve rol kontrolü
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'club_president') {
    echo json_encode(['success' => false, 'message' => 'Yetkisiz erişim. Lütfen giriş yapın.']);
    exit();
}

$user_id = $_SESSION['id'];

// 2. POST verilerini al ve XSS filtrele
$title = htmlspecialchars($_POST['title'] ?? '');
$content = htmlspecialchars($_POST['content'] ?? '');
$category = htmlspecialchars($_POST['category'] ?? '');
$date = $_POST['date'] ?? '';

// 3. Alan doğrulama
if (!$title || !$content || !$category || !$date) {
    echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurun.']);
    exit();
}

// 4. Tarih formatı doğrulama
if (!DateTime::createFromFormat('Y-m-d', $date)) {
    echo json_encode(['success' => false, 'message' => 'Geçerli bir tarih girin (Y-m-d).']);
    exit();
}

try {
    $db = new Database();
    $db->getConnection();

    // 5. Duyuruyu ekle
    $announcementData = [
        'user_id' => $user_id,
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'announcement_date' => $date,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $result = $db->insertData('announcements', $announcementData);

    if ($result) {
        // 6. Kulüp başkanı id'sini al
        $president = $db->getRow("SELECT president_id FROM clubpresidents WHERE user_id = ?", [$user_id]);
        if (!$president) {
            echo json_encode(['success' => false, 'message' => 'Kulüp başkanı bulunamadı.']);
            exit();
        }

        // 7. Kulüplerin id'lerini al
        $clubs = $db->getRows("SELECT id FROM clubs WHERE clubpresident_id = ?", [$president['president_id']]);
        if (!$clubs) {
            echo json_encode(['success' => false, 'message' => 'Bağlı kulüp bulunamadı.']);
            exit();
        }

        $club_ids = [];
        foreach ($clubs as $club) {
            $club_ids[] = $club['id'];
        }

        // 8. Kulüp üyelerini al
        $placeholders = implode(',', array_fill(0, count($club_ids), '?'));
        $club_members = $db->getRows("SELECT user_id FROM clubmembers WHERE club_id IN ($placeholders)", $club_ids);

        if ($club_members) {
            $user_ids = [];
            foreach ($club_members as $member) {
                $user_ids[] = $member['user_id'];
            }

            // 9. Her kullanıcıya bildirim gönder
            foreach ($user_ids as $uid) {
                $notifData = [
                    'user_id' => $uid,
                    'title' => $title,
                    'content' => $content,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'unread',
                    'type' => 'announcement',
                    'action' => '',
                    'event_date' => $date
                ];
                $db->insertData('notifications', $notifData);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Duyurunuz başarıyla oluşturuldu.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Duyuru eklenirken hata oluştu.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Hata: ' . $e->getMessage()]);
}
?>
