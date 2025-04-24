<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ana Sayfa</title>

    <!-- Harici CSS dosyası -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <?php
require_once '../backend/database.php'; // Mevcut veritabanı sınıfını dahil et
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../public/giris.php");
    exit();
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $alertClass = "alert-" . $message['type'];  // alert-success, alert-danger gibi sınıflar
    
    // Mesajı ekrana yazdır
    echo "<div class='alert $alertClass alert-dismissible fade show' role='alert'>";
    echo $message['text'];
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
    echo "</div>";
    
    // Mesajı oturumdan temizle
    unset($_SESSION['message']);
}
$db = new Database();
$user_id = $_SESSION['id']; // Oturum açmış kullanıcının ID'si
$user = $db->getRow("SELECT * FROM users WHERE id = ?", [$user_id]);
$role = $user['role'];

if ($role == 'student') {
    $studentInfo = $db->getRow("SELECT * FROM students WHERE user_id = ?", [$user_id]);

    // Kulüp üyeliklerini sorgulamak
$sql = "SELECT clubs.name, clubs.id, 
(SELECT COUNT(*) FROM clubmembers WHERE clubmembers.club_id = clubs.id AND clubmembers.status = 'approved') AS member_count
FROM clubs 
JOIN clubmembers ON clubs.id = clubmembers.club_id
WHERE clubmembers.user_id = ? AND clubmembers.status = 'approved'";

$stmt = $db->prepare($sql);
$stmt->execute([$user_id]);
$clubs = $stmt->fetchAll();

// Eğer öğrenci üye olduğu kulüpleri varsa, 'Üye Olunan Kulüpler' bölümünü gösteriyoruz
$has_clubs = count($clubs) > 0;
}
if($role == 'developer'){
    $presidents = $db->getData('clubpresidents', '*'); // clubpresident tablosundan tüm başkanları al
    $students = $db->getData('students', '*'); // Öğrenciler
    $managers = $db->getData('managers', '*'); // Aktivite Merkezi Sorumluları
}

?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">   
            <?php include_once '../includes/sidebar.php'; ?>
            <!-- Mobil Hamburger Menü -->
            <?php include_once '../includes/mobil_menu.php'; ?>
           
            <!-- Ana İçerik -->
            <main class="col-md-9 col-lg-10 p-4">
              
               
            <!-- Profil Bilgileri -->
            <div class="text-center mb-4">
            <img src="https://via.placeholder.com/120" alt="Profil Resmi" class="profile-img mb-3 rounded-circle border border-3 border-primary">
            <h5 class="fw-bold">   <?php if (!empty($studentInfo)): echo htmlspecialchars($studentInfo['first_name'] . " " . $studentInfo['last_name']); ?></h5><?php else: ?> <?php endif; ?>
            </div>

<?php if ($role == 'student'): ?>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Profil Bilgilerim</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($studentInfo)): ?>
                <div class="mb-3">
                    <strong>Ad:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['first_name']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Soyad:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['last_name']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>GPA:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['gpa']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>CGPA:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['cgpa']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Doğum Yeri:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['birth_place']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Doğum Tarihi:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['birth_date']); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Cinsiyet:</strong> 
                    <span class="text-muted"><?php echo htmlspecialchars($studentInfo['gender']); ?></span>
                </div>
            
               
            <?php endif; ?>
        </div>
    </div>

              <!-- Üye Olunan Kulüpler -->
              <?php if (empty($studentInfo)): ?>
        <?php else: ?>
           <?php if ($has_clubs): ?>
           <div class="row">
    <div class="col-12">
        <div class="card p-4 mb-3">
            <h5 class="fw-bold mb-3">Üye Olunan Kulüpler</h5>
            <ul class="list-group">
                <?php foreach ($clubs as $club): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($club['name']); ?> <!-- Kulüp Adı -->
                    <span class="badge bg-primary rounded-pill"><?php echo $club['member_count']; ?> Üye</span> <!-- Üye Sayısı -->
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php else: ?>
    <!-- Öğrenci herhangi bir kulübe üye değilse -->
    <div class="alert alert-info" role="alert">
        Henüz bir kulübe üye değilsiniz.
    </div>
<?php endif; ?>

<?php endif; ?>

<div class="col-md-6">
                        <div class="card p-4 mb-3">
                            <h5 class="fw-bold">Etkinlik</h5>
                            <p><strong>Tarih:</strong> 15 Ağustos 2024</p>
                            <p><strong>Yer:</strong> Konferans Salonu</p>
                        </div>
                    </div>
<?php endif; ?>
 

