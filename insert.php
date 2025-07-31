<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_db";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// فحص الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// جلب البيانات من النموذج
$name = $_POST['name'];
$age = $_POST['age'];

// تحضير و تنفيذ استعلام الإدخال
$stmt = $conn->prepare("INSERT INTO users (name, age) VALUES (?, ?)");
$stmt->bind_param("si", $name, $age);

if ($stmt->execute()) {
    echo "
<div style='
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-size: 20px;
    font-family: Arial, sans-serif;
    text-align: center;
'>
    <p style='color: green;'>!تم حفظ البيانات بنجاح</p>
    <a href='index.php' style='margin-top: 10px; color: #333; text-decoration: none;'>عودة للنموذج</a>
</div>
";

} else {
    echo "حدث خطأ: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
