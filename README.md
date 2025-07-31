## نظام التسجيل و التحديث الذكي💻✨

👩‍💻 المصممة: عبير الأسمري  
💻 التخصص: برمجة المواقع والتطبيقات  

## 🛠️ التطبيقات المستخدمة

| الأداة               | الوصف                                     |
|---------------------|--------------------------------------------|
| Visual Studio Code  | محرر الأكواد المستخدم لكتابة ملفات PHP وCSS |
| XAMPP               | خادم محلي لتشغيل Apache وMySQL             |
| phpMyAdmin          | واجهة لإدارة قواعد البيانات MySQL         |

---

## 💡 فكرة المشروع

مشروع بسيط يسمح للمستخدمين بتسجيل معلوماتهم (الاسم - العمر)، مع تخزينها في قاعدة بيانات MySQL، واستعراضها مباشرة في جدول.  
يتضمن زر لتغيير "الحالة" من 0 إلى 1 والعكس، مع واجهة بلغة PHP وربط مباشر بقاعدة البيانات.

---

## 🎯 أهداف المشروع

- تعلم ربط PHP مع MySQL.
- تصميم واجهة تسجيل بيانات بسيطة.
- إنشاء جدول ديناميكي يعرض ويعدل البيانات.
- استخدام زر لتعديل الحالة مباشرة من الواجهة.

---

## 📝 وصف المهمة

برمجة مشروع باستخدام PHP وMySQL لإنشاء نموذج إدخال بيانات يتضمن الاسم والعمر،  
ثم عرض هذه البيانات في جدول يحتوي على زر لتعديل الحالة بشكل مباشر.  
المشروع يعكس المهارات الأساسية في التعامل مع قواعد البيانات والنماذج.

---

## الملفات المضمنة 📁

| اسم الملف      | الوصف                                                                 |
|----------------|------------------------------------------------------------------------|
| index.php    | الملف الرئيسي الذي يعرض نموذج إدخال الاسم والعمر، ويعرض البيانات المُخزنة في جدول ديناميكي. |
| insert.php   | يعالج البيانات المُدخلة من النموذج ويقوم بإضافتها إلى قاعدة البيانات.             |
| toggle.php   | مسؤول عن تغيير حالة السجل من 0 إلى 1 أو العكس عند الضغط على الزر في الجدول.       |
| style.css    | يحتوي على التنسيقات والتصميم العام للنموذج والجدول ليظهر بشكل أنيق ومنسّق.         |
|  form_task.sql  |نسخة من قاعدة البيانات تشمل جدول التخزين الخاص بالنموذج. |
| screenshot_form_and_table.png | لقطة شاشة تُظهر النموذج مع الجدول في الصفحة الرئيسية |
| screenshot_form_submit.png     |    لقطة أثناء تعبئة النموذج والضغط على زر الإرسال    |
| creenshot_insert_success.png   |      لقطة تُظهر رسالة نجاح بعد إضافة البيانات  |
| screenshot_database_table.png |phpMyAdmin صورة لجدول البيانات داخل |
| screenshot_before_toggle.png     |     لقطة توضح حالة التسجيل قبل التبديل    |
| screenshot_after_toggle.png   |      لقطة توضح الحالة بعد التبديل  |


---

## 🧠 شرح الأكواد البرمجية في المشروع
### 📄 index.php

```php
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
```

📝 *شرح الكود:*

| الرقم | شرح الخطوة                                                                                              |
|-------|--------------------------------------------------------------------------------------------------------|
| 1     | *هيكل الصفحة والربط بـ CSS*: يبدأ الكود بصفحة HTML تحتوي على نموذج بسيط لإدخال الاسم والعمر، ويتم ربط الصفحة بملف التنسيق الخارجي style.css لجعل الواجهة أنيقة. |
| 2     | *نموذج الإدخال (Form)*: يحتوي على حقول نصية لاسم المستخدم (name) والعمر (age). عند الضغط على زر الإرسال، يتم إرسال البيانات عبر طريقة POST إلى ملف insert.php. |
| 3     | *دالة JavaScript toggleStatus(id)*: ترسل طلبًا غير متزامن (AJAX) باستخدام Fetch API إلى ملف toggle.php مع معرف السجل (id)، وتتلقى الحالة الجديدة (newStatus) بعد التبديل، وتحدث النص ولون زر التبديل في الجدول مباشرة دون إعادة تحميل الصفحة. |
| 4     | *الاتصال بقاعدة البيانات*: يوجد كود PHP يتصل بقاعدة بيانات MySQL باستخدام بيانات الاتصال (localhost, root, ...)، ويضبط الترميز إلى UTF-8 لضمان دعم العربية. |
| 5     | *جلب السجلات وعرضها*: ينفذ استعلام SQL لجلب كل السجلات من جدول users (الحقول: id, name, age, status). إذا وجدت سجلات، يُعرض جدول HTML يحتوي على كل البيانات، مع الأعمدة: الرقم، الاسم، العمر، الحالة، وزر تبديل الحالة. |
| 6     | *زر تبديل الحالة*: لون الزر يتغير حسب حالة السجل (أخضر فاتح إذا مفعّل، وردي فاتح إذا غير مفعّل). عند الضغط عليه، تُستدعى دالة toggleStatus مع معرف السجل لتغيير الحالة مباشرة. |
| 7     | *التعامل مع عدم وجود سجلات*: إذا لم توجد سجلات، يعرض نصًا: "لا توجد سجلات."                                                                          |
| 8     | *إغلاق الاتصال*: يُغلق اتصال قاعدة البيانات بعد الانتهاء.                                                                                             |

