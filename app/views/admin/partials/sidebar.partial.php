<aside class="w-64 bg-gray-800 text-white flex flex-col px-4 py-6 space-y-4">
    <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
    <nav class="space-y-3">
        <a href="<?= url('./admin/')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Dashboard</a>
        <a href="<?= url('./admin/routes')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Routes</a>
        <a href="<?= url('./admin/controllers')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Controllers</a>
        <a href="<?= url('./admin/plugins')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Plugins</a>
        <a href="<?= url('./admin/migrations')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Migrations</a>
        <a href="<?= url('./admin/middlewares')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Middlewares</a>
        <a href="<?= url('./admin/users')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Users</a>
        <a href="<?= url('./admin/assets')?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">Assets</a>
    </nav>
</aside>