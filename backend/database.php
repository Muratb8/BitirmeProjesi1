<?php

class Database {
    private $pdo;
    private $host = "localhost";
    private $db_name = "project";
    private $username = "root"; // Veritabanı kullanıcı adı
    private $password = ""; // Veritabanı şifresi
    public $conn;

    // Veritabanı bağlantısını sağla
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Bağlantı hatası: " . $exception->getMessage());
        }
        return $this->conn;
    }

    // Tabloya göre veri çekme fonksiyonu
    public function getData($table, $columns = "*", $conditions = "", $params = []) {
        $query = "SELECT $columns FROM $table";
        
        // Eğer bir koşul varsa ekle
        if ($conditions != "") {
            $query .= " WHERE " . $conditions;
        }
        
        // Sorguyu hazırla
        $stmt = $this->conn->prepare($query);
        
        // Parametre varsa bind et
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        // Verileri al
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Veri ekleme fonksiyonu
public function insertData($table, $data) {
    if ($this->conn === null) {
        $this->getConnection(); // Bağlantıyı sağla
    }

    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
    $stmt = $this->conn->prepare($query);

    // Verileri bind et
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->execute();
    
    // Eklenen verinin ID'sini döndür
    return $this->conn->lastInsertId();
}

    // Veri güncelleme fonksiyonu
    public function updateData($table, $data, $conditions, $params) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", "); // Son virgülü kaldır

        $query = "UPDATE $table SET $setClause WHERE $conditions";

        $stmt = $this->conn->prepare($query);

        // Verileri bind et
        foreach (array_merge($data, $params) as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }
    public function getRow($query, $params = []) {

          // Eğer bağlantı sağlanmamışsa, getConnection fonksiyonunu çağır.
    if ($this->conn === null) {
        $this->getConnection(); // Bağlantıyı kuruyoruz.
    }
        $stmt = $this->conn->prepare($query); // PDO bağlantısı doğru kullanılıyor
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Verilen SQL sorgusuna parametre ile veri çekmek
    public function getAllRecords($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function prepare($sql) {
        // Bağlantı sağlanmamışsa getConnection fonksiyonunu çağırıyoruz.
        if ($this->conn === null) {
            $this->getConnection(); // Bağlantıyı kuruyoruz.
        }
    
        // PDO bağlantısı üzerinden sorguyu hazırlıyoruz.
        return $this->conn->prepare($sql);
    }

     // Genel SQL çalıştırma fonksiyonu
     public function execute($sql, $params = []) {
        if ($this->conn === null) {
            $this->getConnection(); // Bağlantıyı kuruyoruz.
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}

?>
