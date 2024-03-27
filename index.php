<table border="1">
    <tr>
        <th>Mã NV</th>
        <th>Tên NV</th>
        <th>Giới tính</th>
        <th>Nơi sinh</th>
        <th>Mã phòng</th>
        <th>Lương</th>
    </tr>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $database = "ql_nhansu";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $employeesPerPage = 5;

    if (isset($_GET['page'])) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    $startIndex = ($currentPage - 1) * $employeesPerPage;

    $sql = "SELECT * FROM nhanvien LIMIT $startIndex, $employeesPerPage";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Ma_NV"] . "</td>";
            echo "<td>" . $row["Ten_NV"] . "</td>";
            echo "<td>";
            if ($row["Phai"] == "NU") {
                echo "<img src='woman.jpg' alt='Woman' width='50'>";
            } else {
                echo "<img src='nam.jpg' alt='Man' width='50'>";
            }
            echo "</td>";
            echo "<td>" . $row["Noi_Sinh"] . "</td>";
            echo "<td>" . $row["Ma_Phong"] . "</td>";
            echo "<td>" . $row["Luong"] . "</td>";
            echo "<td><a href='edit.php?id=" . $row["Ma_NV"] . "'>Sửa</a></td>"; 
            echo "<td><a href='delete.php?id=" . $row["Ma_NV"] . "'>Xóa</a></td>"; 
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Không có nhân viên nào</td></tr>"; 
    }
    

    $conn->close();
    ?>
</table>

<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total FROM nhanvien";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalEmployees = $row['total'];

$totalPages = ceil($totalEmployees / $employeesPerPage);

echo "<div>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='index.php?page=$i'>$i</a> ";
}
echo "</div>";

$conn->close();
?>
