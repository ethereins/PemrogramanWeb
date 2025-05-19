<?php
class Mahasiswa {
    private $conn;
    private $table_name = "mahasiswa";

    public $id;
    public $nim;
    public $nama;
    public $jurusan;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Validasi input
    private function isValidInput() {
        if (empty($this->nim) || !ctype_digit($this->nim)) return false;
        if (empty($this->nama) || !preg_match("/^[a-zA-Z\s]+$/", $this->nama)) return false;
        if (empty($this->jurusan) || !preg_match("/^[a-zA-Z\s]+$/", $this->jurusan)) return false;
        return true;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nim=?, nama=?, jurusan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $this->nim, $this->nama, $this->jurusan);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Data berhasil disimpan!";
            return true;
        } else {
            $_SESSION['flash_message'] = "Data gagal disimpan.";
            return false;
        }
    }

    public function read($id = "") {
        if ($id == "") {
            $query = "SELECT * FROM " . $this->table_name;
        } else {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->conn->query($query);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nim=?, nama=?, jurusan=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $this->nim, $this->nama, $this->jurusan, $this->id);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Data berhasil diedit!";
            return true;
        } else {
            $_SESSION['flash_message'] = "Data gagal diedit.";
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Data berhasil dihapus!";
            return true;
        } else {
            $_SESSION['flash_message'] = "Data gagal dihapus.";
            return false;
        }
    }
}
?>