<?php if ($role == 'developer'): ?>
<div class="container mt-5">

        <div class="row">
            <!-- Kulüp Yaratma Kartı -->
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h5 class="fw-bold mb-3">Yeni Kulüp Yarat</h5>
                    <form action="create_club.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="clubName" class="form-label">Kulüp Adı</label>
                            <input type="text" class="form-control" id="clubName" name="clubName" required>
                        </div>
                        <div class="mb-3">
                            <label for="clubDescription" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="clubDescription" name="clubDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="clubLogo" class="form-label">Logo Yükle</label>
                            <input type="file" class="form-control" id="clubLogo" name="clubLogo" accept="image/*">
                        </div>
                        <div class="form-group">
        <label for="clubPresident">Kulüp Başkanı Seçin:</label>
        <select name="clubPresident" id="clubPresident" class="form-control mb-3" required>
            <?php foreach ($presidents as $president) { ?>
                <option value="<?= $president['user_id']; ?>"><?= $president['ad']; ?></option>
            <?php } ?>
        </select>
    </div>
                        <button type="submit" class="btn btn-primary">Kulübü Yarat</button>
                    </form>
                </div>
            </div>

            </div>
           </div>
                                       <!-- Kullanıcı Ekleme Kartı -->
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h5 class="fw-bold mb-3">Kullanıcı Ekle</h5>
                    <form id="addUserForm" action="../backend/add_user.php" method="POST">
    <div class="mb-3">
        <label for="userEmail" class="form-label">E-posta</label>
        <input type="email" class="form-control" id="userEmail" name="userEmail" required>
    </div>
    <div class="mb-3">
        <label for="userRole" class="form-label">Rol Seç</label>
        <select class="form-control" id="userRole" name="userRole" required>
            <option value="student">Öğrenci</option>
            <option value="club_president">Kulüp Başkanı</option>
            <option value="manager">Yönetici</option>
            <option value="developer">Geliştirici</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
