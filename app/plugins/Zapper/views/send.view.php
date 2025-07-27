<?php
get_header("Plugins/Zapper/views") ?>
<main class="min-h-screen bg-gray-50 px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-4 text-center">Send Files to PC</h1>
        <div id="status-box" class="mb-4 text-center text-sm text-gray-600">
            Device ID: <?=$device_id?>
        </div>
        <!-- File input -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-indigo-400 transition" id="mobile-drop-area">
            <i class="fas fa-paper-plane text-indigo-500 text-4xl mb-2"></i>
            <p class="text-gray-600 text-sm mb-2">Tap to select files</p>
            <input type="file" id="mobile-file-input" class="hidden" multiple>
            <button id="mobile-browse-btn" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg text-sm mt-2">
                Browse Files
            </button>
        </div>
        <!-- Upload progress list -->
        <div id="upload-list" class="mt-6 space-y-4">
            <!-- Progress template will go here -->
        </div>
    </div>
</main>
<script>
const base_path = `<?=env('BASE_URL')?>`;
document.addEventListener('DOMContentLoaded', () => {
    const statusBox = document.getElementById('status-box');
    const fileInput = document.getElementById('mobile-file-input');
    const browseBtn = document.getElementById('mobile-browse-btn');
    const dropArea = document.getElementById('mobile-drop-area');
    const uploadList = document.getElementById('upload-list');
    const connectionStatus = document.getElementById('connection-status');
    let monitorInterval, filetransferInterval;
    function isConnected() {
        const dot = connectionStatus.querySelector('.connection-dot');
        dot.classList.remove('disconnected');
        dot.classList.add('animate-pulse');
        dot.style.backgroundColor = '#F59E0B';
        connectionStatus.querySelector('span:last-child').textContent = 'Connecting...';
        setTimeout(() => {
            dot.classList.remove('animate-pulse');
            dot.classList.add('connected');
            dot.style.backgroundColor = '#55f50bff';
            connectionStatus.querySelector('span:last-child').textContent = 'Connected';
        }, 2000);
    }
    isConnected();
    const params = new URLSearchParams(window.location.search);
    const deviceId = params.get('deviceId');
    if (!deviceId) {
        statusBox.innerHTML = `<span class="text-red-500">Invalid QR Code. Missing device ID or token.</span>`;
        browseBtn.disabled = true;
        return;
    }
    // Simulate connection
    setTimeout(() => {
        statusBox.innerHTML = `<span class="text-green-600">Connected to <strong>${deviceId}</strong></span>`;
    }, 1000);
    // File selection
    browseBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => {
        handleFiles(fileInput.files);
        fileInput.value = ''; // reset
    });
    function handleFiles(files) {
        Array.from(files).forEach(file => {
            const id = 'upload-' + Math.random().toString(36).substr(2, 8);
            const container = document.createElement('div');
            container.className = 'bg-gray-100 p-3 rounded-lg shadow-inner';
            container.innerHTML = `
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700 truncate w-3/4">${file.name}</span>
                    <span class="text-xs text-gray-500" id="${id}-percent">0%</span>
                </div>
                <div class="w-full bg-gray-300 rounded-full h-2">
                    <div id="${id}-bar" class="bg-indigo-500 h-2 rounded-full" style="width: 0%"></div>
                </div>
            `;
            uploadList.appendChild(container);
            simulateUpload(file, id);
        });
    }
    // Simulate upload logic
    function simulateUpload(file, id) {
        // Pause monitoring
        if (monitorInterval) clearInterval(monitorInterval);
        const formData = new FormData();
        formData.append('file', file);
        let progress = 0;
        const updateProgress = () => {
            if (progress >= 100) {
                clearInterval(filetransferInterval);
                document.getElementById(`${id}-percent`).textContent = 'Done';
                // Send file to ./send
                $.ajax({
                    url: './send',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("File sent successfully:", response);
                    },
                    error: function(err) {
                        console.error("Error sending file:", err.responseText);
                    },
                    complete: function() {
                        // Resume monitor after sending
                        monitorMainFolder();
                    }
                });
                return;
            }
            progress += Math.random() * 10;
            progress = Math.min(100, progress);
            document.getElementById(`${id}-percent`).textContent = `${Math.floor(progress)}%`;
            document.getElementById(`${id}-bar`).style.width = `${progress}%`;
        };
        filetransferInterval = setInterval(updateProgress, 300);
    }
    let downloadedFiles = new Set(); // Track downloaded files
    function monitorMainFolder() {
        monitorInterval = setInterval(() => {
            $.get('./monitor', function(data) {
                const list = $("#upload-list");
                if (!list.length) return;
                list.empty(); // Clear the list before adding new items
                if (data && data.data) {
                    const allFiles = []
                        .concat(data.data.Images || [])
                        .concat(data.data.Videos || [])
                        .concat(data.data.Documents || [])
                        .concat(data.data.Others || []);
                    allFiles.forEach(file => {
                        const fileUrl = `${base_path}/${file.url}`;
                        const fileKey = fileUrl + file.modified; // Unique identifier
                        const fileRow = $(`
                            <div class="bg-white shadow-md p-4 rounded mb-2 flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">${file.name}</div>
                                    <div class="text-sm text-gray-500">${file.size} bytes</div>
                                    <div class="text-sm text-gray-400">${file.modified}</div>
                                </div>
                                <div class="space-x-2">
                                    <a href="${fileUrl}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded download-btn" download="${file.name}">
                                        Download
                                    </a>
                                </div>
                            </div>
                        `);
                        list.append(fileRow);
                        // Auto-download and then delete
                        if (!downloadedFiles.has(fileKey)) {
                            setTimeout(() => {
                                fileRow.find('.download-btn')[0].click();
                                downloadedFiles.add(fileKey);
                                $.post('./delete', { path: file.name }, function(response) {
                                    console.log("File deleted:", response);
                                }).fail(function(err) {
                                    console.error("Delete failed:", err.responseText);
                                });
                            }, 1000);
                        }
                    });
                }
            }).fail(function(err) {
                console.error("Monitor error:", err);
            });
        }, 3000); // Check every 3 seconds
    }
    monitorMainFolder();
});
</script>
<!-- Footer -->
<footer class="bg-white border-t border-gray-200 py-4">
    <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
        <p>Zapper &copy; 2023 | Secure file transfer between devices</p>
    </div>
</footer>
