<?php get_header("views/admin"); ?>
<main class="flex-1 bg-gray-100 overflow-y-auto min-h-screen">
    <section class="bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 text-white py-20 px-10">
        <div class="text-left max-w-6xl mx-auto">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">File Explorer (Grid View)</h1>
            <p class="text-lg max-w-3xl opacity-90">
                Explore all top-level directories and files in your project root.
            </p>
        </div>
    </section>

    <section class="px-8 pt-10 pb-20 max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Project Root Structure</h2>

        <style>
            /* Grid container for top-level */
            .top-level-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.25rem;
            }
            /* Folder/File cards */
            .card {
                background: white;
                border-radius: 1rem;
                padding: 1rem 1.25rem;
                box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
                cursor: pointer;
                user-select: none;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }
            .card .header {
                font-weight: 700;
                font-size: 1.2rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: #4f46e5; /* indigo-600 */
            }
            .card .header:hover {
                color: #4338ca; /* indigo-700 */
            }
            .arrow {
                transition: transform 0.2s ease;
                display: inline-block;
                margin-right: 0.5rem;
            }
            .rotate {
                transform: rotate(90deg);
            }

            /* Nested file/folder lists inside card */
            .nested-list {
                margin-left: 1rem;
                border-left: 2px solid #ddd;
                padding-left: 1rem;
                max-height: 350px;
                overflow-y: auto;
            }
            .nested-list ul {
                list-style: none;
                padding-left: 0;
                margin: 0;
            }
            .nested-list li.folder {
                font-weight: 600;
                margin: 0.25rem 0;
                cursor: pointer;
                display: flex;
                align-items: center;
            }
            .nested-list li.file {
                margin: 0.15rem 0 0.15rem 1.75rem;
                color: #444;
                font-size: 0.95rem;
                display: flex;
                justify-content: space-between;
            }
            .nested-list .file-size {
                color: #888;
                font-size: 0.8rem;
                margin-left: 0.5rem;
                white-space: nowrap;
            }
        </style>

        <div class="top-level-grid">
            <?php
            function formatSize($bytes) {
                $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
                $i = 0;
                while ($bytes >= 1024 && $i < count($sizes) - 1) {
                    $bytes /= 1024;
                    $i++;
                }
                return round($bytes, 2) . ' ' . $sizes[$i];
            }

            function renderNestedTree($dir, $parentId) {
                $items = scandir($dir);
                $items = array_diff($items, ['.', '..']);
                if (empty($items)) return;

                echo "<div class='nested-list' id='nested-$parentId' style='display:none;'>";
                echo "<ul>";
                foreach ($items as $item) {
                    $path = "$dir/$item";
                    $id = md5($path);

                    if (is_dir($path)) {
                        echo "<li class='folder' onclick=\"toggleNested('$id')\">";
                        echo "<span class='arrow' id='nested-arrow-$id'>▶</span>📁 " . htmlspecialchars($item);
                        echo "</li>";
                        renderNestedTree($path, $id);
                    } else {
                        $size = filesize($path);
                        echo "<li class='file'>📄 " . htmlspecialchars($item) . "<span class='file-size'>(" . formatSize($size) . ")</span></li>";
                    }
                }
                echo "</ul></div>";
            }

            $rootDir = '.';
            $topLevelItems = scandir($rootDir);
            $topLevelItems = array_diff($topLevelItems, ['.', '..']);

            foreach ($topLevelItems as $item) {
                $path = "$rootDir/$item";
                $id = md5($path);
                if (is_dir($path)) {
                    echo "<div class='card'>";
                    echo "<div class='header' onclick=\"toggle('$id')\">";
                    echo "<span><span class='arrow' id='arrow-$id'>▶</span>📁 " . htmlspecialchars($item) . "</span>";
                    echo "<span>+</span>";
                    echo "</div>";
                    renderNestedTree($path, $id);
                    echo "</div>";
                } else {
                    $size = filesize($path);
                    echo "<div class='card file'>";
                    echo "<div class='header'>📄 " . htmlspecialchars($item) . "<span class='file-size'> (" . formatSize($size) . ")</span></div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </section>

    <script>
        function toggle(id) {
            const el = document.getElementById('nested-' + id);
            const arrow = document.getElementById('arrow-' + id);
            if (!el) return;

            if (el.style.display === 'none') {
                el.style.display = 'block';
                arrow.classList.add('rotate');
            } else {
                el.style.display = 'none';
                arrow.classList.remove('rotate');
            }
        }

        function toggleNested(id) {
            const el = document.getElementById('nested-' + id);
            const arrow = document.getElementById('nested-arrow-' + id);
            if (!el) return;

            if (el.style.display === 'none') {
                el.style.display = 'block';
                arrow.classList.add('rotate');
            } else {
                el.style.display = 'none';
                arrow.classList.remove('rotate');
            }
        }
    </script>
</main>
<?php get_footer("views/admin"); ?>
