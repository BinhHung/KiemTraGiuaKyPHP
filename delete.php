<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "ql_nhansu";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit;
// }

if(isset($_GET['Ma_NV'])) {
    $employeeId = $_GET['Ma_NV'];
    
    $sql = "DELETE FROM nhanvien WHERE Ma_NV = $employeeId";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
