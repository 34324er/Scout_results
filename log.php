<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-size: 1.1em;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db; /* اللون الأزرق المطلوب */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2980b9; /* لون أغمق عند التمرير */
        }
        .error-message {
            color: #f44336;
            text-align: center;
            margin-bottom: 15px;
        }
        .success-message {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>تسجيل الدخول</h2>
        <?php
        // الاتصال بقاعدة البيانات
        $con = mysqli_connect("localhost", "root", "", "result");

        // التحقق من بيانات تسجيل الدخول
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // جلب المستخدم من قاعدة البيانات
            $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");

            // التأكد من وجود المستخدم
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                // التحقق من حالة المستخدم
                if ($user['status'] == 'accepted') {
                    // السماح بالدخول
                    echo '<p class="success-message">تم تسجيل الدخول بنجاح!</p>';
                } elseif ($user['status'] == 'rejected') {
                    // منع المستخدم من الدخول
                    echo '<p class="error-message">عذرًا، تم رفض طلبك ولا يمكنك الدخول.</p>';
                } else {
                    // حالة أخرى (مثلاً لم يتم القبول بعد)
                    echo '<p class="error-message">لم يتم قبولك بعد. يرجى الانتظار حتى يتم مراجعة طلبك.</p>';
                }
            } else {
                echo '<p class="error-message">بيانات الدخول غير صحيحة.</p>';
            }
        }
        ?>

        <form method="post">
            <input type="email" name="email" id="email" required placeholder="البريد الإلكتروني">
            <input type="password" name="password" id="password" required  placeholder="كلمة المرور">
            <button type="submit" name="login">تسجيل الدخول</button>
        </form>
    </div>

</body>
</html>
