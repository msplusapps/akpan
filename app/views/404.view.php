<?php if (!function_exists('asset')) { echo "❌ asset() not found"; exit; } ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="card">
        <img src="<?= asset('images/404.gif') ?>" alt="404 Animation" class="gif">

        <h1>404</h1>
        <p><strong><?= $message ?? 'Page Not Found' ?></strong></p>
        <p><strong>File:</strong> <code><?= $file ?? 'N/A' ?></code></p>
        <a href="./" class="back-link">← Go Back Home</a>
        <a target="_blank" href="./logs/error.log" class="back-link">← View Errors</a>
    </div>
</body>

</html>