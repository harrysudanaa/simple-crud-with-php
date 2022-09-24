<?php 
session_start();
// ambil data dari db
require "../crud-dasar/function/functions.php";
// jika belum pernah melakukan login
if(!isset($_SESSION["login"])) {
    $url = "http://localhost/crud-dasar/login/index.php";
    header("Location: " . $url);
    exit;
}
// pagination
$jumlahDataPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM users"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
// mengetahui halaman yang sedang dilihat
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$handphones = query("SELECT * FROM handphones LIMIT $awalData, $jumlahDataPerHalaman");
// jika tombol cari diklik
if(isset($_POST["cari"])) {
    // kirim keyword ke function searchData sebagai parameter
    $handphones = searchData($_POST["keyword"]);
}
// jika tombol logout diklik
if(isset($_POST["logout"])) {
    header("Location: ../crud-dasar/logout/logout.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic CRUD</title>
    <!-- bootstrap + icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- CSS -->
    <link rel="stylesheet" href="style1.css">
  </head>
  <body class="p-4">
    <!-- btn logout -->
    <div class="logout-container">
        <a href="login/index.php" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
    </div>
    <!-- akhir btn logout -->

    <!-- header -->
    <h1>List Smartphones</h1>
    <p class="mb-4">*berdasarkan data dari GSMArena 2022</p>
    <!-- akhir header -->

    <!-- search -->
    <form action="" method="POST" class="cari">
        <ul>
            <li class="px-1">
                <input type="text" class="form-control" placeholder="Cari HP Disini" name="keyword" autocomplete="off">
            </li>
            <li>
                <button type="submit" class="btn btn-primary" name="cari">Cari</button>
            </li>
        </ul>
    </form>
    <!-- akhir search -->

    <!-- tambah data -->
    <div class="tambah-data">
        <a href="../crud-dasar/add-data/index.php" class="bg-success text-white fw-bold"><i class="bi bi-plus fw-bolder text-white"></i>Tambah Data</a>
    </div>
    <!-- akhir tambah data -->
    
    <!-- Table data start -->
    <div class="table mt-5">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                <th scope="col" width="5%">No.</th>
                <th scope="col" width="25%">Gambar</th>
                <th scope="col" width="15%">Merek</th>
                <th scope="col" width="20%">Nama</th>
                <th scope="col" width="15%">Chipset</th>
                <th scope="col" width="10%">RAM</th>
                <th scope="col" width="10%">Action</th>
            </tr>
            </thead>
            <?php $i = 1 ?>
            <?php foreach($handphones as $row) : ?>
            <tbody>
                <tr>
                <th scope="row"><?= $i ?></th>
                <td><img src="../crud-dasar/img/<?= $row["gambar"] ?>" width="100" height="100"></td>
                <td><?= $row["merek"] ?></td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["chipset"] ?></td>
                <td><?= $row["ram"] ?></td>
                <td>
                    <div class="action">
                        <a href="../crud-dasar/change-data/index.php?id=<?= $row["id"]; ?>"><i class="bi bi-pencil-square ubah"></i></a>
                        <a href="../crud-dasar/delete-data/index.php?id=<?= $row["id"]; ?>"><i class="bi bi-trash hapus"></i></a>
                    </div>
                </td>
                </tr>
            </tbody>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Table data end -->

    <!-- Pagination -->
    <nav aria-label="...">
        <ul class="pagination justify-content-end">
            <?php if($halamanAktif > 1) : ?>
                <li class="page-item">
                    <a class="page-link pagination" href="?halaman=<?= $halamanAktif - 1 ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                <?php if($i == $halamanAktif) : ?>
                <li class="page-item">
                    <a class="page-link pagination bg-primary text-white" href="?halaman=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php else : ?>
                    <li class="page-item">
                        <a class="page-link pagination" href="?halaman=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if($halamanAktif < $jumlahHalaman) : ?>
                <li class="page-item">
                    <a class="page-link pagination" href="?halaman=<?= $halamanAktif + 1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Pagination end -->

    <!-- Modal Logout-->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    Apakah yakin anda ingin logout?
                </div>
                <div class="modal-footer">
                    <form action="" method="POST">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>