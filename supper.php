<?php
// الاتصال بقاعدة البيانات
$con = mysqli_connect("localhost", "root", "", "result");

// التحقق من الاتصال
if (!$con) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// جلب جميع المستخدمين من قاعدة البيانات
$result = mysqli_query($con, "SELECT * FROM users");

// برمجة القبول
if (isset($_POST['accept'])) {
    $user_id = $_POST['user_id'];
    $update = "UPDATE users SET status = 'accepted' WHERE id = $user_id";
    mysqli_query($con, $update);
    header("Location: admin.php"); // توجيه إلى صفحة الداش بورد
    exit();
}

// برمجة الرفض
if (isset($_POST['reject'])) {
    $user_id = $_POST['user_id'];
    $update = "UPDATE users SET status = 'rejected' WHERE id = $user_id";
    mysqli_query($con, $update);
    echo "تم رفض المستخدم بنجاح.";
}

// برمجة الحذف
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $delete = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($con, $delete);
    echo "تم حذف المستخدم بنجاح.";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول بيانات المستخدمين</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            direction: rtl; 
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        table { 
            width: 80%; 
            margin: 40px auto; 
            border-collapse: collapse; 
            background-color: #fff; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td { 
            padding: 15px; 
            border-bottom: 1px solid #ddd; 
            text-align: center; 
        }
        th { 
            background-color: #f0f0f0; 
            color: #333; 
            font-size: 1.1em;
        }
        button { 
            padding: 10px 15px; 
            margin: 5px; 
            cursor: pointer; 
            border: none; 
            border-radius: 5px; 
            font-size: 1em;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:focus { outline: none; }
        .accept { 
            background-color: #4CAF50; 
            color: white; 
        }
        .accept:hover { 
            background-color: #45a049;
            transform: scale(1.05);
        }
        .reject { 
            background-color: #f44336; 
            color: white; 
        }
        .reject:hover { 
            background-color: #e53935;
            transform: scale(1.05);
        }
        .delete { 
            background-color: #555; 
            color: white; 
        }
        .delete:hover { 
            background-color: #444;
            transform: scale(1.05);
        }
        /* تصميم الهيكل الرئيسي */
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>جدول بيانات المستخدمين</h2>
    <table>
        <thead>
            <tr>
                <th>الاسم الكامل</th>
                <th>رقم التليفون</th>
                <th>الرقم القومي</th>
                <th>البريد الإلكتروني</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // الاتصال بقاعدة البيانات وجلب البيانات
            $con = mysqli_connect("localhost", "root", "", "result");
            $result = mysqli_query($con, "SELECT * FROM users");
            while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['national_id']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="accept" class="accept">قبول</button>
                    </form>
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="reject" class="reject">رفض</button>
                    </form>
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" class="delete">حذف</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

