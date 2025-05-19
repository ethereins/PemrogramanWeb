<?php 
include_once './config/Database.php'; 
include_once './model/Mahasiswa.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$mahasiswa = new Mahasiswa($db); 

$isEdit = false;
$result = ['id'=>'', 'nim'=>'', 'nama'=>'', 'jurusan'=>''];

if (isset($_GET['id'])) {
    $data = $mahasiswa->read($_GET['id']);
    if ($data) {
        $result = $data->fetch_assoc();
        $isEdit = true;
    }
}
?>

<!doctype html> 
<html lang="en"> 
  <head> 
    <meta charset="utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title><?= $isEdit ? 'Edit' : 'Create' ?> Mahasiswa</title> 
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
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
        background: rgba(255, 255, 255, 0.9);
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
      
      .form-header {
        position: relative;
        color: var(--primary-color);
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
      }
      
      .form-header:after {
        content: '';
        position: absolute;
        width: 60%;
        height: 4px;
        bottom: -10px;
        left: 20%;
        background: var(--accent-color);
        border-radius: 2px;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.3s ease;
      }
      
      .form-header:hover:after {
        transform: scaleX(1);
      }
      
      .form-label {
        font-weight: 500;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
      }
      
      .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
      }
      
      .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(72, 149, 239, 0.25);
      }
      
      .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
      }
      
      .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
      }
      
      .btn-secondary {
        background-color: #6c757d;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 10px 20px;
        transition: all 0.3s ease;
      }
      
      .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
      }
      
      .error-message {
        font-size: 0.85rem;
        color: var(--danger-color);
        margin-top: 0.25rem;
        opacity: 0;
        transform: translateY(-5px);
        transition: all 0.3s ease;
      }
      
      .show-error {
        opacity: 1;
        transform: translateY(0);
      }
      
      .input-group {
        position: relative;
        margin-bottom: 1.5rem;
      }
      
      .input-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: var(--primary-color);
        z-index: 10;
      }
      
      .input-with-icon {
        padding-left: 40px !important;
      }
      
      .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.7);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
      }
      
      @keyframes ripple {
        to {
          transform: scale(4);
          opacity: 0;
        }
      }
      
      .floating-label {
        position: absolute;
        top: 10px;
        left: 40px;
        color: #6c757d;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 5px;
      }
      
      .form-control:focus + .floating-label,
      .form-control:not(:placeholder-shown) + .floating-label {
        top: -10px;
        left: 30px;
        font-size: 0.75rem;
        color: var(--primary-color);
      }
    </style> 
  </head> 
  <body> 
    <div class="container py-5"> 
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h4 class="form-header animate__animated animate__fadeInDown">
            <i class="bi bi-person-vcard me-2"></i><?= $isEdit ? 'Edit' : 'Tambah' ?> Data Mahasiswa
          </h4>

          <div class="glass-card p-4 animate__animated animate__fadeInUp">
            <form id="formMahasiswa" action="function/Mahasiswa.php?action=<?= $isEdit ? 'update' : 'create' ?>" method="post" novalidate> 
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <?php endif; ?>
                
                <div class="input-group">
                  <i class="bi bi-123 input-icon"></i>
                  <input type="text" id="nim" name="nim" class="form-control input-with-icon" 
                         value="<?= htmlspecialchars($result['nim']) ?>" 
                         placeholder=" " 
                         required>
                  <label for="nim" class="floating-label">NIM</label>
                  <div id="nimError" class="error-message"></div>
                </div> 

                <div class="input-group">
                  <i class="bi bi-person-fill input-icon"></i>
                  <input type="text" id="nama" name="nama" class="form-control input-with-icon" 
                         value="<?= htmlspecialchars($result['nama']) ?>" 
                         placeholder=" " 
                         required>
                  <label for="nama" class="floating-label">Nama Lengkap</label>
                  <div id="namaError" class="error-message"></div>
                </div> 

                <div class="input-group">
                  <i class="bi bi-book-half input-icon"></i>
                  <input type="text" id="jurusan" name="jurusan" class="form-control input-with-icon" 
                         value="<?= htmlspecialchars($result['jurusan']) ?>" 
                         placeholder=" " 
                         required>
                  <label for="jurusan" class="floating-label">Jurusan</label>
                  <div id="jurusanError" class="error-message"></div>
                </div> 

                <div class="d-flex justify-content-between mt-4">
                  <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                  </button> 
                </div>
            </form> 
          </div>
        </div>
      </div>
    </div> 

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formMahasiswa');
        const inputs = form.querySelectorAll('input');
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
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
        
        // Input validation
        form.addEventListener('submit', function(e) {
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show-error');
            });

            let valid = true;

            const nim = document.getElementById('nim').value.trim();
            const nama = document.getElementById('nama').value.trim();
            const jurusan = document.getElementById('jurusan').value.trim();

            if (!nim) {
                document.getElementById('nimError').textContent = 'NIM wajib diisi.';
                document.getElementById('nimError').classList.add('show-error');
                valid = false;
            } else if (!/^\d+$/.test(nim)) {
                document.getElementById('nimError').textContent = 'NIM harus berupa angka.';
                document.getElementById('nimError').classList.add('show-error');
                valid = false;
            }

            if (!nama) {
                document.getElementById('namaError').textContent = 'Nama wajib diisi.';
                document.getElementById('namaError').classList.add('show-error');
                valid = false;
            } else if (!/^[a-zA-Z\s]+$/.test(nama)) {
                document.getElementById('namaError').textContent = 'Nama hanya boleh huruf dan spasi.';
                document.getElementById('namaError').classList.add('show-error');
                valid = false;
            }

            if (!jurusan) {
                document.getElementById('jurusanError').textContent = 'Jurusan wajib diisi.';
                document.getElementById('jurusanError').classList.add('show-error');
                valid = false;
            } else if (!/^[a-zA-Z\s]+$/.test(jurusan)) {
                document.getElementById('jurusanError').textContent = 'Jurusan hanya boleh huruf dan spasi.';
                document.getElementById('jurusanError').classList.add('show-error');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                // Add shake animation to invalid fields
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('animate__animated', 'animate__headShake');
                        setTimeout(() => {
                            input.classList.remove('animate__animated', 'animate__headShake');
                        }, 1000);
                    }
                });
            }
        });
        
        // Add animation to form inputs on focus
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.floating-label').style.color = 'var(--primary-color)';
                this.style.borderColor = 'var(--accent-color)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.floating-label').style.color = '#6c757d';
                this.style.borderColor = 'rgba(0, 0, 0, 0.1)';
            });
        });
    });
    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
  </body> 
</html>