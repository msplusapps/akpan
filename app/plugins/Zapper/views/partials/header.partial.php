<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapper | Modern File Transfer</title>
    <script src="<?=asset("libs/tailwind.js")?>"></script>
    <link rel="stylesheet" href="<?=asset("libs/fontawesome-free-6.7.2/css/all.min.css")?>">
    <script src="<?=asset("libs/jquery-3.6.0.min.js")?>"></script>
    <script src="<?=asset("libs/qrcode.min.js")?>"></script>
    <link rel="stylesheet" href="<?=asset("css/zapper.css")?>">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="gradient-bg text-white shadow-lg">
            <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-share-alt text-2xl"></i>
                    <h1 class="text-2xl font-bold">Zapper</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div id="connection-status" class="flex items-center">
                        <span class="connection-dot disconnected"></span>
                        <span class="text-sm">Disconnected</span>
                    </div>
                    <button id="settings-btn" class="p-2 rounded-full hover:bg-white hover:bg-opacity-20">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </header>
        <!-- Main Content -->
