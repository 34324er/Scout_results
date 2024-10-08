<?php
// الاتصال بقاعدة البيانات
$con = mysqli_connect("localhost", "root", "", "result");

// التحقق من الاتصال
if (!$con) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// متغيرات لتخزين رسائل الخطأ
$fullname_error = $phone_error = $national_id_error = $email_error = $password_error = '';
$success_message = '';

// التحقق مما إذا كان النموذج قد أرسل
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استلام بيانات التسجيل
    $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $national_id = htmlspecialchars(trim($_POST['national_id'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    // التحقق من صحة الحقول
    if (empty($fullname)) {
        $fullname_error = "الاسم الكامل مطلوب.";
    }

    if (empty($phone)) {
        $phone_error = "رقم التليفون مطلوب.";
    }

    if (empty($national_id)) {
        $national_id_error = "الرقم القومي مطلوب.";
    }

    if (empty($email)) {
        $email_error = "البريد الإلكتروني مطلوب.";
    }

    if (empty($password)) {
        $password_error = "كلمة المرور مطلوبة.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // التأكد من عدم وجود بيانات مكررة (البريد الإلكتروني أو الرقم القومي)
    if (empty($fullname_error) && empty($phone_error) && empty($national_id_error) && empty($email_error) && empty($password_error)) {
        // استخدم الجمل المحضرة لحماية الاستعلامات
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? OR national_id = ?");
        $stmt->bind_param("ss", $email, $national_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $email_error = "البريد الإلكتروني أو الرقم القومي مُسجل بالفعل.";
        } else {
            // إدخال البيانات إلى قاعدة البيانات باستخدام الجمل المحضرة
            $stmt = $con->prepare("INSERT INTO users (fullname, phone, national_id, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $phone, $national_id, $email, $hashed_password);
            if ($stmt->execute()) {
                $success_message = "تم التسجيل بنجاح.";
            } else {
                echo "حدث خطأ: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الاشتراك</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error { color: red; font-size: 0.9em; }
        .success { color: green; font-size: 1.1em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>تسجيل الاشتراك</h1>

        <!-- عرض رسالة النجاح إن وجدت -->
        <?php if ($success_message): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <input type="text" name="fullname" placeholder="الاسم الكامل" value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>" required>
                <p class="error"><?php echo $fullname_error; ?></p>
            </div>

            <div>
                <input type="text" name="phone" placeholder="رقم التليفون" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
                <p class="error"><?php echo $phone_error; ?></p>
            </div>

            <div>
                <input type="text" name="national_id" placeholder="الرقم القومي" value="<?php echo isset($national_id) ? htmlspecialchars($national_id) : ''; ?>" required>
                <p class="error"><?php echo $national_id_error; ?></p>
            </div>

            <div>
                <input type="email" name="email" placeholder="البريد الإلكتروني" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                <p class="error"><?php echo $email_error; ?></p>
            </div>

            <div>
                <input type="password" name="password" placeholder="كلمة المرور" required>
                <p class="error"><?php echo $password_error; ?></p>
            </div>

            <button type="submit">تسجيل</button>
        </form>
    </div>
</body>
</html>
