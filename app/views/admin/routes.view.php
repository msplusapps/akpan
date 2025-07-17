<?php get_header("views/admin"); ?>
<main class="flex-1 bg-gray-100 overflow-y-auto">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-blue-600 via-cyan-600 to-green-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Registered Routes</h1>
            <p class="text-lg max-w-3xl opacity-90">
                These are all routes currently registered in the framework, including plugin and core routes.
            </p>
        </div>
    </section>

    <!-- Routes -->
    <div class="p-8">
        <?php
        $grouped = [
            'Core' => [],
            'Plugins' => []
        ];

        foreach ($routes as $route) {
            $action = $route->getAction();
            $isPlugin = is_array($action) && str_starts_with($action[0], 'App\\Plugins\\');
            

            if ($isPlugin) {
                preg_match('/App\\\\Plugins\\\\([^\\\\]+)/', $action[0], $matches);
                $pluginName = $matches[1] ?? 'Unknown';
                $grouped['Plugins'][$pluginName][] = $route;
            } else {
                $grouped['Core'][] = $route;
            }
        }
        ?>

        <!-- Core Routes -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Core Routes</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
            <?php foreach ($grouped['Core'] as $route): ?>
                <?php include 'route-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Plugin Routes -->
        <?php foreach ($grouped['Plugins'] as $plugin => $pluginRoutes): ?>
            <h2 class="text-2xl font-bold mb-4 text-orange-700"><?= htmlspecialchars($plugin) ?> Plugin</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
                <?php foreach ($pluginRoutes as $route): ?>
                    <?php include 'route-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php get_footer("views/admin"); ?>
