<?php 
session_start();
require "../function/functions.php";
// jika belum pernah melakukan login
if(!isset($_SESSION["login"])) {
    $url = "http://localhost/crud-dasar/login/index.php";
    header("Location: " . $url);
    exit;
}
// define ('SITE_ROOT', realpath(dirname(__FILE__)));
// cek apakah tombol tambah diklik
// if(isset($_POST["tambah"])) {
//   if(addData($_POST) > 0) {
//     echo "<script>
//       alert('Data berhasil ditambahkan');
//       document.location.href = '../index.php';
//     </script>
//     ";
//   } else {
//     echo "<script>
//       alert('Data gagal ditambahkan');
//       document.location.href = '../crud-dasar/index.php';
//     </script>
//     ";
//   }
// }

if(isset($_POST["addInfo"])) {
  header("Location: ../index.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="add.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container bg-white rounded p-5">
        <!-- Title -->
        <h1>Tambah Data</h1>
        <p>Input data smartphone pada kolom dibawah ini.</p>
        <!-- Title end -->

        <!-- Form -->
        <div class="form-login mt-4 rounded p-3">
          <form action="" method="POST" enctype="multipart/form-data">

            <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
              <label for="merek" class="form-label">Merek</label>
              <input type="text" class="form-control" name ="merek" id="merek" placeholder="example: Apple, Samsung, etc." required>
            </div>

            <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
              <label for="nama" class="form-label">Nama Smartphone</label>
              <input type="text" class="form-control" name ="nama" id="nama" placeholder="example: iPhone 12 pro, Redmi Note 10, etc." required>
            </div>

            <div class="input-form d-flex flex-column align-items-start justify-content-center mb-2">
              <label for="chipset" class="form-label">Chipset</label>
              <input type="text" class="form-control" name ="chipset" id="chipset" placeholder="example: Snapdragon 778 5G, etc." required>
            </div>

            <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
              <label for="ram" class="form-label">RAM</label>
              <input type="text" class="form-control" name ="ram" id="ram" placeholder="example: 8GB" required>
            </div>
            <div class="input-form d-flex flex-column align-items-start justify-content-center mb-3">
              <label for="gambar" class="form-label">Gambar</label>
              <input type="file" class="form-control" name ="gambar" id="gambar" placeholder="Enter Password">
            </div>

            <!-- Add Data Modal-->
            <div class="modal fade " id="addCheckModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Apakah yakin ingin menambahkan data?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add">Tambah</button>
                    </div>
                  </div>
              </div>
            </div>

          </form>
      </div>
      <!-- Form end -->

      <!-- Button Confirm -->
      <div class="button mt-4 d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary"><a href="../index.php" class="cancel text-decoration-none">Cancel</a></button>
          <button class="btn btn-primary login" type="button" data-bs-toggle="modal" data-bs-target="#addCheckModal">Add data</button>
        </div>
    </div>
    <!-- Button Confirm end -->

    <!-- Notif Sucess Add Data -->
    <div class="modal fade" id="addSuccessModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Tambah Data</h5>
              </div>
              <div class="modal-body text-start">
                  Data berhasil ditambahkan!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="addInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Sucess Add Data end -->

    
    <!-- Notif Failed Add Data -->
    <div class="modal fade" id="addSuccessModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Tambah Data</h5>
              </div>
              <div class="modal-body text-start">
                  Data gagal ditambahkan!
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      <button type="submit" class="btn btn-primary" name="addInfo">OK</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <!-- Notif Failed Add Data end -->

    <!-- Logic PHP -->
    <?php if(isset($_POST["add"])) : ?>
        <?php if(addData($_POST) > 0) : ?>
            <?= '<script>
                    $(document).ready(function(){
                        $("#addSuccessModal").modal("show");
                    });
                </script>';
            ?>
        <?php else : ?>
            <?= '<script>
                    $(document).ready(function(){
                        $("#dltFailModal").modal("show");
                    });
                </script>';
            ?>
        <?php endif; ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
