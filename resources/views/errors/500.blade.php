<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>500 - Server Error | Harum Motor</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            overflow-x: hidden;
        }

        /* Cyberpunk Grid Background */
        .cyber-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,0,0,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,0,0,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Holographic Effect */
        .holo-text {
            font-family: 'Orbitron', monospace;
            background: linear-gradient(45deg, #ff0040, #ff8800, #ffff00, #00ff88, #0088ff, #8800ff);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: holoShift 3s ease-in-out infinite;
        }

        @keyframes holoShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Nuclear Explosion Effect */
        .nuclear-explosion {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, 
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 200, 0, 0.8) 20%,
                rgba(255, 100, 0, 0.6) 40%,
                rgba(255, 0, 0, 0.4) 60%,
                rgba(128, 0, 0, 0.2) 80%,
                transparent 100%);
            animation: explode 4s ease-out infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        @keyframes explode {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0.8;
            }
            100% {
                transform: translate(-50%, -50%) scale(3);
                opacity: 0;
            }
        }

        /* Circuit Board Animation */
        .circuit {
            position: absolute;
            width: 2px;
            height: 100px;
            background: linear-gradient(0deg, transparent, #00ffff, transparent);
            animation: circuitFlow 2s linear infinite;
        }

        .circuit.horizontal {
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff00ff, transparent);
        }

        @keyframes circuitFlow {
            0% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(0); }
        }

        /* Server Rack Animation */
        .server-rack {
            position: relative;
            animation: serverMeltdown 3s ease-in-out infinite;
        }

        @keyframes serverMeltdown {
            0%, 100% { 
                transform: translateY(0) rotate(0deg); 
                filter: hue-rotate(0deg);
            }
            25% { 
                transform: translateY(-10px) rotate(-2deg); 
                filter: hue-rotate(90deg);
            }
            50% { 
                transform: translateY(5px) rotate(1deg); 
                filter: hue-rotate(180deg);
            }
            75% { 
                transform: translateY(-15px) rotate(-1deg); 
                filter: hue-rotate(270deg);
            }
        }

        /* Virus Scanner Effect */
        .virus-scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 0, 0, 0.8), 
                rgba(255, 255, 255, 1), 
                rgba(255, 0, 0, 0.8), 
                transparent);
            animation: virusScan 3s linear infinite;
            top: 0;
        }

        @keyframes virusScan {
            0% { top: 0%; opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Terminal Glitch */
        .terminal {
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #00ff00;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            color: #00ff00;
            text-shadow: 0 0 5px #00ff00;
            animation: terminalFlicker 0.5s infinite alternate;
        }

        @keyframes terminalFlicker {
            0% { opacity: 1; }
            100% { opacity: 0.8; }
        }

        /* Radioactive Symbol */
        .radioactive {
            position: relative;
            animation: radioactiveRotate 5s linear infinite;
        }

        @keyframes radioactiveRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .radioactive::before,
        .radioactive::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 0, 0.6);
            animation: radioactivePulse 2s ease-in-out infinite;
        }

        .radioactive::before {
            animation-delay: 0s;
        }

        .radioactive::after {
            animation-delay: 1s;
        }

        @keyframes radioactivePulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* Binary Rain */
        .binary-rain {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .binary-char {
            position: absolute;
            color: rgba(255, 0, 0, 0.7);
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            animation: binaryFall 3s linear infinite;
        }

        @keyframes binaryFall {
            0% {
                transform: translateY(-100vh);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        /* Enhanced Glitch Effect */
        .mega-glitch {
            position: relative;
            font-family: 'Orbitron', monospace;
            text-shadow: 
                0.05em 0 0 rgba(255, 0, 0, 0.9),
                -0.05em -0.025em 0 rgba(0, 255, 255, 0.9),
                0.025em 0.05em 0 rgba(255, 255, 0, 0.9);
            animation: megaGlitch 1.5s infinite;
        }

        @keyframes megaGlitch {
            0%, 100% {
                transform: scale(1) skew(0deg);
                filter: hue-rotate(0deg) contrast(1);
            }
            20% {
                transform: scale(1.02) skew(2deg);
                filter: hue-rotate(90deg) contrast(1.5);
            }
            40% {
                transform: scale(0.98) skew(-1deg);
                filter: hue-rotate(180deg) contrast(0.8);
            }
            60% {
                transform: scale(1.01) skew(1deg);
                filter: hue-rotate(270deg) contrast(1.2);
            }
            80% {
                transform: scale(0.99) skew(-2deg);
                filter: hue-rotate(360deg) contrast(0.9);
            }
        }

        /* Futuristic Button */
        .cyber-button {
            position: relative;
            background: linear-gradient(45deg, transparent, rgba(255,0,100,0.1), transparent);
            border: 2px solid;
            border-image: linear-gradient(45deg, #ff0040, #00ffff, #ffff00) 1;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .cyber-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .cyber-button:hover::before {
            left: 100%;
        }

        .cyber-button:hover {
            box-shadow: 
                0 0 20px rgba(255, 0, 100, 0.5),
                inset 0 0 20px rgba(0, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* System Diagnostic */
        .diagnostic-line {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-family: 'Courier New', monospace;
        }

        .status-critical { color: #ff4444; }
        .status-warning { color: #ffaa00; }
        .status-ok { color: #44ff44; }

        /* Responsive */
        @media (max-width: 768px) {
            .mega-glitch { font-size: 3rem; }
            .holo-text { font-size: 1.2rem; }
            .nuclear-explosion { width: 200px; height: 200px; }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-900 via-red-900 to-black relative overflow-hidden">
    
    <!-- Cyberpunk Grid Background -->
    <div class="cyber-grid"></div>

    <!-- Binary Rain -->
    <div class="binary-rain" id="binaryRain"></div>

    <!-- Nuclear Explosion Effect -->
    <div class="nuclear-explosion"></div>

    <!-- Circuit Board Effects -->
    <div class="circuit" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
    <div class="circuit horizontal" style="top: 30%; right: 15%; animation-delay: 1s;"></div>
    <div class="circuit" style="bottom: 25%; left: 20%; animation-delay: 2s;"></div>
    <div class="circuit horizontal" style="bottom: 40%; right: 25%; animation-delay: 3s;"></div>

    <!-- Virus Scan Line -->
    <div class="virus-scan-line"></div>

    <div class="max-w-7xl mx-auto text-center relative z-10 px-4 py-8">
        
        <!-- Main Server Icon -->
        <div class="mb-16 relative">
            <div class="inline-flex items-center justify-center w-56 h-56 bg-gradient-to-br from-red-600 via-orange-500 to-yellow-400 rounded-full shadow-2xl mb-8 server-rack radioactive">
                <div class="relative">
                    <i class="fas fa-server text-white text-8xl"></i>
                    
                    <!-- Danger Symbols -->
                    <div class="absolute -top-4 -left-4 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-radiation text-black text-sm"></i>
                    </div>
                    <div class="absolute -top-4 -right-4 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-skull-crossbones text-white text-sm"></i>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-fire text-white text-sm"></i>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mega Glitch 500 -->
        <div class="mb-12">
            <h1 class="mega-glitch text-9xl md:text-[15rem] font-black text-red-500 mb-6" data-text="500">500</h1>
        </div>

        <!-- Holographic Title -->
        <div class="mb-12">
            <h2 class="holo-text text-5xl md:text-7xl font-bold mb-6">
                SYSTEM MELTDOWN
            </h2>
            <p class="text-2xl text-red-300 mb-8 max-w-4xl mx-auto leading-relaxed">
                🚨 CRITICAL ERROR DETECTED 🚨<br>
                Server mengalami kegagalan sistem. Protokol darurat diaktifkan!
            </p>
        </div>

        <!-- System Diagnostic Terminal -->
        <div class="terminal p-6 mb-12 max-w-4xl mx-auto text-left">
            <div class="text-center mb-4">
                <span class="text-red-400">[ SYSTEM DIAGNOSTIC REPORT ]</span>
            </div>
            <div class="diagnostic-line">
                <span>CPU Temperature:</span>
                <span class="status-critical">🔥 OVERHEATING (127°C)</span>
            </div>
            <div class="diagnostic-line">
                <span>Memory Usage:</span>
                <span class="status-critical">⚠️ CRITICAL (99.9%)</span>
            </div>
            <div class="diagnostic-line">
                <span>Database Status:</span>
                <span class="status-critical">💀 CORRUPTED</span>
            </div>
            <div class="diagnostic-line">
                <span>Security Breach:</span>
                <span class="status-critical">🚨 DETECTED</span>
            </div>
            <div class="diagnostic-line">
                <span>Backup Systems:</span>
                <span class="status-warning">⚡ OFFLINE</span>
            </div>
            <div class="diagnostic-line">
                <span>Recovery Protocol:</span>
                <span class="status-ok" id="recoveryStatus">🔧 INITIATING...</span>
            </div>
        </div>

        <!-- Emergency Actions -->
        <div class="flex flex-col lg:flex-row gap-8 justify-center mb-16">
            <button onclick="emergencyReboot()" 
                    class="cyber-button relative px-8 py-4 text-white font-bold text-xl rounded-xl">
                <i class="fas fa-power-off mr-3 text-2xl"></i>
                EMERGENCY REBOOT
            </button>
            
            <a href="{{ url('/') }}" 
               class="cyber-button relative px-8 py-4 text-white font-bold text-xl rounded-xl">
                <i class="fas fa-home mr-3 text-2xl"></i>
                EVACUATE TO SAFETY
            </a>

            <button onclick="callBackup()" 
                   class="cyber-button relative px-8 py-4 text-white font-bold text-xl rounded-xl">
                <i class="fas fa-satellite-dish mr-3 text-2xl"></i>
                CALL BACKUP TEAM
            </button>
        </div>

        <!-- System Recovery Progress -->
        <div class="mb-16 max-w-4xl mx-auto">
            <div class="terminal p-6">
                <h3 class="text-center text-xl font-bold mb-6">
                    <i class="fas fa-cogs mr-2 animate-spin"></i>
                    EMERGENCY RECOVERY PROTOCOL
                </h3>
                
                <!-- Progress Bars -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <span class="w-32 text-sm">Core Repair:</span>
                        <div class="flex-1 bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-red-500 to-orange-500 rounded-full progress-bar-1" style="width: 0%"></div>
                        </div>
                        <span class="w-12 text-sm" id="progress1">0%</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="w-32 text-sm">Data Recovery:</span>
                        <div class="flex-1 bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-500 to-green-500 rounded-full progress-bar-2" style="width: 0%"></div>
                        </div>
                        <span class="w-12 text-sm" id="progress2">0%</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="w-32 text-sm">Security Scan:</span>
                        <div class="flex-1 bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full progress-bar-3" style="width: 0%"></div>
                        </div>
                        <span class="w-12 text-sm" id="progress3">0%</span>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <div class="text-lg font-bold" id="systemStatus">ANALYZING DAMAGE...</div>
                    <div class="text-sm text-gray-400 mt-2" id="eta">ETA: Calculating...</div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto mb-16">
            <div class="cyber-button p-6 text-center h-full">
                <div class="text-4xl mb-3">🚨</div>
                <h3 class="text-white font-bold mb-2">Emergency Line</h3>
                <p class="text-gray-300 text-sm">24/7 Crisis Response</p>
                <p class="text-red-400 font-mono text-xs mt-2">911-TECH-HELP</p>
            </div>
            
            <div class="cyber-button p-6 text-center h-full">
                <div class="text-4xl mb-3">🔧</div>
                <h3 class="text-white font-bold mb-2">Tech Support</h3>
                <p class="text-gray-300 text-sm">Expert Technicians</p>
                <p class="text-blue-400 font-mono text-xs mt-2">tech@harummotor.com</p>
            </div>
            
            <div class="cyber-button p-6 text-center h-full">
                <div class="text-4xl mb-3">🛡️</div>
                <h3 class="text-white font-bold mb-2">Security Team</h3>
                <p class="text-gray-300 text-sm">Breach Response Unit</p>
                <p class="text-green-400 font-mono text-xs mt-2">security@harummotor.com</p>
            </div>
            
            <div class="cyber-button p-6 text-center h-full">
                <div class="text-4xl mb-3">📡</div>
                <h3 class="text-white font-bold mb-2">Backup Server</h3>
                <p class="text-gray-300 text-sm">Alternative Access</p>
                <p class="text-yellow-400 font-mono text-xs mt-2">backup.harummotor.com</p>
            </div>
        </div>

        <!-- Fun Terminal Message -->
        <div class="terminal p-6 max-w-2xl mx-auto">
            <div class="text-center">
                <div class="text-red-400 mb-4">[ SYSTEM MESSAGE ]</div>
                <p class="text-sm leading-relaxed">
                    Jangan panik! Meskipun server kami sedang mengalami 'hari yang buruk', 
                    tim ahli kami sedang bekerja dengan kecepatan cahaya untuk memperbaikinya. 
                    <br><br>
                    💡 <span class="text-yellow-400">Fun Fact:</span> Error 500 pertama kali terjadi pada tahun 1990 
                    dan sejak saat itu menjadi momok bagi semua developer di dunia! 
                    <br><br>
                    🎮 <span class="text-cyan-400">Easter Egg:</span> Ketik "KONAMI" untuk surprise!
                </p>
            </div>
        </div>
    </div>

    <script>
        // Binary Rain Effect
        function createBinaryRain() {
            const container = document.getElementById('binaryRain');
            const chars = ['0', '1', 'ERROR', 'FAIL', '500', 'CRASH', 'NULL'];
            
            for (let i = 0; i < 30; i++) {
                const char = document.createElement('div');
                char.className = 'binary-char';
                char.textContent = chars[Math.floor(Math.random() * chars.length)];
                char.style.left = Math.random() * 100 + '%';
                char.style.animationDelay = Math.random() * 3 + 's';
                char.style.animationDuration = (Math.random() * 2 + 2) + 's';
                container.appendChild(char);
            }
        }

        // Emergency Reboot Simulation
        function emergencyReboot() {
            const button = event.target.closest('button');
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>REBOOTING...';
            button.disabled = true;
            
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check mr-2"></i>REBOOT COMPLETE';
                button.style.background = 'linear-gradient(45deg, #00ff00, #00aa00)';
                
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }, 3000);
        }

        // Call Backup Function
        function callBackup() {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/90 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="terminal p-8 max-w-md mx-4 transform scale-0 transition-transform duration-300" id="backupModal">
                    <div class="text-center">
                        <div class="text-4xl mb-4">📡</div>
                        <h3 class="text-xl font-bold mb-4">BACKUP TEAM CONTACTED</h3>
                        <div class="space-y-2 text-sm">
                            <div>🔴 Alpha Team: DISPATCHED</div>
                            <div>🟡 Bravo Team: ON STANDBY</div>
                            <div>🟢 Charlie Team: READY</div>
                        </div>
                        <div class="mt-6">
                            <button onclick="this.closest('.fixed').remove()" 
                                    class="cyber-button px-6 py-2 text-white">
                                UNDERSTOOD
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            setTimeout(() => {
                document.getElementById('backupModal').style.transform = 'scale(1)';
            }, 100);
        }

        // Progress Simulation
        let progress = [0, 0, 0];
        const progressBars = ['.progress-bar-1', '.progress-bar-2', '.progress-bar-3'];
        const progressTexts = ['#progress1', '#progress2', '#progress3'];
        
        function updateProgress() {
            const statusMessages = [
                'ANALYZING DAMAGE...',
                'IDENTIFYING CRITICAL ERRORS...',
                'APPLYING EMERGENCY PATCHES...',
                'STABILIZING CORE SYSTEMS...',
                'RUNNING DIAGNOSTIC TESTS...',
                'VERIFYING INTEGRITY...',
                'SYSTEM RECOVERY COMPLETE!'
            ];
            
            progress.forEach((val, index) => {
                if (progress[index] < 100) {
                    progress[index] += Math.random() * 3;
                    if (progress[index] > 100) progress[index] = 100;
                    
                    document.querySelector(progressBars[index]).style.width = progress[index] + '%';
                    document.querySelector(progressTexts[index]).textContent = Math.floor(progress[index]) + '%';
                }
            });
            
            const avgProgress = progress.reduce((a, b) => a + b) / 3;
            const statusIndex = Math.floor(avgProgress / 14.3);
            
            document.getElementById('systemStatus').textContent = statusMessages[Math.min(statusIndex, statusMessages.length - 1)];
            
            if (avgProgress < 100) {
                const eta = Math.ceil((100 - avgProgress) / 2);
                document.getElementById('eta').textContent = `ETA: ${eta} seconds`;
            } else {
                document.getElementById('eta').textContent = 'RECOVERY COMPLETE!';
                document.getElementById('recoveryStatus').innerHTML = '<span class="status-ok">✅ ONLINE</span>';
                
                // Show success message
                setTimeout(() => {
                    const successModal = document.createElement('div');
                    successModal.className = 'fixed inset-0 bg-green-900/80 flex items-center justify-center z-50';
                    successModal.innerHTML = `
                        <div class="terminal p-8 max-w-md mx-4 border-green-500">
                            <div class="text-center">
                                <div class="text-6xl mb-4">✅</div>
                                <h3 class="text-2xl font-bold text-green-400 mb-4">SYSTEM RESTORED!</h3>
                                <p class="text-sm mb-6">Server telah berhasil dipulihkan dan siap beroperasi kembali.</p>
                                <button onclick="window.location.reload()" 
                                        class="cyber-button px-6 py-3 text-white bg-green-600">
                                    REFRESH PAGE
                                </button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(successModal);
                }, 2000);
            }
        }

        // Easter Egg - Konami Code
        let konami = '';
        document.addEventListener('keydown', (e) => {
            konami += e.key.toLowerCase();
            if (konami.includes('konami')) {
                document.body.style.filter = 'invert(1) hue-rotate(180deg)';
                document.body.style.transition = 'filter 2s';
                
                setTimeout(() => {
                    alert('🎮 KONAMI CODE ACTIVATED!\n\nMatrix mode enabled! You are now in the alternate dimension where servers never crash! 🌈');
                    document.body.style.filter = 'none';
                }, 2000);
                
                konami = '';
            }
            
            if (konami.length > 10) konami = konami.slice(-10);
        });

        // Sound Effects Simulation
        function playSystemSound(type) {
            // In a real application, you would play actual sound files
            console.log(`Playing ${type} sound effect`);
        }

        // Initialize Everything
        document.addEventListener('DOMContentLoaded', function() {
            createBinaryRain();
            setInterval(updateProgress, 500);
            
            // Random system events
            setInterval(() => {
                const events = ['MEMORY LEAK DETECTED', 'FIREWALL BREACH', 'COOLING SYSTEM ALERT', 'POWER FLUCTUATION'];
                const randomEvent = events[Math.floor(Math.random() * events.length)];
                console.log(`[SYSTEM EVENT] ${randomEvent}`);
            }, 5000);
            
            // Add some dramatic flair
            setTimeout(() => {
                playSystemSound('emergency_alert');
            }, 1000);
        });
    </script>

</body>
</html>