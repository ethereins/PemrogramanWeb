<?php
session_start();
include('function/Alert.php');
include_once('config/Database.php');
include_once('model/Mahasiswa.php');

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);
$data = $mahasiswa->read();

$flash_message = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OOP - CRUD Data Mahasiswa</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
      :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4895ef;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #4cc9f0;
        --danger-color: #f72585;
      }
      
      body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        min-height: 100vh;
      }
      
      .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.18);
        overflow: hidden;
        transition: all 0.3s ease;
      }
      
      .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2);
      }
      
      .header-title {
        position: relative;
        display: inline-block;
        color: var(--primary-color);
        font-weight: 700;
      }
      
      .header-title:after {
        content: '';
        position: absolute;
        width: 60%;
        height: 4px;
        bottom: -8px;
        left: 20%;
        background: var(--accent-color);
        border-radius: 2px;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.3s ease;
      }
      
      .header-title:hover:after {
        transform: scaleX(1);
      }
      
      .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 8px 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
      }
      
      .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
      }
      
      .btn-success {
        background-color: var(--success-color);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
      }
      
      .btn-success:hover {
        background-color: #38b6db;
        transform: translateY(-2px);
      }
      
      .btn-danger {
        background-color: var(--danger-color);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
      }
      
      .btn-danger:hover {
        background-color: #e5177e;
        transform: translateY(-2px);
      }
      
      .table-responsive {
        border-radius: 12px;
        overflow: hidden;
      }
      
      .table {
        margin-bottom: 0;
      }
      
      .table thead {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        color: white;
      }
      
      .table th {
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 12px 8px;
      }
      
      .table td {
        padding: 12px 8px;
        vertical-align: middle;
      }
      
      .table tbody tr {
        transition: all 0.2s ease;
      }
      
      .table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
        transform: scale(1.005);
      }
      
      .table-hover tbody tr:hover td {
        color: var(--primary-color);
      }
      
      .floating-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        transition: all 0.3s ease;
        z-index: 1000;
      }
      
      .floating-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: var(--secondary-color);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
      }
      
      .pulse {
        animation: pulse 2s infinite;
      }
      
      @keyframes pulse {
        0% {
          box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.7);
        }
        70% {
          box-shadow: 0 0 0 12px rgba(67, 97, 238, 0);
        }
        100% {
          box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
        }
      }
      
      .badge-jurusan {
        padding: 6px 10px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        background: linear-gradient(90deg, #f72585, #b5179e);
        color: white;
      }
      
      .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
        color: #6c757d;
      }
      
      .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #adb5bd;
      }
      
      @media (max-width: 768px) {
        .floating-btn {
          bottom: 20px;
          right: 20px;
          width: 50px;
          height: 50px;
          font-size: 20px;
        }
      }
    </style>
  </head>
  <body>
    <div class="container py-5">
      <div class="glass-card p-4 animate__animated animate__fadeIn">
        <h4 class="text-center mb-4 header-title animate__animated animate__fadeInDown">
          <i class="bi bi-mortarboard-fill me-2"></i>Data Mahasiswa FTI Universitas Andalas
        </h4>

        <?php if ($flash_message && isset($_GET['msg'])): ?>
          <div class="animate__animated animate__fadeIn">
            <?php alert($flash_message, $_GET['msg'] == '1' ? 1 : 0); ?>
          </div>
        <?php endif; ?>

        <div class="table-responsive mt-3 animate__animated animate__fadeInUp">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th class="text-center">Jurusan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($data->num_rows > 0): ?>
                <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
                  <tr class="animate__animated animate__fadeIn">
                    <td class="text-center fw-bold"><?= $no++ ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($row['nim']) ?></td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="me-3">
                          <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person-fill text-primary"></i>
                          </div>
                        </div>
                        <div>
                          <div class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></div>
                          <small class="text-muted">Mahasiswa FTI</small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge-jurusan"><?= htmlspecialchars($row['jurusan']) ?></span>
                    </td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <a class="btn btn-success btn-sm" href="form_mahasiswa.php?id=<?= $row['id'] ?>">
                          <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a class="btn btn-danger btn-sm" href="function/Mahasiswa.php?action=delete&id=<?= $row['id'] ?>"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data <?= htmlspecialchars($row['nama']) ?>?');">
                          <i class="bi bi-trash me-1"></i> Hapus
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5">
                    <div class="empty-state animate__animated animate__fadeIn">
                      <i class="bi bi-database-exclamation"></i>
                      <h5 class="mb-2">Data Mahasiswa Kosong</h5>
                      <p class="text-muted mb-0">Belum ada data mahasiswa yang tersimpan</p>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <a href="form_mahasiswa.php" class="floating-btn pulse animate__animated animate__bounceIn">
      <i class="bi bi-plus-lg"></i>
    </a>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
      // Add animation to table rows on hover
      document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
          row.classList.add('animate__animated', 'animate__pulse');
        });
        
        row.addEventListener('mouseleave', () => {
          setTimeout(() => {
            row.classList.remove('animate__animated', 'animate__pulse');
          }, 500);
        });
      });
      
      // Add ripple effect to buttons
      document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
          let x = e.clientX - e.target.getBoundingClientRect().left;
          let y = e.clientY - e.target.getBoundingClientRect().top;
          
          let ripple = document.createElement('span');
          ripple.classList.add('ripple');
          ripple.style.left = `${x}px`;
          ripple.style.top = `${y}px`;
          this.appendChild(ripple);
          
          setTimeout(() => {
            ripple.remove();
          }, 1000);
        });
      });
    </script>
  </body>
</html>