### 📄 insert.php

```php
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
```

📝 *شرح الكود:*
   الرقم | شرح الخطوة                                                                                              |
|-------|--------------------------------------------------------------------------------------------------------|
| 1     | *تفعيل عرض الأخطاء*: يتم تفعيل جميع تقارير الأخطاء باستخدام error_reporting(E_ALL)، ويتم عرضها في المتصفح بواسطة ini_set('display_errors', 1) لتسهيل تصحيح المشاكل. |
| 2     | *تعريف إعدادات الاتصال بقاعدة البيانات*: يتم تحديد اسم الخادم، اسم المستخدم، كلمة المرور، واسم قاعدة البيانات في متغيرات لتسهيل إنشاء الاتصال لاحقًا.              |
| 3     | *إنشاء الاتصال*: يتم استخدام new mysqli لإنشاء اتصال بقاعدة البيانات باستخدام المعلومات المحددة.                                                   |
| 4     | *التحقق من نجاح الاتصال*: يتم فحص الاتصال باستخدام connect_error، وإذا فشل، يتم إظهار رسالة خطأ وإيقاف تنفيذ البرنامج.                                  |
| 5     | *جلب البيانات من النموذج*: يتم استخدام $_POST لجلب بيانات الحقول (name و age) المُرسلة من النموذج.                                            |
| 6     | *تحضير استعلام الإدخال*: يتم استخدام prepare لتحضير استعلام INSERT INTO users (name, age) لحماية قاعدة البيانات من هجمات الحقن (SQL Injection).           |
| 7     | *ربط المتغيرات بالاستعلام*: يتم استخدام bind_param("si", $name, $age) لربط المتغيرات بالنوع المناسب (s للنصوص، i للأرقام الصحيحة).                      |
| 8     | *تنفيذ الاستعلام*: يتم تنفيذ الاستعلام باستخدام $stmt->execute().                                                                         |
| 9     | *عرض رسالة نجاح*: عند نجاح الإدخال، يتم طباعة رسالة HTML مُنسقة تُخبر المستخدم بنجاح العملية، مع رابط للعودة للنموذج.                                 |
| 10    | *التعامل مع الخطأ*: إذا فشل الإدخال، يتم طباعة الخطأ باستخدام $stmt->error.                                                                 |
| 11    | *إغلاق الموارد*: يتم إغلاق الاستعلام ($stmt->close()) والاتصال ($conn->close()).                                                           |

 ### 🔄 toggle.php

```php
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
```

📝 *شرح الكود:*

- بدأ الاتصال بقاعدة البيانات باستخدام mysqli.
-  يحدد الترميز ليكون UTF-8 لدعم اللغة العربية.
- تحقق إذا تم إرسال id من النموذج عبر POST.
- يتعلم عن الحالة الحالية (status) للسجل بناءً على id.
-  يحدد الحالة الجديدة: إذا كانت 1 تصبح 0 والعكس.
- يُحدّث السجل في قاعدة البيانات بالحالة الجديدة.
- رجع القيمة الجديدة (echo) حتى تُستخدم لتحديث الزر في الصفحة تلقائيًا باستخدام JavaScript.
- وأخيرًا، يُغلق الاتصال بقاعدة البيانات.
  
 ### 🎨 style.css

```css
body {
    font-family: 'Cairo', sans-serif;
    background-color: #f6f6fa;
    margin: 0;
    padding: 0;
    direction: rtl;
    text-align: center;
    color: #333;
}

h1 {
    background-color: #6a1b9a;
    color: white;
    padding: 20px;
    margin: 0;
}

form {
    margin: 30px auto;
    width: 300px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(106, 27, 154, 0.2);
}

input[type="text"],
input[type="number"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
}

input[type="submit"] {
    background-color: #6a1b9a;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #8e24aa;
}

table {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
}

th {
    background-color: #d1c4e9;
}

.toggle-btn {
    padding: 8px 15px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
```


