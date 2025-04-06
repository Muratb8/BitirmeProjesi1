

<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 sidebar d-none d-md-block position-relative" id="sidebar">
<h4 class="text-center py-4">
        <a href="../public/index.php">
            <img src="../uploads/DAÜ.png" alt="DAÜ Logo">
        </a>
    </h4>
    
    <?php if ($role === 'student'): ?>
        <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
        <a href="kulup.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
        <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
        <a href="bildirim.php" class="position-relative">
            <i class="bi bi-bell-fill"></i> Bildirimler
            <span class="badge badge-notify">3</span>
        </a>
        <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
        <a href="ders_cizergesi.php"><i class="bi bi-layout-text-sidebar-reverse"></i> Ders Çizergesi</a>
        <a href="secim.php"><i class="bi bi-clipboard-data-fill"></i> Seçim</a>

    <?php elseif ($role === 'club_president'): ?>
        <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
        <a href="bildirim.php" class="position-relative">
            <i class="bi bi-bell-fill"></i> Bildirimler
            <span class="badge badge-notify">3</span>
        </a>
        <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
        <a href="Etkinlik_yaratma.php"><i class="bi bi-plus-circle-fill"></i> Etkinlik Yaratma</a>
        <a href="duyuru_yaratma.php"><i class="bi bi-megaphone-fill"></i> Duyuru Yaratma</a>
        <a href="kulup_bilgileri(baskan).php"><i class="bi bi-info-circle-fill"></i> Kulüp Bilgileri</a>
        <a href="basvuru.php"><i class="bi bi-file-earmark-person-fill"></i> Başvurular</a>

    <?php elseif ($role === 'manager'): ?>
        <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
        <a href="bildirim.php" class="position-relative">
            <i class="bi bi-bell-fill"></i> Bildirimler
            <span class="badge badge-notify">3</span>
        </a>
        <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
        <a href="kulup_yaratma.php"><i class="bi bi-clipboard-data-fill"></i> Kulüp Yaratma</a>
        <a href="aktivite_merkezi_sorumlusu.php"><i class="bi bi-clipboard-data-fill"></i> Aktivite Merkezi Sorumlusunun, Etkinlik Gözlem yeri</a>
        <a href="istek.php"><i class="bi bi-box-arrow-in-down"></i> İstek</a>
        <a href="kulup_bilgileri(baskan).php"><i class="bi bi-info-circle-fill"></i> Kulüp Bilgileri</a>

    <?php elseif ($role === 'developer'): ?>
        <a href="index.php"><i class="bi bi-house-fill"></i> Ana Sayfa</a>
        <a href="kulup.php"><i class="bi bi-people-fill"></i> Kulüpler</a>
        <a href="message_room.php"><i class="bi bi-chat-left-text-fill"></i> İletişim</a>
        <a href="bildirim.php" class="position-relative">
            <i class="bi bi-bell-fill"></i> Bildirimler
            <span class="badge badge-notify">3</span>
        </a>
        <a href="etkinlik.php"><i class="bi bi-calendar-event-fill"></i> Etkinlikler</a>
        <a href="Etkinlik_yaratma.php"><i class="bi bi-plus-circle-fill"></i> Etkinlik Yaratma</a>
        <a href="duyuru_yaratma.php"><i class="bi bi-megaphone-fill"></i> Duyuru Yaratma</a>
        <a href="kulup_bilgileri(baskan).php"><i class="bi bi-info-circle-fill"></i> Kulüp Bilgileri</a>
        <a href="basvuru.php"><i class="bi bi-file-earmark-person-fill"></i> Başvurular</a>
        <a href="kulub_bilgileri.php"><i class="bi bi-clipboard-data-fill"></i> Kulüp Bilgileri</a>
        <a href="kulup_yaratma.php"><i class="bi bi-clipboard-data-fill"></i> Kulüp Yaratma</a>
        <a href="aktivite_merkezi_sorumlusu.php"><i class="bi bi-clipboard-data-fill"></i> Aktivite Merkezi Sorumlusunun, Etkinlik Gözlem yeri</a>
        <a href="ders_cizergesi.php"><i class="bi bi-clipboard-data-fill"></i> Ders Çizergesi</a>
        <a href="secim.php"><i class="bi bi-clipboard-data-fill"></i> Seçim</a>
        <a href="istek.php"><i class="bi bi-clipboard-data-fill"></i> İstekler</a>

    <?php endif; ?>
</nav>

