<?php

get_header("Plugins/Zapper/views")?>
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Connection Panel -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Device Connection</h2>
                <div id="connection-flow">
                    <!-- Step 1: Generate QR Code -->
                    <div id="step-1" class="mb-6">
                        <p class="text-gray-600 mb-4">Scan this QR code with your mobile device to establish a secure connection:</p>
                        <canvas  id="qrcode" class="flex justify-center mb-4 p-4 bg-white rounded border border-gray-200"></canvas>
                        <button id="generate-qr-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-200">
                            Generate New QR Code
                        </button>
                    </div>
                    <div id="countdown-container" style="text-align: center; margin-top: 1rem;">
                        <span id="countdown" style="font-size: 1.2rem; font-weight: bold;"></span>
                    </div>
                    <div id="message-container"></div>
                    <!-- Step 2: Connection Established (hidden initially) -->
                    <div id="step-2" class="hidden">
                        <div class="flex items-center justify-center mb-4">
                            <div class="mr-3">
                                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Connection Established</h3>
                                <p class="text-sm text-gray-500">Your devices are now paired</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Device ID:</span>
                                <span id="device-id" class="font-mono text-gray-800">N/A</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Connection Speed:</span>
                                <span id="connection-speed" class="text-gray-800">Measuring...</span>
                            </div>
                        </div>
                        <button id="disconnect-btn" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-200">
                            Disconnect
                        </button>
                    </div>
                </div>
            </div>
            <!-- File Transfer Panel -->
            <div class="lg:col-span-2 space-y-6">
                <!-- File Upload Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Send Files</h2>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-400 transition duration-200" id="drop-area">
                        <i class="fas fa-cloud-upload-alt text-4xl text-indigo-500 mb-3"></i>
                        <p class="text-gray-600 mb-2">Drag & drop files here or click to browse</p>
                        <input type="file" id="file-input" class="hidden" multiple>
                        <button id="browse-btn" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 py-2 px-4 rounded-lg transition duration-200">
                            Select Files
                        </button>
                    </div>
                </div>
                <!-- Transfer Progress Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Transfer Progress</h2>
                    <div id="transfer-list" class="space-y-4">
                        <!-- Empty state -->
                        <div id="empty-state" class="text-center py-8">
                            <i class="fas fa-exchange-alt text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No active transfers</p>
                        </div>
                        <!-- Transfer item template (hidden) -->
                        <div id="transfer-template" class="hidden">
                            <div class="file-card bg-gray-50 rounded-lg p-4 transition duration-200">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center truncate">
                                        <div class="mr-3 text-indigo-500">
                                            <i class="fas fa-file"></i>
                                        </div>
                                        <div class="truncate">
                                            <h4 class="font-medium text-gray-800 truncate">filename.ext</h4>
                                            <p class="text-xs text-gray-500">0 KB / 0 KB</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-medium text-gray-700">0%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="progress-bar bg-indigo-600 h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script>
    const base_path = `<?=env('BASE_URL')?>`;
    const app_path = `<?=env('APP_PATH')?>`;
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    function startListening() {
        let keepListening = true;
        function listen() {
            if (!keepListening) return;
            $.get(`${base_path}/zapper/api`, { action: 'check' })
                .done(function(data, textStatus, xhr) {
                    if (xhr.status === 200) {
                        console.log("Success:", data);
                        keepListening = false; // Stop listening
                    } else {
                        setTimeout(listen, 1000); // Try again after 1 second
                    }
                })
                .fail(function(xhr, status, error) {
                    console.warn("Failed:", error);
                    setTimeout(listen, 1000); // Retry on failure
                });
        }
        listen();
    }
    // Start the listener
    startListening();
</script> -->
<?php

get_footer("Plugins/Zapper/views"); ?>
