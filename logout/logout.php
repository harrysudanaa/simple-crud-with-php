<?php 

session_start();
$_SESSION = [];
session_unset();
session_destroy();

// untuk menghapus cookie
setcookie("id", "", time() - 3600, "/");
setcookie("key", "", time() - 3600, "/");
echo "tes";

header("Location: http://localhost/crud-dasar/login/index.php");
exit;

?>