</form>
<div id="messageBox" class="mt-3"></div>
                </div>
             </div>
    <div class="row mb-3">
     <div class="col-md-12">
               <!-- Öğrenci Bilgileri Düzenle Card'ı -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Öğrenci Bilgilerini Düzenle</h5>
            </div>
            <div class="card-body">
                <!-- Öğrenci Seçim Formu -->
                <div class="form-group mb-4">
                    <label for="studentSelect">Öğrenci Seçin:</label>
                    <select id="studentSelect" class="form-select">
                        <option value="">Öğrenci Seçin</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?php echo $student['user_id']; ?>" 
                                    data-first-name="<?php echo htmlspecialchars($student['first_name']); ?>"
                                    data-last-name="<?php echo htmlspecialchars($student['last_name']); ?>"
                                    data-gpa="<?php echo htmlspecialchars($student['gpa']); ?>"
                                    data-cgpa="<?php echo htmlspecialchars($student['cgpa']); ?>"
                                    data-birth-place="<?php echo htmlspecialchars($student['birth_place']); ?>"
                                    data-birth-date="<?php echo htmlspecialchars($student['birth_date']); ?>"
                                    data-gender="<?php echo htmlspecialchars($student['gender']); ?>"
                                    data-phone-number="<?php echo htmlspecialchars($student['phone_number']); ?>"
                                      data-student-number="<?php echo htmlspecialchars($student['student_number']); ?>"
                            >
                                
            <?php 
                // Eğer isim veya soyisim boşsa, 'Bilinmeyen' gösterelim
                $fullName = $student['first_name'] && $student['last_name'] ? $student['first_name'] . " " . $student['last_name'] : 'Bilinmeyen';
            ?>
            <?php echo htmlspecialchars($fullName); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
         

                <!-- Öğrenci Bilgileri (Dinamik Olarak Gösterilecek) -->
                <div class="mb-3">
                    <label for="firstName" class="form-label">Ad:</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" >
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Soyad:</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" >
                </div>
                <div class="mb-3">
                    <label for="gpa" class="form-label">GPA:</label>
                    <input type="text" class="form-control" id="gpa" name="gpa" >
                </div>
                <div class="mb-3">
                    <label for="cgpa" class="form-label">CGPA:</label>
                    <input type="text" class="form-control" id="cgpa" name="cgpa" >
                </div>
                <div class="mb-3">
                    <label for="birthPlace" class="form-label">Doğum Yeri:</label>
                    <input type="text" class="form-control" id="birthPlace" name="birth_place" >
                </div>
                <div class="mb-3">
                    <label for="birthDate" class="form-label">Doğum Tarihi:</label>
                    <input type="date" class="form-control" id="birthDate" name="birth_date" >
                </div>
                <div class="mb-3">
                <label for="gender" class="form-label">Cinsiyet:</label>
                <select class="form-select" id="gender" name="gender" required>
                <option value="">Seçiniz</option>
              <option value="erkek">Erkek</option>
             <option value="kadın">Kadın</option>
             <option value="diğer">Diğer</option>
              </select>
                </div>

              <!-- Telefon Numarası -->
            <div class="mb-3">
             <label for="phone" class="form-label">Telefon Numarası:</label>
             <input type="text" class="form-control" id="phoneNumber" name="phone_number" pattern="[0-9]{12}" placeholder="12 haneli telefon numarası" required>
            </div>
            <!-- Öğrenci Numarası -->
            <div class="mb-3">
             <label for="studentNumber" class="form-label">Öğrenci Numarası:</label>
             <input type="text" class="form-control" id="studentNumber" name="student_number" required>
            </div>
                <button id="saveButton" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
    </div>

    <div class="row mb-3">
    <div class="col-md-12">
        <!-- Öğrenci Bilgileri Düzenle Card'ı -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Kulüp başkanlarını Düzenle</h5>
            </div>
            <div class="card-body">
                <!-- Öğrenci Seçim Formu -->
                <div class="form-group mb-4">
                    <label for="presidentSelect">başkan Seçin:</label>
                    <select id="presidentSelect" class="form-select">
                        <option value="">Başkan Seçin</option>
                        <?php foreach ($presidents as $president): ?>
                            <option value="<?php echo $president['user_id']; ?>" 
                                    data-ad="<?php echo htmlspecialchars($president['ad']); ?>"
                                    data-soyad="<?php echo htmlspecialchars($president['soyad']); ?>"
                            >
                                
            <?php 
                // Eğer isim veya soyisim boşsa, 'Bilinmeyen' gösterelim
                $fullName = $president['ad'] && $president['soyad'] ? $president['ad'] . " " . $president['soyad'] : 'Bilinmeyen';
            ?>
            <?php echo htmlspecialchars($fullName); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ad" class="form-label">Ad:</label>
                    <input type="text" class="form-control" id="ad" name="ad" >
                </div>
                <div class="mb-3">
                    <label for="soyad" class="form-label">Soyad:</label>
                    <input type="text" class="form-control" id="soyad" name="soyad" >
                </div>
                <button id="presidentsaveButton" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
     </div>
    </div>
                                     
    <div class="row mb-3">
    <div class="col-md-12">
        <!-- Aktivite Merkezi Sorumlusu Bilgileri Düzenle Card'ı -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Aktivite Merkezi Sorumlusu Düzenle</h5>
            </div>
            <div class="card-body">
                <!-- Aktivite Merkezi Sorumlusu Seçim Formu -->
                <div class="form-group mb-4">
                    <label for="managerSelect">Aktivite Merkezi Sorumlusu Seçin:</label>
                    <select id="managerSelect" class="form-select">
                        <option value="">Aktivite Merkezi Sorumlusu Seçin</option>
                        <?php foreach ($managers as $manager): ?>
                            <option value="<?php echo $manager['user_id']; ?>" 
                                    data-managerad="<?php echo htmlspecialchars($manager['ad']); ?>"
                                    data-managersoyad="<?php echo htmlspecialchars($manager['soyad']); ?>"
                            >
                                
            <?php 
                // Eğer isim veya soyisim boşsa, 'Bilinmeyen' gösterelim
                $fullName = $manager['ad'] && $manager['soyad'] ? $manager['ad'] . " " . $manager['soyad'] : 'Bilinmeyen';
            ?>
            <?php echo htmlspecialchars($fullName); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ad" class="form-label">Ad:</label>
                    <input type="text" class="form-control" id="managerad" name="managerad" >
                </div>
                <div class="mb-3">
                    <label for="soyad" class="form-label">Soyad:</label>
                    <input type="text" class="form-control" id="managersoyad" name="managersoyad" >
                </div>
                <button id="managersaveButton" class="btn btn-primary">Kaydet</button>
                 </div>
                    </div>
                           </div>
                                </div>

     <?php endif; ?>

               
                </div>
             
            </main>
                            
        </div>
      
    </div>


    <?php include_once '../includes/right_top_menu.php'; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
$('#addUserForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize(); // Formdaki verileri al

        $.ajax({
            url: '../backend/add_user.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                const box = $('#messageBox');
                if (response.success) {
                    box.html(`<div class="alert alert-success">${response.message}</div>`);
                    $('#addUserForm')[0].reset(); // formu sıfırla
                } else {
                    box.html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            },
            error: function () {
                $('#messageBox').html('<div class="alert alert-danger">Bir hata oluştu.</div>');
            }
        });
    });



