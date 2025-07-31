<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نموذج معلومات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>نموذج تعبئة البيانات</h2>

    <form action="insert.php" method="POST">
        <input type="text" name="name" placeholder="الاسم" required>
        <input type="number" name="age" placeholder="العمر" required>
        <button type="submit">إرسال</button>
    </form>
    <script>
function toggleStatus(id) {
    const formData = new FormData();
    formData.append('id', id);

    fetch('toggle.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(newStatus => {
        const statusCell = document.getElementById('status-' + id);
        if (newStatus == 1) {
            statusCell.innerText = "✅ (1) مفعّل";
            statusCell.nextElementSibling.firstChild.style.backgroundColor = "#a3d9a5";
        } else {
            statusCell.innerText = "❌ (0) غير مفعّل";
            statusCell.nextElementSibling.firstChild.style.backgroundColor = "#f7b2b0";
        }
    });
}
</script>

</body>
</html>
<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// جلب البيانات
$sql = "SELECT id, name, age, status FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>جميع السجلات:</h2>";
    echo "<table border='1' style='width:100%; text-align:center; border-collapse: collapse;'>";
    echo "<tr><th>الرقم</th><th>الاسم</th><th>العمر</th><th>الحالة</th><th>تبديل</th></tr>";
    while($row = $result->fetch_assoc()) {
        $statusText = $row["status"] == 1 ? "✅ مفعّل" : "❌ غير مفعّل";
        $buttonColor = $row["status"] == 1 ? "#a3d9a5" : "#f7b2b0";
    
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["age"]."</td>";
        echo "<td id='status-".$row["id"]."'>$statusText</td>";
        echo "<td><button onclick='toggleStatus(".$row["id"].")' style='background-color: $buttonColor; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;'>تبديل</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    } else {
    echo "لا توجد سجلات.";
}

$conn->close();
?>