📝 *شرح الكود:* 
| العنصر                | الوصف                                                                                  |
|-----------------------|---------------------------------------------------------------------------------------|
| *body*              | يستخدم خط "Cairo" للعرض باللغة العربية. يضع لون خلفية فاتح (#f6f6fa). يجعل اتجاه الصفحة من اليمين لليسار (rtl). ينصّف النص ويضبط الهوامش بشكل أنيق. |
| *h1*                | يلوّن عنوان الصفحة بخلفية بنفسجية (#6a1b9a). يجعل النص أبيض وبحجم واضح.                |
| *form*              | يوسّط النموذج في الصفحة بعرض 300px. يضيف خلفية بيضاء وحواف دائرية. يضع ظل خفيف يعطي لمسة احترافية.         |
| *input[type="text"], input[type="number"]* | يجعل الحقول شبه ممتدة بعرض 90%. يضيف حواف ناعمة ولون حدود رمادي خفيف.                  |
| *input[type="submit"]* | زر الإرسال يأتي بلون بنفسجي مميز وخط واضح. يتغير لونه عند التمرير عليه لتعزيز تجربة المستخدم.           |
| *table*             | الجدول يمتد بنسبة 90% من عرض الصفحة. يدمج الحدود (border-collapse) لتبدو مرتبة.          |
| *th, td*            | خلايا الجدول تحوي حشوة داخلية (padding) لسهولة القراءة. رأس الجدول له لون مميز لتحديد العناوين.            |
| *.toggle-btn*       | زر الحالة يأتي بتنسيق بسيط، بدون حدود، بحواف دائرية. خطه عريض لتأكيد أنه زر تفاعلي.        |

---

## ▶️ كيفية تشغيل المشروع

1. افتح مجلد C:\xampp\htdocs في جهازك.
2. أنشئ مجلد جديد باسم: form-task
3. انسخ فيه الملفات الأربعة التالية:
- index.php
- insert.php
- toggle.php
- style.css

4. افتح *XAMPP*، ثم شغّل:
- Apache ✅
- MySQL ✅

5. ادخل إلى phpMyAdmin من الرابط:
http://localhost/phpmyadmin
6. من خيار "استيراد (Import)":
- حمّل ملف قاعدة البيانات form_task.sql الذي أنشأته المصممة.
- سيتم إنشاء قاعدة البيانات مع الجدول المطلوب تلقائيًا.

7. بعد الاستيراد، توجه للرابط التالي لتشغيل المشروع:
http://localhost/form-task/index.php
8. ابدأ بتجربة المشروع:
- أدخل اسمك وعمرك.
- اضغط على زر "إرسال".
- سيتم عرض البيانات في الجدول مع زر لتعديل الحالة.

---

## 📸 لقطات الشاشة

| 📝 الوصف                         | 🖼️ الصورة                                  |
|-------------------------------------|------------------------------------------------|
| 📋 النموذج مع الجدول                | ![النموذج + الجدول](/screenshot_form_and_table.png) |
| 🧾 تعبئة البيانات وإرسالها          | ![إدخال بيانات](/screenshot_form_submit.png)         |
| ✅ رسالة نجاح الإضافة               | ![نجاح الإضافة](/screenshot_insert_success.png)       |
| 🗄️ جدول قاعدة البيانات في phpMyAdmin | ![جدول قاعدة البيانات](/screenshot_database_table.png) |
| 🔄 الحالة قبل تبديلها              | ![قبل التبديل](/screenshot_before_toggle.png)         |
| 🔁 الحالة بعد تبديلها              | ![بعد التبديل](/screenshot_after_toggle.png)          |

---

## 📘 ما تعلمته من المشروع

- كيفية إنشاء نموذج إدخال وتخزين البيانات باستخدام PHP وMySQL.
- ربط واجهة المستخدم مع الخادم باستخدام AJAX.
- طريقة تغيير القيم وتحديث الصفحة ديناميكيًا.
- تعزيز الفهم العملي لتنسيق CSS ودمج أكثر من لغة برمجية في مشروع واحد.

---

## 🌐 رابط التشغيل

نظرًا لكون المشروع يعمل على السيرفر المحلي باستخدام XAMPP، لا يمكن مشاركة رابط مباشر عبر الإنترنت، ولكن يمكنك تشغيله باتباع خطوات "كيفية التشغيل" الموضحة أعلاه
