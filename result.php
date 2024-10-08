<?php
$con = mysqli_connect("localhost", "root", "", "result");

// التحقق من أن النموذج أرسل البيانات عن طريق الزر
if (isset($_POST['search_result'])) {
    // استلام كود الطالب المدخل من الفورم
    $code = $_POST['code'];

    // كتابة استعلام SQL لجلب بيانات الطالب من قاعدة البيانات بناءً على الكود
    $query = "SELECT * FROM admins WHERE code = '$code'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        // في حالة فشل الاستعلام، يتم طباعة رسالة خطأ SQL
        echo "خطأ في استعلام قاعدة البيانات: " . mysqli_error($con);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        // جلب البيانات كصف واحد
        $row = mysqli_fetch_assoc($result);

        // تخزين البيانات في متغيرات لعرضها لاحقًا في صفحة HTML
        $name = $row['name_student'];
        $code = $row['code'];
        $level = $row['level'];
        $dagree = $row['dagree'];
        $appreciation = $row['appreciation'];
        $the_condition = $row['the_condition'];
    } else {
        // في حالة عدم وجود بيانات الطالب، يتم عرض رسالة خطأ
        echo "لم يتم العثور على أي نتائج بهذا الكود.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجة نهاية العام - مجموعة العذراء والأمير الكشفية</title>
    <link rel="stylesheet" href="./result.css">
</head>
<body>
    <div class="container">
        <h1>مجموعة العذراء والأمير الكشفية - التمساحية</h1>
        <h2>بيان نجاح نهاية العام 2024</h2>
        
            
        <table>
            <tr>
                <td><?php echo $name; ?></td>
                <th>الاسم</th>
            </tr>
            <tr>
                <td><?php echo $code; ?></td>
                <th>كود المخدوم</th>
            </tr>
            <tr>
                <td><?php echo $level; ?></td>
                <th>مرحلة</th>
            </tr>
            <tr>
                <td><?php echo $dagree . '%'; ?></td>
                <th>المجموع </th>
            </tr>
            <tr>
                <td><?php echo $appreciation; ?></td>
                <th>التقدير</th>
            </tr>
            <tr>
                <td><?php echo $the_condition; ?></td>
                <th>حالة الطالب</th>
            </tr> 
        </table>


        <button id="printButton">طباعة النتيجة</button>
    </div>
    <script src="result.js"></script>
</body>
</html>
