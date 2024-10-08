<?php 
// الاتصال بقاعدة البيانات
$con = mysqli_connect("localhost", "root", "", "result");

// تحقق من الاتصال
if (!$con) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المخدومين</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>إدارة المخدومين</h1>

        <div class="form-container">
            <form id="manage-form" method="POST">
                <div class="form-group">
                    <input type="text" id="name" name="name_student" placeholder="أدخل اسم الطالب" required>
                </div>

                <div class="form-group">
                    <input type="text" id="code" name="code" placeholder="أدخل الكود" required>
                </div>

                <div class="form-group">
                    <label for="assessment">اختر المرحلة</label>
                    <select name="level" id="level" required>
                        <option value=" أشبال وزهرات"> أشبال وزهرات </option>
                        <option value="كشافة ومرشدات">كشافة ومرشدات</option>
                        <option value=" متقدم">متقدم</option>
                        <option value=" جوالة"> جوالة</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" id="grade" name="dagree" placeholder="أدخل الدرجة" required>
                </div>

                <div class="form-group">
                    <label for="assessment">التقدير</label>
                    <select name="appreciation" id="appreciation" required>
                        <option value="أمتياز">أمتياز</option>
                        <option value="جيد جداً">جيد جداً</option>
                        <option value="جيد">جيد</option>
                        <option value="مقبول">مقبول</option>
                        <option value="لا يستحق">لا يستحق</option>
                    </select>
                </div>

                <label for="status" class="rr">حالة الطالب</label>
                <div class="form-group_2">
                   <input type="radio" id="status" name="the_condition" value="ناجح" required><p>ناجح</p>
                   <input type="radio" id="status" name="the_condition" value="راسب"><p>راسب</p>
                </div>

                <div class="buttons">
                    <!-- عمل زر عرض البيانات -->
                    <button type="button" id="show-btn" class="show-btn" onclick="window.location.href='dashbord.php';">عرض البيانات</button>
                    <button type="submit" class="edit-btn" name="edit">تعديل طالب</button>
                    <button type="submit" class="add-btn" name="add">إضافة طالب</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


<?php 
// تحقق من الضغط على زر الإضافة
if (isset($_POST['add'])) {
    $name_student = $_POST['name_student'];
    $code = $_POST['code'];
    $level = $_POST['level'];
    $dagree = intval($_POST['dagree']); // تحويل إلى عدد صحيح
    $appreciation = $_POST['appreciation'];
    $the_condition = $_POST['the_condition'];

    // استعلام الإدخال
    $insert = "INSERT INTO admins (name_student, code, level, dagree, appreciation, the_condition)
               VALUES ('$name_student', '$code', '$level', '$dagree', '$appreciation', '$the_condition')";
   
    $result = mysqli_query($con, $insert);

    // التحقق من نجاح الإدخال
    if ($result) {
    } else {
        echo "حدث خطأ أثناء إضافة الطالب: " . mysqli_error($con);
    }
}

// تحقق من الضغط على زر التعديل
if (isset($_POST['edit'])) {
    $name_student = $_POST['name_student'];
    $code = $_POST['code'];
    $level = $_POST['level'];
    $dagree = intval($_POST['dagree']); // تحويل إلى عدد صحيح
    $appreciation = $_POST['appreciation'];
    $the_condition = $_POST['the_condition'];

    // استعلام التعديل
    $update = "UPDATE admins SET 
               name_student='$name_student', 
               level='$level', 
               dagree='$dagree', 
               appreciation='$appreciation', 
               the_condition='$the_condition' 
               WHERE code='$code'";

    $result = mysqli_query($con, $update);

    // التحقق من نجاح التعديل
    if ($result) {
   
    } else {
        echo "حدث خطأ أثناء تعديل بيانات الطالب: " . mysqli_error($con);
    }
}
?>
