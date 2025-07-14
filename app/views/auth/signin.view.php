<?php $_SESSION['last'] = $_SERVER['REQUEST_URI']; ?>
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
            <p style="color: #ffcccc; background:#ad0000; padding: 8px; border-radius: 8px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <?= csrf_token(); ?>

            <div style="margin-bottom: 15px;">
                <input type="text" name="user" placeholder="Email or Phone" required
                    style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Password" required
                    style="width: 100%; padding: 10px; border-radius: 8px; border: none;">
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="submit" style="
                    flex: 1;
                    background: #ffffff;
                    color: #6a11cb;
                    padding: 12px;
                    border: none;
                    border-radius: 8px;
                    font-weight: bold;
                    cursor: pointer;
                    transition: 0.3s;
                ">Login</button>

                <a href="<?= url('auth/register') ?>" style="
                    flex: 1;
                    display: inline-block;
                    text-align: center;
                    background: transparent;
                    color: #ffffff;
                    border: 2px solid #ffffff;
                    padding: 12px;
                    border-radius: 8px;
                    font-weight: bold;
                    text-decoration: none;
                    transition: 0.3s;
                ">Sign Up</a>
            </div>
        </form>
        <a href="../" class="back-link">← Back to Homepage</a>
    </div>
</body>

</html>
