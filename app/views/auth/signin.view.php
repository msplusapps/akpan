<?php $_SESSION['last'] = $_SERVER['REQUEST_URI']; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <style>
        body {
            background: #1a1a2e;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #16222a;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h1 {
            color: #00ffff;
            margin-bottom: 20px;
        }

        .error {
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.2);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #00ffff;
            background: transparent;
            color: #ffffff;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 10px #00ffff;
        }

        .btn {
            flex: 1;
            background: #00ffff;
            color: #16222a;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #00e6e6;
        }

        .btn-secondary {
            background: transparent;
            color: #00ffff;
            border: 2px solid #00ffff;
        }

        .btn-secondary:hover {
            background: #00ffff;
            color: #16222a;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #00ffff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <img src="<?= asset('images/login.gif') ?>" alt="Login Animation" class="gif">

        <h1>Login</h1>

        <?php if (!empty($error)) : ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <?= csrf_token(); ?>

            <div style="margin-bottom: 15px;">
                <input type="text" name="user" placeholder="Email or Phone" required>
            </div>

            <div style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="submit" class="btn">Login</button>
                <a href="<?= url('auth/register') ?>" class="btn btn-secondary">Sign Up</a>
            </div>
        </form>
        <a href="../" class="back-link">← Back to Homepage</a>
    </div>
</body>

</html>
