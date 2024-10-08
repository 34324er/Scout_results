<?php
$con = mysqli_connect("localhost", "root", "", "result");
?>
<!DOCTYPE html>
<html lang="ar"> <!-- استخدام "ar" للغة العربية -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>نتائج اختبار نهاية العام</title>
    <meta name="keywords" content="كشافة, نتائج امتحانات, مجموعة العذراء والأمير الكشفية, نتائج الكشافة, استعلام عن النتيجة, التعليم الكشفي, الأنشطة الكشفية, كود الطالب, نتائج نهاية العام, نتائج الطلاب, برامج الكشفية, موقع كشافة">
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>مجموعة العذراء والأمير الكشفية </h1>
            <h2>موقع إعلان نتائج امتحانات نهاية العام </h2>
        </div>
        <!-- الفورم الذي يستقبل كود الطالب للبحث عن النتيجة -->
        <form action="result.php" method="post">
            <label for="code">أدخل الكود الخاص بك</label>
            <!-- إدخال الكود الذي سيتم البحث عنه -->
            <input type="text" id="code" name="code" placeholder="أدخل الكود هنا" required>
            <button type="submit" name="search_result">استعلام عن النتيجة</button>
        </form>
    </div>
</body>
</html>
