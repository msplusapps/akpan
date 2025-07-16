<!DOCTYPE html>
<html>
<head>
    <title>Image Resizer</title>
</head>
<body>
    <h1>Image Resizer</h1>
    <form action="/imageresizer/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="image" />
        <input type="submit" value="Upload" />
    </form>

    <hr>

    <h2>Resized Images</h2>
    <?php if (isset($images) && !empty($images)): ?>
        <ul>
            <?php foreach ($images as $image): ?>
                <li>
                    <a href="/<?php echo $image; ?>" target="_blank">
                        <img src="/<?php echo $image; ?>" />
                    </a>
                    <br>
                    <input type="text" value="<?php echo url($image); ?>" />
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No images uploaded yet.</p>
    <?php endif; ?>
</body>
</html>
