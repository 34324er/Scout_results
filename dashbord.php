<?php 
$con = mysqli_connect("localhost", "root", "", "result");

// التحقق من البحث
if (isset($_POST['search'])) {
    $search_value = $_POST['search'];
    $query = "SELECT * FROM admins WHERE name_student LIKE '%$search_value%' OR code LIKE '%$search_value%'";
} else {
    $query = "SELECT * FROM admins";
}

$result = mysqli_query($con, $query);

// حذف طالب بناءً على الكود
if (isset($_POST['delete_code'])) {
    $code_to_delete = $_POST['delete_code'];
    $delete_query = "DELETE FROM admins WHERE code = '$code_to_delete'";
    mysqli_query($con, $delete_query);
    header("Location: ".$_SERVER['PHP_SELF']); // إعادة تحميل الصفحة بعد الحذف
    exit();
}

// حذف جميع الصفوف في الجدول
if (isset($_POST['delete_all'])) {
    $delete_all_query = "DELETE FROM admins";
    mysqli_query($con, $delete_all_query);
    echo "<h1 class='title_delete' style='color:red; text-align:center; margin-top:50px;'> تم حذف جميع بيانات الطلاب بنجاح </h1>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المخدومين</title>
    <link rel="stylesheet" href="dashbord.css">
</head>
<body>
    <div class="container">
        <h1>لوحة تحكم المخدومين</h1>

        <form action="" method="post">
            <!-- خانة البحث -->
            <div class="search-container">
                <input type="text" placeholder="ابحث عن طالب" class="search-input" name="search">
                <button type="submit" class="search-btn">بحث</button>
            </div>

           <!-- زر حذف جميع البيانات -->
           <div class="delete-all-container">
                <button class="delete-all-btn" name="delete_all">حذف جميع البيانات</button>
            </div>
        </form>

        <!-- جدول عرض المخدومين -->
        <table>
            <thead>
                <tr>
                    <th>إجراءات</th>
                    <th>حالة الطالب</th>
                    <th>مرحلة الطالب</th>
                    <th>التقدير</th>
                    <th>الدرجة</th>
                    <th>الكود</th>
                    <th>اسم الطالب</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // التحقق من وجود نتائج
                if (mysqli_num_rows($result) > 0) {
                    // عرض كل صف من البيانات
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>
                                <form method='post' style='display:inline;'>
                                    <input type='hidden' name='delete_code' value='".$row['code']."'>
                                    <button type='submit' class='delete-btn'>حذف</button>
                                </form>
                              </td>";
                        echo "<td>" . $row['the_condition'] . "</td>";
                        echo "<td>" . $row['level'] . "</td>";
                        echo "<td>" . $row['appreciation'] . "</td>";
                        echo "<td>" . $row['dagree'] . "</td>";
                        echo "<td>" . $row['code'] . "</td>";
                        echo "<td>" . $row['name_student'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>لا توجد بيانات للعرض</td></tr>";
                }
            ?>    
            </tbody>
        </table>
    </div>
</body>
</html>
