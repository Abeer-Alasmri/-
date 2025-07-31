<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // الحصول على الحالة الحالية
    $sql = "SELECT status FROM users WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $currentStatus = $row['status'];

    // تبديل الحالة
    $newStatus = $currentStatus == 1 ? 0 : 1;
    $updateSql = "UPDATE users SET status = $newStatus WHERE id = $id";
    $conn->query($updateSql);

    echo $newStatus;
}
$conn->close();
?>
