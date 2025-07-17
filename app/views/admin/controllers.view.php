<?php get_header("views/admin");?>
<main class="flex-1 bg-gray-100 overflow-y-auto">
    <!-- Hero -->
    <section class="bg-gradient-to-r from-blue-600 via-cyan-600 to-green-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Registered Controllers</h1>
            <p class="text-lg max-w-3xl opacity-90">
                These are all controllers currently registered in the framework.
            </p>
        </div>
    </section>

    <!-- Unregistered Controllers -->
    <section class="px-8 pt-10 pb-6">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Discovered Controllers (Unregistered)</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php
            $allControllers = array_merge(
                glob("app/controllers/*.php"),
                glob("app/plugins/*/controllers/*.php")
            );

            $registeredControllers = array_map(function($route) {
                return is_array($route->getAction()) ? $route->getAction()[0] : null;
            }, $routes);

            foreach ($allControllers as $file) {
                if (basename($file) === 'index.php') continue; // Skip index.php

                require_once $file;

                $className = get_declared_classes()[array_key_last(get_declared_classes())];

                if (!class_exists($className)) continue;

                $reflector = new ReflectionClass($className);
                if ($reflector->isAbstract()) continue;

                $methods = $reflector->getMethods(ReflectionMethod::IS_PUBLIC);

                echo "<div class='bg-white rounded-2xl p-6 shadow-md border border-dashed border-gray-300'>";
                echo "<h3 class='text-xl font-semibold text-purple-600 mb-2'>" . htmlspecialchars($className) . "</h3>";

                echo "<ul class='text-gray-700 space-y-1'>";
                foreach ($methods as $method) {
                    if ($method->class === $className && $method->name !== '__construct') {
                        echo "<li>🔧 <span class='font-semibold'>{$method->name}()</span></li>";
                    }
                }
                echo "</ul></div>";
            }
            ?>
        </div>
    </section>

</main>
<?php get_footer("views/admin"); ?>