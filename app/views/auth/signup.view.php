<?php $old = $old ?? []; ?>
<?php $_SESSION['last'] = $_SERVER['REQUEST_URI']; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="card">
        <img src="<?= asset('images/login.gif') ?>" alt="Register Animation" class="gif">
        <h1>Sign Up</h1>

        <?php if (!empty($error)) : ?>
            <p style="color: #ffcccc; background:#660000; padding: 8px; border-radius: 8px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <?= csrf_token(); ?>

            <div style="margin-bottom: 15px;">
                <input type="text" name="name" placeholder="Full Name" required
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <input type="email" name="email" placeholder="Email Address" required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
            </div>

            <div style="margin-bottom: 15px; position: relative;">
                <input type="password" name="password" id="password" placeholder="Create Password" required
                    value="<?= htmlspecialchars($old['password'] ?? '') ?>"
                    style="width: 100%; padding: 10px 40px 10px 10px; border-radius: 8px; border: none;">
                <span onclick="togglePassword('password')" style="
                    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                    cursor: pointer; color: #999; font-size: 14px;">👁️</span>
            </div>

            <div style="margin-bottom: 15px; position: relative;">
                <input type="password" name="confirm_password" id="confirm_password" 
                value="<?= htmlspecialchars($old['confirm_password'] ?? '') ?>"placeholder="Confirm Password" required
                    style="width: 100%; padding: 10px 40px 10px 10px; border-radius: 8px; border: none;">
                <span onclick="togglePassword('confirm_password')" style="
                    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                    cursor: pointer; color: #999; font-size: 14px;">👁️</span>
            </div>

            <button type="submit" style="
                width: 100%;
                background: #ffffff;
                color: #6a11cb;
                padding: 12px;
                border: none;
                border-radius: 8px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s;
            ">Register</button>

            <a href="<?= url('auth/login') ?>" style="
                display: block;
                text-align: center;
                margin-top: 15px;
                color: #ffffff;
                text-decoration: underline;
            ">Already have an account? Login</a>
        </form>

        <a href="../" class="back-link">← Back to Homepage</a>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>
