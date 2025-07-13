<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="card">
        <img src="<?= asset('images/login.gif') ?>" alt="Login Animation" class="gif">

        <h1>Login</h1>

        <?php if (!empty($error)) : ?>
            <p style="color: #ffcccc; background:#660000; padding: 8px; border-radius: 8px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <input type="text" name="email" placeholder="Email" required
                       style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
            </div>
            <div style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Password" required
                       style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
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
            ">Login</button>
        </form>

        <a href="../" class="back-link">← Back to Homepage</a>
    </div>
</body>

</html>
