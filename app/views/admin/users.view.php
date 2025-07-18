<?php get_header("views/admin"); ?>
<main class="flex-1 bg-gray-100 overflow-y-auto">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">All Registered Users</h1>
            <p class="text-lg max-w-3xl opacity-90">
                This is a list of all users stored in the system.
            </p>
        </div>
    </section>

    <!-- Users -->
    <div class="p-8">
        <?php

        use App\Models\User;

        $user = new User();
        $users = $user->all();
        ?>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
            <?php foreach ($users as $user): ?>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:border-green-500 transition">
                    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($user['name'] ?? 'Unnamed') ?></h2>
                    <p class="text-gray-600"><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '-') ?></p>
                    <p class="text-gray-600"><strong>Role:</strong> <?= htmlspecialchars($user['role'] ?? 'User') ?></p>
                    <p class="text-sm text-gray-400 mt-2">Created at: <?= $user['created_at'] ?? 'N/A' ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php get_footer("views/admin"); ?>
