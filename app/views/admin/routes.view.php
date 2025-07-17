<?php get_header("views/admin"); ?>
    <main class="flex-1 bg-gray-100 overflow-y-auto">

        <!-- Hero -->
        <section class="bg-gradient-to-r from-blue-600 via-cyan-600 to-green-500 text-white py-20 px-10">
            <div class="text-left">
                <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Registered Routes</h1>
                <p class="text-lg max-w-3xl opacity-90">
                    These are all routes currently registered in the framework.
                </p>
            </div>
        </section>

        <!-- Routes -->
        <div class="p-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($routes as $route): ?>
                <?php
                    $method = strtoupper($route->getMethod());
                    $uri = $route->getUri();
                    $action = $route->getAction();
                    $middlewares = implode(', ', array_map('htmlspecialchars', $route->getMiddleware()));

                    // Determine category
                    $isPlugin = is_array($action) && str_starts_with($action[0], 'App\\Plugins\\');
                    $category = $isPlugin ? 'Plugin' : 'Core';

                    // Method color
                    $methodColor = match($method) {
                        'GET' => 'text-green-600',
                        'POST' => 'text-blue-600',
                        'DELETE' => 'text-red-600',
                        'PUT' => 'text-yellow-600',
                        default => 'text-gray-600',
                    };

                    // Category color
                    $categoryColor = $isPlugin ? 'bg-orange-500' : 'bg-green-500';
                ?>
                <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200 hover:shadow-xl transition">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold uppercase <?= $methodColor ?>"><?= $method ?></span>
                        <span class="text-sm text-white px-3 py-1 rounded-full <?= $categoryColor ?>">
                            <?= $category ?>
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($uri) ?></h3>
                    <p class="text-gray-700"><strong>Controller:</strong> <?= is_array($action) ? htmlspecialchars($action[0]) : 'N/A' ?></p>
                    <p class="text-gray-700"><strong>Function:</strong> <?= is_array($action) ? htmlspecialchars($action[1]) : 'N/A' ?></p>
                    <p class="text-gray-700"><strong>Middleware:</strong> <?= $middlewares ?: 'None' ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </main>
<?php get_footer("views/admin"); ?>