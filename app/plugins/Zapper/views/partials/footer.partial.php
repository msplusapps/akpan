<footer class="bg-white border-t border-gray-200 py-4">
    <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
        <p>Zapper &copy; 2023 | Secure file transfer between devices</p>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM Elements
        const qrcodeElement = document.getElementById('qrcode');
        const generateQRBtn = document.getElementById('generate-qr-btn');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const connectionStatus = document.getElementById('connection-status');
        const deviceIdElement = document.getElementById('device-id');
        const connectionSpeedElement = document.getElementById('connection-speed');
        const disconnectBtn = document.getElementById('disconnect-btn');
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const browseBtn = document.getElementById('browse-btn');
        const transferList = document.getElementById('transfer-list');
        const emptyState = document.getElementById('empty-state');
        const transferTemplate = document.getElementById('transfer-template');
        // State
        let isConnected = false;
        let currentTransfers = [];
        let deviceId;
        function generateDeviceId() {
            deviceId = 'zapper-' + Math.random().toString(16).substr(2, 4).toUpperCase();
            return deviceId;
        }
        function generateQRCode() {
            deviceId = generateDeviceId();
            const timestamp = new Date().getTime();
            const connectionData = {
                deviceId,
                timestamp
            };
            const baseUrl = `${base_path}/zapper/send`;
            const urlWithParams = `${baseUrl}?deviceId=${deviceId}`;
            QRCode.toCanvas(qrcodeElement, urlWithParams, {
                width: 200,
                margin: 2,
                color: {
                    dark: '#000000',
                    light: '#ffffff'
                }
            }, function(error) {
                if (error) console.error(error);
            });
            setTimeout(() => {
                $.ajax({
                    url: `./zapper/api?deviceId=${deviceId}`,
                    method: 'GET',
                    success: function(response) {
                        startListening(deviceId)
                    },
                    error: function(err) {
                        console.error("Failed to add device ID:", err);
                    }
                });
            }, 2000);
            return connectionData;
        }
        function startListening(deviceId) {
            let keepListening = true;
            let attempts = 0;
            const maxAttempts = 500;
            const countdownElement = document.getElementById("countdown");
            let remainingSeconds = maxAttempts;
            // Start countdown timer in UI
            const timerInterval = setInterval(() => {
                if (remainingSeconds <= 0) {
                    clearInterval(timerInterval);
                    return;
                }
                countdownElement.textContent = `⏳ Waiting... ${remainingSeconds} seconds remaining`;
                remainingSeconds--;
            }, 1000);
            function listen() {
                if (!keepListening || attempts >= maxAttempts) {
                    clearInterval(timerInterval);
                    showTimeoutMessage();
                    return;
                }
                $.get(`./zapper/handshake`, { action: 'check' })
                    .done(function (data, textStatus, xhr) {
                        if (xhr.status === 200) {
                            keepListening = false;
                            clearInterval(timerInterval);
                            countdownElement.textContent = "";
                            console.clear();
                            simulateConnection(deviceId);
                        } else {
                            attempts++;
                            setTimeout(listen, 1000);
                        }
                    })
                    .fail(function (xhr, status, error) {
                        attempts++;
                        setTimeout(listen, 1000);
                    });
            }
            listen();
        }
        function showTimeoutMessage() {
            const container = document.getElementById("message-container") || document.body;
            const message = document.createElement("div");
            message.innerText = "⏰ Session timed out. Refreshing...";
            message.style.color = "#fff";
            message.style.background = "#e74c3c";
            message.style.padding = "1rem";
            message.style.fontSize = "1.2rem";
            message.style.textAlign = "center";
            message.style.position = "fixed";
            message.style.top = 0;
            message.style.left = 0;
            message.style.right = 0;
            message.style.zIndex = 9999;
            container.appendChild(message);
            setTimeout(() => {
                // location.reload();
            }, 3000); // Wait 3 seconds before refreshing
        }
        function simulateConnection(connectionData) {
            return new Promise((resolve) => {
                const dot = connectionStatus.querySelector('.connection-dot');
                dot.classList.remove('disconnected');
                dot.classList.add('animate-pulse');
                dot.style.backgroundColor = '#F59E0B';
                connectionStatus.querySelector('span:last-child').textContent = 'Connecting...';
                setTimeout(() => {
                    isConnected = true;
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    deviceIdElement.textContent = deviceId;
                    dot.classList.remove('animate-pulse');
                    dot.classList.add('connected');
                    dot.style.backgroundColor = '#0bf574ff';
                    connectionStatus.querySelector('span:last-child').textContent = 'Connected';
                    simulateSpeedTest();
                    resolve();
                }, 2000);
            });
        }
        function simulateSpeedTest() {
            let speed = 5 + Math.random() * 45;
            let interval = setInterval(() => {
                if (!isConnected) {
                    clearInterval(interval);
                    return;
                }
                speed = Math.max(1, speed + (Math.random() * 4 - 2));
                connectionSpeedElement.textContent = speed.toFixed(1) + ' Mbps';
            }, 3000);
        }
        function handleFiles(files) {
            if (!isConnected) {
                alert('Please connect a device first');
                return;
            }
            if (files.length === 0) return;
            if (emptyState.style.display !== 'none') {
                emptyState.style.display = 'none';
            }
            Array.from(files).forEach(file => {
                addTransferItem(file);
                simulateFileTransfer(file);
            });
        }
        function addTransferItem(file) {
            const transferItem = transferTemplate.cloneNode(true);
            transferItem.id = 'transfer-' + file.name.replace(/\s+/g, '-');
            transferItem.classList.remove('hidden');
            const fileName = transferItem.querySelector('h4');
            const fileSize = transferItem.querySelector('p');
            const progressPercent = transferItem.querySelector('span:last-child');
            const progressBar = transferItem.querySelector('.progress-bar');
            fileName.textContent = file.name;
            fileSize.textContent = `0 KB / ${formatFileSize(file.size)}`;
            progressPercent.textContent = '0%';
            progressBar.style.width = '0%';
            const fileIcon = transferItem.querySelector('.fa-file');
            const fileType = getFileType(file.name);
            if (fileType === 'image') fileIcon.classList.replace('fa-file', 'fa-file-image');
            else if (fileType === 'pdf') fileIcon.classList.replace('fa-file', 'fa-file-pdf');
            else if (fileType === 'video') fileIcon.classList.replace('fa-file', 'fa-file-video');
            else if (fileType === 'audio') fileIcon.classList.replace('fa-file', 'fa-file-audio');
            else if (fileType === 'archive') fileIcon.classList.replace('fa-file', 'fa-file-archive');
            else if (fileType === 'code') fileIcon.classList.replace('fa-file', 'fa-file-code');
            transferList.appendChild(transferItem);
            currentTransfers.push({
                id: transferItem.id,
                file: file,
                element: transferItem,
                progress: 0
            });
        }
        function simulateFileTransfer(file) {
            const transferId = 'transfer-' + file.name.replace(/\s+/g, '-');
            const transfer = currentTransfers.find(t => t.id === transferId);
            if (!transfer) return;
            const totalSize = file.size;
            let transferred = 0;
            const chunkSize = Math.max(1024 * 10, Math.floor(totalSize / 100));
            const interval = setInterval(() => {
                if (transferred >= totalSize || !isConnected) {
                    clearInterval(interval);
                    if (transferred >= totalSize) {
                        transfer.progress = 100;
                        updateTransferProgress(transfer);
                        // ✅ Change icon to success
                        const icon = transfer.element.querySelector('i');
                        icon.classList.remove(
                            'fa-file', 'fa-file-image', 'fa-file-pdf',
                            'fa-file-video', 'fa-file-audio', 'fa-file-archive', 'fa-file-code'
                        );
                        icon.classList.add('fa-check-circle', 'text-green-500');
                        // ✅ Real file upload using FormData
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('deviceId', deviceId); // Make sure this is defined globally
                        $.ajax({
                            url: './zapper/files',
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log("✅ File uploaded successfully:", response);
                            },
                            error: function(xhr, status, error) {
                                console.error("❌ Upload failed:", status, error);
                            }
                        });
                    }
                    return;
                }
                const speedFactor = 0.5 + Math.random();
                transferred = Math.min(totalSize, transferred + Math.floor(chunkSize * speedFactor));
                transfer.progress = (transferred / totalSize) * 100;
                updateTransferProgress(transfer);
            }, 100);
        }
        function updateTransferProgress(transfer) {
            const progressPercent = transfer.element.querySelector('span:last-child');
            const progressBar = transfer.element.querySelector('.progress-bar');
            const fileSize = transfer.element.querySelector('p');
            progressPercent.textContent = Math.floor(transfer.progress) + '%';
            progressBar.style.width = transfer.progress + '%';
            const transferredSize = Math.floor((transfer.file.size * transfer.progress) / 100);
            fileSize.textContent = `${formatFileSize(transferredSize)} / ${formatFileSize(transfer.file.size)}`;
        }
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        function getFileType(filename) {
            const extension = filename.split('.').pop().toLowerCase();
            const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            const videoTypes = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
            const audioTypes = ['mp3', 'wav', 'ogg', 'flac'];
            const archiveTypes = ['zip', 'rar', '7z', 'tar', 'gz'];
            const codeTypes = ['html', 'css', 'js', 'json', 'php', 'py', 'java', 'cpp'];
            if (imageTypes.includes(extension)) return 'image';
            if (extension === 'pdf') return 'pdf';
            if (videoTypes.includes(extension)) return 'video';
            if (audioTypes.includes(extension)) return 'audio';
            if (archiveTypes.includes(extension)) return 'archive';
            if (codeTypes.includes(extension)) return 'code';
            return 'other';
        }
        generateQRBtn.addEventListener('click', function() {
            generateQRCode();
        });
        disconnectBtn.addEventListener('click', function() {
            isConnected = false;
            step1.classList.remove('hidden');
            step2.classList.add('hidden');
            const dot = connectionStatus.querySelector('.connection-dot');
            dot.classList.remove('connected', 'animate-pulse');
            dot.classList.add('disconnected');
            connectionStatus.querySelector('span:last-child').textContent = 'Disconnected';
            currentTransfers.forEach(transfer => {
                const icon = transfer.element.querySelector('i');
                icon.classList.remove('fa-check-circle', 'text-green-500');
                icon.classList.add('fa-times-circle', 'text-red-500');
            });
            currentTransfers = [];
        });
        dropArea.addEventListener('click', function() {
            fileInput.click();
        });
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
            this.value = '';
        });
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        function highlight() {
            dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
        }
        function unhighlight() {
            dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
        }
        dropArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        });
        generateQRCode();
    });
</script>
