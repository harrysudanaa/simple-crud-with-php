<?php 
// session_start();
// // jika belum pernah melakukan login
// if(!isset($_SESSION["login"])) {
//     $url = "http://localhost/crud-dasar/index.php";
//     header("Location: " . $url);
//     exit;
// }
// koneksi ke db
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// buat function query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    // buat array untuk menampung data
    $rows = [];
    // ambil data
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function addData($data) {
    global $conn;
    // ambil data
    $merek = htmlspecialchars($data["merek"]);
    $nama = htmlspecialchars($data["nama"]);
    $chipset = htmlspecialchars($data["chipset"]);
    $ram = htmlspecialchars($data["ram"]);

    // upload
    $gambar = upload();
    // jika upload gagal
    if(!$gambar) return false;

    // lakukan query insert data
    $query = "INSERT INTO handphones 
            VALUES
            ('', '$merek', '$nama', '$chipset', '$ram', '$gambar')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteData($id) {
    global $conn;
    // delete data from id
    mysqli_query($conn, "DELETE FROM handphones WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function changeData($data) {
    global $conn;
    // ambil data
    $id = $data["id"];
    $merek = htmlspecialchars($data["merek"]);
    $nama = htmlspecialchars($data["nama"]);
    $chipset = htmlspecialchars($data["chipset"]);
    $ram = htmlspecialchars($data["ram"]);

    // lakukan query update data
    $query = "UPDATE handphones 
            SET
            merek = '$merek',
            nama = '$nama',
            chipset = '$chipset',
            ram = '$ram'
            WHERE id = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function searchData($keyword) {
    $query = "SELECT * FROM handphones WHERE
                merek LIKE '%$keyword%' OR
                nama LIKE '%$keyword%'
    ";
    // panggil function query dan masukkan query yg dibuat sebagai parameter
    return query($query);
}

function upload() {
    // ambil data gambar
    $namaFile = $_FILES["gambar"]["name"];
    $tmpName = $_FILES["gambar"]["tmp_name"];
    $size = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];

    // jika code error = 4, maka gambar belum diupload
    if($error === 4) {
        echo 'Gagal diupload';
        return false;
    }

    // ambil ektensi gambar
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];
    $ektensiGambar = pathinfo($namaFile);
    $ektensiGambar = $ektensiGambar["extension"];

    // cek apakah gambar sesuai dengan ketentuan ekstensi
    if(!in_array($ektensiGambar, $ekstensiGambarValid)) {
        echo "Yang diupload bukan gambar! Pastikan ekstensi gambar yaitu .jpg, .jpeg, .png";
    }

    // cek size gambar sesuai ketentuan (byte)
    if($size > 1000000) {
        echo "Size gambar terlalu besar!";
    }

    // Jika lolos pengecekan
    // generate string random untuk nama file untuk menghindari kesamaan nama file pd database
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ektensiGambar;
    
    // nama file lokasi tujuan
    $dirUpload = "C:\\xampp\\htdocs\\crud-dasar\\img\\";
    // pindahkan file dari tmp_name
    move_uploaded_file($tmpName, $dirUpload . $namaFileBaru);
    return $namaFileBaru;
}

function signup($data) {
    global $conn;
    // ambil data
    // username ubah dlm bentuk lowercase dan hindari penggunaan backslash '\'
    $username = strtolower(stripslashes($data["username"]));
    // escape string pada password untuk dimasukkan dlm DB
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confirmPw = mysqli_real_escape_string($conn, $data["cPassword"]);

    // cek apakah username sudah ada atau belum dlm DB
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="signup.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <div class="modal fade" id="signUpInfoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign Up</h5>
                </div>
                <div class="modal-body text-start">
                    Username telah terdaftar!
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-primary" name="failSignUp">OK</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <script>
        $(document).ready(function(){
            $("#signUpInfoModal").modal("show");
        });
        </script>
        ';
        return false;
    }
    // cek apakah username kosong dan pangkas 'whitespace' jika ada
    if(empty(trim($username))) {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="signup.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <div class="modal fade" id="signUpEmptyUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign Up</h5>
                </div>
                <div class="modal-body text-start">
                    Username tidak boleh kosong dan terdapat spasi!
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-primary" name="failSignUp">OK</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <script>
        $(document).ready(function(){
            $("#signUpEmptyUserModal").modal("show");
        });
        </script>
        ';
        return false;
    }
    // cek konfirmasi password
    if($password !== $confirmPw) {
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="signup.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <div class="modal fade" id="signUpFailPwModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign Up</h5>
                </div>
                <div class="modal-body text-start">
                    Konfirmasi password tidak sesuai!
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-primary" name="failSignUp">OK</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <script>
        $(document).ready(function(){
            $("#signUpFailPwModal").modal("show");
        });
        </script>
        ';
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke db
    mysqli_query($conn, "INSERT INTO users VALUES ('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>