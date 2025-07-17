<?php
$method = strtoupper($route->getMethod());
$uri = $route->getUri();
$action = $route->getAction();
$middlewares = implode(', ', array_map('htmlspecialchars', $route->getMiddleware()));

$methodColor = match ($method) {
    'GET' => 'text-green-600',
    'POST' => 'text-blue-600',
    'DELETE' => 'text-red-600',
    'PUT' => 'text-yellow-600',
    default => 'text-gray-600',
};

$category = is_array($action) && str_starts_with($action[0], 'App\\Plugins\\') ? 'Plugin' : 'Core';
$categoryColor = $category === 'Plugin' ? 'bg-orange-500' : 'bg-green-500';
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
