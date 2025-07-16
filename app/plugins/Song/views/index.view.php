<?php get_header("Plugins/song/views")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akpan MVC - Song List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #121212;
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Animation for play button */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .playing {
            animation: pulse 2s infinite;
        }
        
        /* Gradient background */
        .gradient-bg {
            background: linear-gradient(180deg, rgba(18,18,18,0.8) 0%, rgba(18,18,18,1) 100%);
        }
    </style>
</head>
<body class="bg-black text-white font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col w-64 bg-black p-6 space-y-6 border-r border-gray-800">
            <div class="flex items-center space-x-2">
                <i class="fab fa-spotify text-3xl text-green-500"></i>
                <span class="text-xl font-bold">Akpan MVC</span>
            </div>
            
            <div class="space-y-4">
                <div class="text-gray-400 font-medium">MENU</div>
                <ul class="space-y-3">
                    <li class="flex items-center space-x-3 text-white hover:text-green-500 cursor-pointer">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </li>
                    <li class="flex items-center space-x-3 text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </li>
                    <li class="flex items-center space-x-3 text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-book"></i>
                        <span>Your Library</span>
                    </li>
                </ul>
            </div>
            
            <div class="space-y-4">
                <div class="text-gray-400 font-medium">PLAYLISTS</div>
                <ul class="space-y-3">
                    <li class="flex items-center space-x-3 text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-plus-circle"></i>
                        <span>Create Playlist</span>
                    </li>
                    <li class="flex items-center space-x-3 text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-heart"></i>
                        <span>Liked Songs</span>
                    </li>
                </ul>
            </div>
            
            <div class="border-t border-gray-800 pt-4">
                <div class="text-gray-400 text-sm">
                    <div class="hover:text-white cursor-pointer">Legal</div>
                    <div class="hover:text-white cursor-pointer">Privacy Center</div>
                    <div class="hover:text-white cursor-pointer">Cookies</div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="gradient-bg p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button class="md:hidden text-gray-400 hover:text-white">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <div class="relative">
                        <input type="text" placeholder="Search for songs, artists..." 
                               class="bg-white bg-opacity-10 rounded-full py-2 px-4 text-white placeholder-gray-400 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fas fa-search absolute right-3 top-2.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block">
                        <button class="bg-white text-black rounded-full px-6 py-1.5 font-medium hover:bg-opacity-90 transition">
                            Upgrade
                        </button>
                    </div>
                    <div class="flex items-center space-x-2 bg-black bg-opacity-40 rounded-full p-1 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center">
                            <span class="font-bold">U</span>
                        </div>
                        <span class="hidden md:inline pr-2">User</span>
                    </div>
                </div>
            </header>
            
            <!-- Playlist Header -->
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-b from-purple-900 to-black opacity-60"></div>
                <div class="relative z-10 p-6 md:p-8 flex flex-col md:flex-row items-start md:items-end space-y-4 md:space-y-0 md:space-x-6">
                    <div class="w-48 h-48 md:w-56 md:h-56 shadow-2xl flex-shrink-0">
                        <img src="https://i.scdn.co/image/ab67616d00001e02ff9ca10b55ce82ae553c8228" alt="Album Cover" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs uppercase font-bold">Playlist</span>
                        <h1 class="text-4xl md:text-5xl font-bold mt-2 mb-4">Today's Top Hits</h1>
                        <p class="text-gray-400 text-sm md:text-base">The most popular songs right now. Updates daily.</p>
                        <div class="flex items-center mt-4 space-x-2 text-sm">
                            <span class="font-bold">Spotify</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-400">1,234,567 likes</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-400">50 songs, 2 hr 45 min</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controls -->
            <div class="gradient-bg px-6 py-4 flex items-center space-x-6">
                <button class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-400 transition transform hover:scale-105">
                    <i class="fas fa-play text-xl"></i>
                </button>
                <button class="text-gray-400 hover:text-white">
                    <i class="far fa-heart text-2xl"></i>
                </button>
                <button class="text-gray-400 hover:text-white">
                    <i class="fas fa-ellipsis-h text-2xl"></i>
                </button>
            </div>
            
            <!-- Song List -->
            <div class="flex-1 overflow-y-auto px-6 pb-32">
                <div class="grid grid-cols-12 border-b border-gray-800 py-2 px-4 text-gray-400 text-sm">
                    <div class="col-span-1">#</div>
                    <div class="col-span-5 md:col-span-6">TITLE</div>
                    <div class="col-span-4 md:col-span-3">ALBUM</div>
                    <div class="col-span-2 md:col-span-1 text-right">DURATION</div>
                </div>
                
                <div id="song-list" class="divide-y divide-gray-800">
                    <!-- Songs will be added here by JavaScript -->
                </div>
            </div>
            
            <!-- Player Bar -->
            <div class="fixed bottom-0 left-0 right-0 bg-gray-900 border-t border-gray-800 p-4" id="player-bar">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 w-1/4">
                        <img src="https://i.scdn.co/image/ab67616d00004851ff9ca10b55ce82ae553c8228" alt="Now Playing" class="w-14 h-14">
                        <div class="player-info">
                            <div class="font-medium">Blinding Lights</div>
                            <div class="text-gray-400 text-sm">The Weeknd</div>
                        </div>
                        <button class="text-gray-400 hover:text-white">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    
                    <div class="flex flex-col items-center w-2/4">
                        <div class="flex items-center space-x-6 mb-2">
                            <button class="text-gray-400 hover:text-white">
                                <i class="fas fa-random"></i>
                            </button>
                            <button class="text-gray-400 hover:text-white prev-btn">
                                <i class="fas fa-step-backward"></i>
                            </button>
                            <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:scale-105 transition play-pause-btn">
                                <i class="fas fa-pause text-black text-sm"></i>
                            </button>
                            <button class="text-gray-400 hover:text-white next-btn">
                                <i class="fas fa-step-forward"></i>
                            </button>
                            <button class="text-gray-400 hover:text-white">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                        <div class="w-full flex items-center space-x-2">
                            <span class="text-xs text-gray-400">1:23</span>
                            <div class="flex-1 h-1 bg-gray-600 rounded-full">
                                <div class="h-full bg-gray-400 rounded-full w-1/3 relative">
                                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 w-3 h-3 bg-white rounded-full opacity-0 hover:opacity-100"></div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">3:45</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 w-1/4">
                        <button class="text-gray-400 hover:text-white">
                            <i class="fas fa-list"></i>
                        </button>
                        <button class="text-gray-400 hover:text-white">
                            <i class="fas fa-laptop"></i>
                        </button>
                        <button class="text-gray-400 hover:text-white">
                            <i class="fas fa-volume-up"></i>
                        </button>
                        <div class="w-20 h-1 bg-gray-600 rounded-full">
                            <div class="h-full bg-gray-400 rounded-full w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Current state
        let currentSongIndex = 0;
        let isPlaying = false;
        let progressInterval;
        let currentTime = 0;
        let duration = 0;
        
        // Sample song data
        const songs = [
            { id: 1, title: "Blinding Lights", artist: "The Weeknd", album: "After Hours", duration: "3:20", cover: "https://i.scdn.co/image/ab67616d00004851ff9ca10b55ce82ae553c8228", playing: true },
            { id: 2, title: "Save Your Tears", artist: "The Weeknd", album: "After Hours", duration: "3:35", cover: "https://i.scdn.co/image/ab67616d00004851ff9ca10b55ce82ae553c8228" },
            { id: 3, title: "Stay", artist: "The Kid LAROI, Justin Bieber", album: "F*CK LOVE 3: OVER YOU", duration: "2:21", cover: "https://i.scdn.co/image/ab67616d00004851c96f7c7b077c224975b7c135" },
            { id: 4, title: "good 4 u", artist: "Olivia Rodrigo", album: "SOUR", duration: "2:58", cover: "https://i.scdn.co/image/ab67616d000048515d0dfa1feb1e8d2c9f7b1e5e" },
            { id: 5, title: "Levitating", artist: "Dua Lipa", album: "Future Nostalgia", duration: "3:23", cover: "https://i.scdn.co/image/ab67616d00004851025b1a6a71faf3a923d9a837" },
            { id: 6, title: "Montero", artist: "Lil Nas X", album: "MONTERO", duration: "2:17", cover: "https://i.scdn.co/image/ab67616d00004851a6f89fa0f6669b338509d13b" },
            { id: 7, title: "Peaches", artist: "Justin Bieber", album: "Justice", duration: "3:18", cover: "https://i.scdn.co/image/ab67616d00004851e6f407c7f3a0ec98845e4431" },
            { id: 8, title: "Kiss Me More", artist: "Doja Cat ft. SZA", album: "Planet Her", duration: "3:28", cover: "https://i.scdn.co/image/ab67616d00004851a935e8e7b5a8d2a8a9b5541e" },
            { id: 9, title: "Butter", artist: "BTS", album: "Butter", duration: "2:42", cover: "https://i.scdn.co/image/ab67616d00004851d5f373d7beb1a9e3b1e3a5e6" },
            { id: 10, title: "Deja Vu", artist: "Olivia Rodrigo", album: "SOUR", duration: "3:35", cover: "https://i.scdn.co/image/ab67616d000048515d0dfa1feb1e8d2c9f7b1e5e" }
        ];

        // Player controls functions
        function parseTime(timeStr) {
            const [minutes, seconds] = timeStr.split(':').map(Number);
            return minutes * 60 + seconds;
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        function updateProgress() {
            if (currentTime < duration) {
                currentTime += 1;
                const progressPercent = (currentTime / duration) * 100;
                
                // Update progress bar
                const progressBar = document.querySelector('#player-bar .bg-gray-400');
                progressBar.style.width = `${progressPercent}%`;
                
                // Update current time display
                const timeDisplay = document.querySelector('#player-bar .text-xs:first-child');
                timeDisplay.textContent = formatTime(currentTime);
            } else {
                playNextSong();
            }
        }

        function playSong(index) {
            // Clear any existing interval
            clearInterval(progressInterval);
            
            // Update current song index
            currentSongIndex = index;
            const song = songs[index];
            
            // Parse duration and reset current time
            duration = parseTime(song.duration);
            currentTime = 0;
            
            // Update player bar
            const playerBar = document.getElementById('player-bar');
            playerBar.querySelector('img').src = song.cover;
            playerBar.querySelector('.player-info div:first-child').textContent = song.title;
            playerBar.querySelector('.player-info div:last-child').textContent = song.artist;
            
            // Reset progress bar and timer
            const progressBar = playerBar.querySelector('.bg-gray-400');
            progressBar.style.width = '0%';
            playerBar.querySelector('.text-xs:first-child').textContent = '0:00';
            playerBar.querySelector('.text-xs:last-child').textContent = song.duration;
            
            // Update play/pause button
            const playPauseBtn = playerBar.querySelector('.play-pause-btn i');
            playPauseBtn.classList.remove('fa-play');
            playPauseBtn.classList.add('fa-pause');
            isPlaying = true;
            
            // Update song list
            document.querySelectorAll('#song-list div').forEach(el => el.classList.remove('text-green-500'));
            document.querySelectorAll('#song-list i').forEach(el => {
                el.classList.remove('fa-volume-up', 'playing');
                el.classList.add('fa-play');
            });
            
            const songElement = document.querySelector(`#song-list div:nth-child(${index + 1})`);
            songElement.classList.add('text-green-500');
            const icon = songElement.querySelector('i');
            icon.classList.remove('fa-play');
            icon.classList.add('fa-volume-up', 'playing');
        }
        
        function pauseSong() {
            const playerBar = document.getElementById('player-bar');
            const playPauseBtn = playerBar.querySelector('.play-pause-btn i');
            playPauseBtn.classList.remove('fa-pause');
            playPauseBtn.classList.add('fa-play');
            isPlaying = false;
            
            const songElement = document.querySelector(`#song-list div:nth-child(${currentSongIndex + 1})`);
            const icon = songElement.querySelector('i');
            icon.classList.remove('playing');
            
            // Clear progress interval
            clearInterval(progressInterval);
        }
        
        function togglePlayPause() {
            if (isPlaying) {
                pauseSong();
            } else {
                playSong(currentSongIndex);
                // Start progress interval (1000ms = 1 second)
                progressInterval = setInterval(updateProgress, 1000);
            }
        }
        
        function playNextSong() {
            const nextIndex = (currentSongIndex + 1) % songs.length;
            playSong(nextIndex);
            if (isPlaying) {
                progressInterval = setInterval(updateProgress, 1000);
            }
        }
        
        function playPrevSong() {
            const prevIndex = (currentSongIndex - 1 + songs.length) % songs.length;
            playSong(prevIndex);
            if (isPlaying) {
                progressInterval = setInterval(updateProgress, 1000);
            }
        }
        
        // Render songs
        const songList = document.getElementById('song-list');
        
        songs.forEach(song => {
            const songElement = document.createElement('div');
            songElement.className = `grid grid-cols-12 items-center py-3 px-4 hover:bg-gray-800 rounded-md group ${song.playing ? 'text-green-500' : 'text-gray-400 hover:text-white'}`;
            songElement.innerHTML = `
                <div class="col-span-1 flex items-center">
                    ${song.playing ? '<i class="fas fa-volume-up playing"></i>' : `<span class="group-hover:hidden">${song.id}</span><i class="fas fa-play hidden group-hover:block"></i>`}
                </div>
                <div class="col-span-5 md:col-span-6 flex items-center space-x-4">
                    <img src="${song.cover}" alt="${song.title}" class="w-10 h-10">
                    <div>
                        <div class="font-medium ${song.playing ? 'text-green-500' : 'text-white'}">${song.title}</div>
                        <div class="text-sm">${song.artist}</div>
                    </div>
                </div>
                <div class="col-span-4 md:col-span-3 text-sm truncate">${song.album}</div>
                <div class="col-span-2 md:col-span-1 text-right text-sm">${song.duration}</div>
            `;
            songList.appendChild(songElement);
            
            // Add click event to play song
            songElement.addEventListener('click', () => {
                playSong(song.id - 1); // Using id-1 as index
            });
        });

        // Make player bar elements accessible
        document.querySelectorAll('.player-bar').forEach(el => {
            el.classList.add('player-bar');
        });

        // Add event listeners for player controls
        document.querySelector('.play-pause-btn').addEventListener('click', togglePlayPause);
        document.querySelector('.next-btn').addEventListener('click', playNextSong);
        document.querySelector('.prev-btn').addEventListener('click', playPrevSong);
        
        // Mobile menu toggle
        document.querySelector('.md\\:hidden button').addEventListener('click', () => {
            document.querySelector('.hidden.md\\:flex').classList.toggle('hidden');
        });
        
        // Play first song by default
        playSong(0);
        pauseSong();
    </script>
</body>
</html>
<?php get_footer("Plugins/song/views")?>