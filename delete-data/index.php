<?php
session_start();
require "../function/functions.php";
// jika belum pernah melakukan login
if(!isset($_SESSION["login"])) {
    $url = "http://localhost/crud-dasar/login/index.php";
    header("Location: " . $url);
    exit;
}
// ambil id
$id = $_GET["id"];
// cek apakah tombol OK dari notif delete diklik
if(isset($_POST["dlt"])) {
    header("Location: ../index.php");
    exit;
}
// cek apakah tombol delete diklik
// if(isset($_POST["delete"])) {
//     // cek apakah function delete berhasil
//     if(deleteData($id) > 0) {
//         echo "<script>
//             alert('Data berhasil dihapus!');
//             document.location.href = '../index.php';
//             </script>
//             ";
//     } else {
//         echo "<script>
//             alert('Data gagal dihapus!');
//             document.location.href = '../index.php';
//             </script>
//             ";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Delete Data</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    </head>
    <body>
    <!-- Modal Delete-->
    <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start">
                Apakah yakin data dihapus?
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Notif Succes Delete -->
    <div class="modal fade" id="dltSuccesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
            </div>
            <div class="modal-body text-start">
                Data berhasil dihapus!
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="submit" class="btn btn-primary" name="dlt">OK</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Notif Failed Delete -->
    <div class="modal fade" id="dltFailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
            </div>
            <div class="modal-body text-start">
                Data gagal dihapus!
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="submit" class="btn btn-primary" name="dlt">OK</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- JQuery -->
    <script>
        $(document).ready(function(){
            $("#deleteModal").modal("show");
        });
    </script>
    <?php if(isset($_POST["delete"])) : ?>
        <?php if(deleteData($id) > 0) : ?>
            <?= '<script>
                    $(document).ready(function(){
                        $("#dltSuccesModal").modal("show");
                    });
                </script>';
            ?>
        <?php else: ?>
            <?= '<script>
                    $(document).ready(function(){
                        $("#dltFailModal").modal("show");
                    });
                </script>';
            ?>
        <?php endif; ?>
    <?php endif; ?>
    </body>
</html>