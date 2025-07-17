<?php get_header("views/admin"); ?>
<style>
    section.py-16.bg-gray-100.min-h-screen {
        width: 100vw;
    }
</style>

<section class="py-16 bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-10">⚙️ Dashboard Overview</h2>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Plugins -->
            <a  class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #667eea, #764ba2);">
                <h3 class="text-lg font-semibold mb-2">🧩 Plugins</h3>
                <p class="text-4xl font-bold"><?= count(glob('app/plugins/*', GLOB_ONLYDIR)); ?></p>
            </a>

            <!-- Middlewares -->
            <div class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #f7971e, #ffd200);">
                <h3 class="text-lg font-semibold mb-2">🛡️ Middlewares</h3>
                <p class="text-4xl font-bold"><?= count(glob('app/middlewares/*.php')); ?></p>
            </div>

            <!-- Routes -->
            <div class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #11998e, #38ef7d);">
                <h3 class="text-lg font-semibold mb-2">🛣️ Routes</h3>
                <p class="text-4xl font-bold"><?= count(glob('app/routes/*.php')); ?></p>
            </div>

            <!-- Migrations -->
            <div class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #DA22FF, #9733EE);">
                <h3 class="text-lg font-semibold mb-2">📦 Migrations</h3>
                <p class="text-4xl font-bold"><?= count(glob('app/migrations/*.sql')); ?></p>
            </div>

            <!-- Docs -->
            <div class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #FF416C, #FF4B2B);">
                <h3 class="text-lg font-semibold mb-2">📄 Docs</h3>
                <p class="text-4xl font-bold"><?= count(glob('app/docs/*.php')); ?></p>
            </div>

            <!-- Total Project Size -->
            <div class="rounded-xl p-6 shadow-md text-white" style="background: linear-gradient(to right, #00c6ff, #0072ff);">
                <h3 class="text-lg font-semibold mb-2">🗂️ Total Project Size</h3>
                <p class="text-2xl font-bold"><?= formatSize(getFolderSize('.')); ?></p>
            </div>
        </div>

        <!-- Project Image -->
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4">🖼️ Project Screenshot</h3>
            <img src="/public/assets/images/project-screenshot.png" alt="Project Screenshot" class="rounded-xl shadow-lg max-w-full">
        </div>

        <!-- Storage Analysis -->
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4">📊 Storage Usage by Folders</h3>
            <ul class="space-y-2">
                <?php foreach (getFolderBreakdown('.') as $folder => $size): ?>
                    <li class="bg-white p-4 rounded-md shadow-sm flex justify-between items-center">
                        <span class="font-medium"><?= $folder ?></span>
                        <span class="text-sm text-gray-600"><?= formatSize($size) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php
function getFolderSize($dir) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $file) {
        if (strpos($file->getPathname(), '.git') !== false || strpos($file->getPathname(), 'vendor') !== false) continue;
        $size += $file->getSize();
    }
    return $size;
}

function formatSize($bytes) {
    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($sizes) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $sizes[$i];
}

function getFolderBreakdown($dir) {
    $sizes = [];
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file) && basename($file) !== 'vendor' && basename($file) !== '.git') {
            $sizes[basename($file)] = getFolderSize($file);
        }
    }
    arsort($sizes); // Show largest folders first
    return $sizes;
}
?>

<?php get_footer("views/admin"); ?>