document.getElementById('saveButton').addEventListener('click', function () {
    let user_id = document.getElementById('studentSelect').value;
    let first_name = document.getElementById('firstName').value;
    let last_name = document.getElementById('lastName').value;
    let gpa = document.getElementById('gpa').value;
    let cgpa = document.getElementById('cgpa').value;
    let birth_place = document.getElementById('birthPlace').value;
    let birth_date = document.getElementById('birthDate').value;
    let gender = document.getElementById('gender').value;
    let phone_number = document.getElementById('phoneNumber').value;
    let student_number = document.getElementById('studentNumber').value;

    // Öğrenci seçilip seçilmediğini kontrol et
    if (!user_id) {
        alert("Lütfen bir öğrenci seçin!");
        return;
    }

    let formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("first_name", first_name);
    formData.append("last_name", last_name);
    formData.append("gpa", gpa);
    formData.append("cgpa", cgpa);
    formData.append("birth_place", birth_place);
    formData.append("birth_date", birth_date);
    formData.append("gender", gender);
    formData.append("phone_number", phone_number);
    formData.append("student_number", student_number);

    // POST isteğini yap
    fetch("../backend/update_student.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Öğrenci bilgileri başarıyla güncellendi!");
        } else {
            alert("Hata: " + data.message);
        }
    })
    .catch(error => console.error("Hata oluştu:", error));
});

        // Öğrenci seçildiğinde bilgileri inputlara aktar
    document.getElementById('studentSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

        // Eğer bir öğrenci seçildiyse
        if (selectedOption.value !== "") {
            // Seçilen öğrencinin verilerini al
            var firstName = selectedOption.getAttribute('data-first-name');
            var lastName = selectedOption.getAttribute('data-last-name');
            var gpa = selectedOption.getAttribute('data-gpa');
            var cgpa = selectedOption.getAttribute('data-cgpa');
            var birthPlace = selectedOption.getAttribute('data-birth-place');
            var birthDate = selectedOption.getAttribute('data-birth-date');
            var gender = selectedOption.getAttribute('data-gender');
            var phoneNumber = selectedOption.getAttribute('data-phone-number');
            var studentNumber = selectedOption.getAttribute('data-student-number');
            // Inputları doldur
            document.getElementById('firstName').value = firstName;
            document.getElementById('lastName').value = lastName;
            document.getElementById('gpa').value = gpa;
            document.getElementById('cgpa').value = cgpa;
            document.getElementById('birthPlace').value = birthPlace;
            document.getElementById('birthDate').value = birthDate;
            document.getElementById('gender').value = gender;
            document.getElementById('phoneNumber').value = phoneNumber;
            document.getElementById('studentNumber').value = studentNumber;
        }
    });

        // Öğrenci seçildiğinde bilgileri inputlara aktar
    document.getElementById('presidentSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

        // Eğer bir başkan seçildiyse
        if (selectedOption.value !== "") {
            // Seçilen başkan verilerini al
            var ad = selectedOption.getAttribute('data-ad');
            var soyad = selectedOption.getAttribute('data-soyad');

            // Inputları doldur
            document.getElementById('ad').value = ad;
            document.getElementById('soyad').value = soyad;
        }
    });


    document.getElementById('presidentsaveButton').addEventListener('click', function () {
    let user_id = document.getElementById('presidentSelect').value;
    let ad = document.getElementById('ad').value;
    let soyad = document.getElementById('soyad').value;

    if (!user_id) {
        alert("Lütfen bir Başkan seçin!");
        return;
    }

    let formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("ad", ad);
    formData.append("soyad", soyad);


    fetch("../backend/update_president.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Başkan bilgileri başarıyla güncellendi!");
        } else {
            alert("Hata: " + data.message);
        }
    })
    .catch(error => console.error("Hata oluştu:", error));
});


        // Aktivite Merkezi Sorumlusu seçildiğinde bilgileri inputlara aktar
        document.getElementById('managerSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

        // Eğer bir öğrenci seçildiyse
        if (selectedOption.value !== "") {
            // Seçilen öğrencinin verilerini al
            var ad = selectedOption.getAttribute('data-managerad');
            var soyad = selectedOption.getAttribute('data-managersoyad');

            // Inputları doldur
            document.getElementById('managerad').value = ad;
            document.getElementById('managersoyad').value = soyad;
        }
    });


    document.getElementById('managersaveButton').addEventListener('click', function () {
    let user_id = document.getElementById('managerSelect').value;
    let ad = document.getElementById('managerad').value;
    let soyad = document.getElementById('managersoyad').value;

    if (!user_id) {
        alert("Lütfen bir Aktivite Merkezi Sorumlusu seçin!");
        return;
    }

    let formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("ad", ad);
    formData.append("soyad", soyad);


    fetch("../backend/update_manager.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Aktivite Merkezi Sorumlusu bilgileri başarıyla güncellendi!");
        } else {
            alert("Hata: " + data.message);
        }
    })
    .catch(error => console.error("Hata oluştu:", error));
});
});


    </script>
</body>
</html>
