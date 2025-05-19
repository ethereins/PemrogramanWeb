<?php
session_start();
include_once '../config/Database.php';
include_once '../model/Mahasiswa.php';

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mahasiswa->nim = trim($_POST['nim'] ?? '');
    $mahasiswa->nama = trim($_POST['nama'] ?? '');
    $mahasiswa->jurusan = trim($_POST['jurusan'] ?? '');
    
    if ($action === 'create') {
        if ($mahasiswa->create()) {
            $_SESSION['flash_message'] = 'Berhasil menambahkan data!';
            header('Location: ../index.php?msg=1');
        } else {
            $_SESSION['flash_message'] = 'Gagal menambahkan data.';
            header('Location: ../index.php?msg=0');
        }
        exit;
    } elseif ($action === 'update') {
        $mahasiswa->id = $_POST['id'] ?? null;
        if ($mahasiswa->update()) {
            $_SESSION['flash_message'] = 'Berhasil mengedit data!';
            header('Location: ../index.php?msg=1');
        } else {
            $_SESSION['flash_message'] = 'Gagal mengedit data.';
            header('Location: ../index.php?msg=0');
        }
        exit;
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $mahasiswa->id = $_GET['id'];
    if ($mahasiswa->delete()) {
        $_SESSION['flash_message'] = 'Berhasil menghapus data!';
        header('Location: ../index.php?msg=1');
    } else {
        $_SESSION['flash_message'] = 'Gagal menghapus data.';
        header('Location: ../index.php?msg=0');
    }
    exit;
}
?>
