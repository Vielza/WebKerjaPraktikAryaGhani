<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 - Halaman Tidak Ditemukan | Harum Motor</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            overflow-x: hidden;
        }

        /* Floating Shapes Animation */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
        .shape-2 { width: 120px; height: 120px; top: 70%; right: 10%; animation-delay: 1s; }
        .shape-3 { width: 60px; height: 60px; top: 20%; right: 20%; animation-delay: 2s; }
        .shape-4 { width: 100px; height: 100px; bottom: 20%; left: 20%; animation-delay: 3s; }
        .shape-5 { width: 70px; height: 70px; top: 50%; left: 5%; animation-delay: 4s; }
        .shape-6 { width: 90px; height: 90px; top: 30%; right: 5%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-25px) rotate(120deg); }
            66% { transform: translateY(25px) rotate(240deg); }
        }

        /* Enhanced Particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            animation: particle 10s linear infinite;
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 6s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 7s; }
        .particle:nth-child(9) { left: 15%; animation-delay: 8s; }
        .particle:nth-child(10) { left: 25%; animation-delay: 9s; }

        @keyframes particle {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }

        /* Enhanced Robot Animation */
        .robot-container {
            animation: robotBounce 3s ease-in-out infinite;
            filter: drop-shadow(0 20px 40px rgba(239, 68, 68, 0.3));
        }

        @keyframes robotBounce {
            0%, 100% { transform: translateY(0px) scale(1); }
            25% { transform: translateY(-15px) scale(1.05); }
            50% { transform: translateY(-10px) scale(1.02); }
            75% { transform: translateY(-20px) scale(1.03); }
        }

        .robot-icon {
            animation: robotWiggle 4s ease-in-out infinite;
        }

        @keyframes robotWiggle {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(5deg); }
            60% { transform: rotate(-3deg); }
            80% { transform: rotate(6deg); }
        }

        /* Enhanced Floating Gears */
        .gear {
            position: absolute;
            animation: gearFloat 6s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
        }

        .gear-1 { top: -30px; left: -40px; animation-delay: 0s; }
        .gear-2 { top: -20px; right: -50px; animation-delay: 2s; }
        .gear-3 { bottom: -30px; left: 50%; transform: translateX(-50%); animation-delay: 4s; }

        @keyframes gearFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(180deg); }
            66% { transform: translateY(15px) rotate(270deg); }
        }

        /* Enhanced Glitch Effect */
        .glitch {
            position: relative;
            text-shadow: 
                0.05em 0 0 rgba(255, 0, 0, 0.8),
                -0.05em -0.025em 0 rgba(0, 255, 0, 0.8),
                0.025em 0.05em 0 rgba(0, 0, 255, 0.8);
            animation: glitch 3s infinite;
            filter: contrast(1.2) brightness(1.1);
        }

        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch::before {
            animation: glitch-top 1.5s infinite;
            clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
            transform: translate(-0.04em, -0.03em);
            opacity: 0.8;
        }

        .glitch::after {
            animation: glitch-bottom 2s infinite;
            clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
            transform: translate(0.04em, 0.03em);
            opacity: 0.8;
        }

        @keyframes glitch {
            0%, 100% {
                text-shadow: 
                    0.05em 0 0 rgba(255, 0, 0, 0.8),
                    -0.05em -0.025em 0 rgba(0, 255, 0, 0.8),
                    0.025em 0.05em 0 rgba(0, 0, 255, 0.8);
            }
            20% {
                text-shadow: 
                    0.05em 0 0 rgba(255, 0, 0, 0.8),
                    -0.05em -0.025em 0 rgba(0, 255, 0, 0.8),
                    0.025em 0.05em 0 rgba(0, 0, 255, 0.8);
            }
            40% {
                text-shadow: 
                    -0.05em -0.025em 0 rgba(255, 0, 0, 0.8),
                    0.025em 0.025em 0 rgba(0, 255, 0, 0.8),
                    -0.05em -0.05em 0 rgba(0, 0, 255, 0.8);
            }
            60% {
                text-shadow: 
                    0.025em 0.05em 0 rgba(255, 0, 0, 0.8),
                    0.05em 0 0 rgba(0, 255, 0, 0.8),
                    0 -0.05em 0 rgba(0, 0, 255, 0.8);
            }
            80% {
                text-shadow: 
                    -0.025em -0.05em 0 rgba(255, 0, 0, 0.8),
                    -0.05em 0 0 rgba(0, 255, 0, 0.8),
                    0 0.05em 0 rgba(0, 0, 255, 0.8);
            }
        }

        @keyframes glitch-top {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-0.05em, 0.02em); }
            40% { transform: translate(-0.05em, -0.02em); }
            60% { transform: translate(0.05em, 0.02em); }
            80% { transform: translate(0.05em, -0.02em); }
        }

        @keyframes glitch-bottom {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(0.05em, 0.02em); }
            40% { transform: translate(0.05em, -0.02em); }
            60% { transform: translate(-0.05em, 0.02em); }
            80% { transform: translate(-0.05em, -0.02em); }
        }

        /* Enhanced Typewriter Effect */
        .typewriter {
            overflow: hidden;
            border-right: .2em solid #ff6b35;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .1em;
            animation: 
                typing 4s steps(40, end),
                blink-caret 1s step-end infinite;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #ff6b35; }
        }

        /* Enhanced Fade Animations */
        .fade-in-up {
            animation: fadeInUp 1.2s ease-out 0.8s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-container {
            animation: slideInDown 1.2s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-60px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Button Hover Effects */
        .btn-hover {
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover:hover::before {
            left: 100%;
        }

        /* Pulsing Background Gradient */
        .animated-bg {
            background: linear-gradient(-45deg, #1e1b4b, #581c87, #be185d, #7c2d12);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Matrix Rain Effect */
        .matrix-rain {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            z-index: 1;
        }

        .matrix-char {
            position: absolute;
            color: rgba(255,255,255,0.1);
            font-size: 14px;
            font-family: 'Courier New', monospace;
            animation: matrixFall 4s linear infinite;
        }

        @keyframes matrixFall {
            0% {
                transform: translateY(-100vh);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .glitch { font-size: 4rem; }
            .typewriter { font-size: 1.2rem; }
            .gear { display: none; }
            .shape { display: none; }
        }

        @media (max-width: 640px) {
            .glitch { font-size: 3rem; }
            .typewriter { font-size: 1rem; }
        }
    </style>
</head>

<body class="animated-bg min-h-screen relative overflow-hidden flex items-center justify-center">
    
    <!-- Matrix Rain Background -->
    <div class="matrix-rain" id="matrixRain"></div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
            <div class="shape shape-6"></div>
        </div>
    </div>

    <!-- Enhanced Particle Background -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="max-w-6xl mx-auto text-center relative z-10 px-4">
        <!-- Main Error Content -->
        <div class="mb-16 error-container">
            <!-- Enhanced Robot/Gear Icon -->
            <div class="mb-12 relative">
                <div class="inline-flex items-center justify-center w-48 h-48 bg-gradient-to-br from-red-400 via-red-500 to-red-600 rounded-full shadow-2xl mb-8 robot-container">
                    <div class="relative">
                        <i class="fas fa-robot text-white text-7xl robot-icon"></i>
                        <!-- Enhanced Robot Eyes -->
                        <div class="absolute -top-3 left-6 w-4 h-4 bg-yellow-300 rounded-full animate-pulse robot-eye"></div>
                        <div class="absolute -top-3 right-6 w-4 h-4 bg-yellow-300 rounded-full animate-pulse robot-eye" style="animation-delay: 0.5s;"></div>
                        <!-- Robot Mouth -->
                        <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-8 h-2 bg-gray-800 rounded-full"></div>
                    </div>
                </div>
                
                <!-- Enhanced Floating Gears -->
                <div class="gear gear-1">
                    <i class="fas fa-cog text-red-400 text-4xl"></i>
                </div>
                <div class="gear gear-2">
                    <i class="fas fa-cog text-orange-400 text-3xl"></i>
                </div>
                <div class="gear gear-3">
                    <i class="fas fa-tools text-yellow-400 text-2xl"></i>
                </div>
            </div>

            <!-- Enhanced Glitch Effect 404 -->
            <div class="glitch-container mb-12">
                <h1 class="glitch text-9xl md:text-[12rem] font-extrabold text-white mb-6" data-text="404">404</h1>
            </div>

            <!-- Enhanced Error Message -->
            <div class="message-container">
                <h2 class="text-5xl md:text-6xl font-bold text-white mb-8 typing-effect">
                    <span class="typewriter">Oops! Sparepart Tidak Ditemukan</span>
                </h2>
                
                <p class="text-2xl text-gray-200 mb-12 max-w-4xl mx-auto leading-relaxed fade-in-up">
                    🔧 Sepertinya sparepart yang Anda cari sedang dalam maintenance di bengkel. 
                    Mari kembali ke katalog dan temukan sparepart lainnya! 🏍️
                </p>
            </div>
        </div>

        <!-- Enhanced Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-8 justify-center mb-16">
            <a href="javascript:history.back()" 
               class="group btn-hover relative inline-flex items-center gap-4 bg-white/10 hover:bg-white/20 text-white px-10 py-5 rounded-3xl font-medium transition-all duration-300 backdrop-blur-sm border border-white/20 hover:border-white/40 hover:scale-110 transform">
                <i class="fas fa-arrow-left text-2xl group-hover:-translate-x-2 transition-transform duration-300"></i>
                <span class="text-xl">Kembali</span>
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-600/20 to-purple-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
            
            <a href="{{ url('/') }}" 
               class="group btn-hover relative inline-flex items-center gap-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-10 py-5 rounded-3xl font-bold transition-all duration-300 shadow-2xl hover:shadow-red-500/30 hover:scale-110 transform">
                <i class="fas fa-home text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
                <span class="text-xl">Kembali ke Bengkel</span>
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>

            <a href="#" onclick="showHelp()" 
               class="group btn-hover relative inline-flex items-center gap-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-10 py-5 rounded-3xl font-bold transition-all duration-300 shadow-2xl hover:shadow-purple-500/30 hover:scale-110 transform">
                <i class="fas fa-headset text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
                <span class="text-xl">Bantuan</span>
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        </div>

        <!-- Fun Fact Box Enhanced -->
        <div class="mt-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 max-w-3xl mx-auto hover:bg-white/15 transition-all duration-300 transform hover:scale-105">
            <h4 class="text-white font-bold text-2xl mb-4 flex items-center justify-center">
                <span class="text-4xl mr-3">💡</span>
                Tahukah Anda?
            </h4>
            <p class="text-gray-200 text-lg leading-relaxed">
                Error 404 pertama kali muncul di CERN pada tahun 1992 oleh Tim Berners-Lee. 
                Sekarang Anda sedang melihat error 404 yang paling keren di dunia sparepart motor! 🏍️✨
            </p>
            <div class="mt-6 text-center">
                <span class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 text-black px-6 py-2 rounded-full font-bold text-sm">
                    🎮 Tekan ↑↑↓↓←→←→BA untuk Easter Egg!
                </span>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Matrix Rain Effect
        function createMatrixRain() {
            const matrixContainer = document.getElementById('matrixRain');
            const chars = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            
            for (let i = 0; i < 50; i++) {
                const char = document.createElement('div');
                char.className = 'matrix-char';
                char.textContent = chars[Math.floor(Math.random() * chars.length)];
                char.style.left = Math.random() * 100 + '%';
                char.style.animationDelay = Math.random() * 4 + 's';
                char.style.animationDuration = (Math.random() * 3 + 2) + 's';
                matrixContainer.appendChild(char);
            }
        }

        // Enhanced Help Function
        function showHelp() {
            const helpModal = document.createElement('div');
            helpModal.className = 'fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50';
            helpModal.innerHTML = `
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 max-w-md mx-4 border border-gray-600 shadow-2xl transform scale-0 transition-transform duration-300" id="helpContent">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-headset text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-6">🆘 Bantuan 24/7</h3>
                        <div class="space-y-4 text-left">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope text-blue-400"></i>
                                <span class="text-gray-300">support@harummotor.com</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-phone text-green-400"></i>
                                <span class="text-gray-300">(021) 123-4567</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fab fa-whatsapp text-green-400"></i>
                                <span class="text-gray-300">+62 812-3456-7890</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-comment text-purple-400"></i>
                                <span class="text-gray-300">Live Chat di Website</span>
                            </div>
                        </div>
                        <button onclick="this.closest('.fixed').remove()" 
                                class="mt-8 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-3 rounded-2xl font-bold transition-all duration-300 transform hover:scale-105">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(helpModal);
            
            // Animate modal in
            setTimeout(() => {
                document.getElementById('helpContent').style.transform = 'scale(1)';
            }, 100);
            
            // Close on backdrop click
            helpModal.addEventListener('click', (e) => {
                if (e.target === helpModal) {
                    helpModal.remove();
                }
            });
        }

        // Enhanced Konami Code Easter Egg
        let konamiCode = [];
        const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];

        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            
            if (konamiCode.length > konamiSequence.length) {
                konamiCode.shift();
            }
            
            if (JSON.stringify(konamiCode) === JSON.stringify(konamiSequence)) {
                // Epic Easter Egg
                document.body.style.transform = 'rotate(720deg)';
                document.body.style.transition = 'transform 3s ease-in-out';
                
                // Confetti effect
                for (let i = 0; i < 100; i++) {
                    createConfetti();
                }
                
                setTimeout(() => {
                    alert('🎉 KONAMI CODE ACTIVATED! 🎮\n\nSelamat! Anda menemukan easter egg rahasia!\nSebagai reward, semua sparepart gratis! (just kidding 😄)');
                    document.body.style.transform = 'rotate(0deg)';
                }, 3000);
                
                konamiCode = [];
            }
        });

        // Confetti Effect
        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.style.position = 'fixed';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.top = '-10px';
            confetti.style.width = '10px';
            confetti.style.height = '10px';
            confetti.style.backgroundColor = ['#ff6b35', '#f7931e', '#ffeb3b', '#4caf50', '#2196f3', '#9c27b0'][Math.floor(Math.random() * 6)];
            confetti.style.zIndex = '1000';
            confetti.style.pointerEvents = 'none';
            confetti.style.animation = 'confettiFall 3s linear forwards';
            
            document.body.appendChild(confetti);
            
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.parentNode.removeChild(confetti);
                }
            }, 3000);
        }

        // Add confetti animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confettiFall {
                to {
                    transform: translateY(100vh) rotate(720deg);
                }
            }
        `;
        document.head.appendChild(style);

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createMatrixRain();
            
            // Add some interactive sounds (optional)
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('mouseenter', () => {
                    // You can add sound effects here if needed
                });
            });

            // Random robot movements
            const robot = document.querySelector('.robot-icon');
            setInterval(() => {
                const randomX = (Math.random() - 0.5) * 15;
                const randomY = (Math.random() - 0.5) * 15;
                robot.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${(Math.random() - 0.5) * 20}deg)`;
            }, 4000);
            
            // Add cursor trail effect
            let mouseTrail = [];
            document.addEventListener('mousemove', (e) => {
                mouseTrail.push({x: e.clientX, y: e.clientY, time: Date.now()});
                
                if (mouseTrail.length > 20) {
                    mouseTrail.shift();
                }
                
                // Create trail dots
                const dot = document.createElement('div');
                dot.style.position = 'fixed';
                dot.style.left = e.clientX + 'px';
                dot.style.top = e.clientY + 'px';
                dot.style.width = '4px';
                dot.style.height = '4px';
                dot.style.backgroundColor = 'rgba(255, 107, 53, 0.7)';
                dot.style.borderRadius = '50%';
                dot.style.pointerEvents = 'none';
                dot.style.zIndex = '9999';
                dot.style.animation = 'trailFade 1s ease-out forwards';
                
                document.body.appendChild(dot);
                
                setTimeout(() => {
                    if (dot.parentNode) {
                        dot.parentNode.removeChild(dot);
                    }
                }, 1000);
            });
        });

        // Add trail fade animation
        const trailStyle = document.createElement('style');
        trailStyle.textContent = `
            @keyframes trailFade {
                0% {
                    opacity: 1;
                    transform: scale(1);
                }
                100% {
                    opacity: 0;
                    transform: scale(0);
                }
            }
        `;
        document.head.appendChild(trailStyle);
    </script>

</body>
</html>