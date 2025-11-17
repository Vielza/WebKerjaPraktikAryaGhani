{{-- filepath: c:\laragon\www\wep_Kape\resources\views\auth\register.blade.php --}}
@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-white to-red-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(220,38,38,.1) 20px, rgba(220,38,38,.1) 40px);"></div>
    </div>
    
    {{-- Floating Elements --}}
    <div class="absolute top-20 left-20 w-16 h-16 bg-red-500 bg-opacity-10 rounded-full animate-bounce"></div>
    <div class="absolute bottom-20 right-20 w-20 h-20 bg-red-500 bg-opacity-10 rounded-full animate-pulse"></div>
    <div class="absolute top-1/2 right-40 w-12 h-12 bg-red-500 bg-opacity-10 rounded-full animate-ping"></div>
    
    <div class="max-w-md w-full relative z-10">
        {{-- Main Card --}}
        <div class="bg-white backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-white border-opacity-20">
            {{-- Header Section --}}
            <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 px-8 py-12 text-center relative">
                {{-- Logo --}}
                <div class="mb-6">
                    <div class="inline-block bg-white bg-opacity-20 p-4 rounded-full backdrop-blur-sm">
                        <i class="fas fa-user-plus text-white text-3xl"></i>
                    </div>
                </div>
                
                {{-- Brand Name --}}
                <h1 class="text-3xl font-bold text-white mb-2">Harum Motor</h1>
                <p class="text-red-100 text-sm font-medium tracking-wider">BERGABUNG DENGAN KAMI</p>
                
                {{-- Decorative Elements --}}
                <div class="absolute top-4 right-4 w-8 h-8 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute bottom-4 left-4 w-6 h-6 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            
            {{-- Form Section --}}
            <div class="px-8 py-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Sekarang!</h2>
                    <p class="text-gray-600">Buat akun baru untuk mengakses layanan kami</p>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 relative">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    {{-- Name Field --}}
                    <div class="relative">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-red-500 mr-2"></i>Nama Lengkap
                        </label>
                        <div class="relative">
                            <input type="text" name="name" id="name" required 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-4 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="Masukkan nama lengkap">
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div class="relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-red-500 mr-2"></i>Email Address
                        </label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-4 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="masukkan@email.com">
                            <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Phone Number Field --}}
                    <div class="relative">
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone text-red-500 mr-2"></i>Nomor Handphone
                        </label>
                        <div class="relative">
                            <input type="tel" name="phone" id="phone" required 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-4 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="Contoh: 08123456789"
                                   pattern="[0-9]{10,13}"
                                   title="Masukkan nomor HP yang valid (10-13 digit)">
                            <i class="fas fa-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format: 08xx-xxxx-xxxx</p>
                    </div>

                    {{-- Password Field --}}
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-red-500 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required 
                                   class="w-full px-4 py-4 pl-12 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="••••••••">
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="toggleIconPassword"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-red-500 mr-2"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required 
                                   class="w-full px-4 py-4 pl-12 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="••••••••">
                            <i class="fas fa-shield-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="toggleIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 mt-1">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            Saya setuju dengan <a href="#" class="text-red-600 hover:text-red-800 font-medium">Syarat & Ketentuan</a> 
                            dan <a href="#" class="text-red-600 hover:text-red-800 font-medium">Kebijakan Privasi</a>
                        </label>
                    </div>

                    {{-- Register Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-4 rounded-xl font-bold text-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2"></i>
                        DAFTAR SEKARANG
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm font-medium">ATAU</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                {{-- Social Register (Optional) --}}
                <div class="space-y-3">
                    <button class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all duration-300">
                        <i class="fab fa-google text-red-500 mr-3"></i>
                        Daftar dengan Google
                    </button>
                </div>

                {{-- Login Link --}}
                <div class="mt-8 text-center">
                    <p class="text-gray-600 mb-4">Sudah punya akun?</p>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-bold rounded-xl shadow-lg hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        MASUK SEKARANG
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Footer Info --}}
        <div class="text-center mt-8 text-gray-500">
            <p class="text-sm">
                © {{ date('Y') }} Harum Motor. Bergabunglah dengan bengkel terpercaya.
            </p>
        </div>
    </div>
</div>

{{-- Custom Scripts --}}
<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(fieldId === 'password' ? 'toggleIconPassword' : 'toggleIconConfirm');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strength = document.getElementById('password-strength');
        
        if (password.length >= 8) {
            this.classList.remove('border-red-300');
            this.classList.add('border-green-300');
        } else {
            this.classList.remove('border-green-300');
            this.classList.add('border-red-300');
        }
    });

    // Password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (password === confirmPassword && password.length > 0) {
            this.classList.remove('border-red-300');
            this.classList.add('border-green-300');
        } else {
            this.classList.remove('border-green-300');
            this.classList.add('border-red-300');
        }
    });

    // Add floating animation on page load
    window.addEventListener('load', function() {
        const card = document.querySelector('.max-w-md');
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.8s ease-out';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
</script>

{{-- Custom Styles --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Input focus glow effect */
    input:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    /* Button hover glow effect */
    button[type="submit"]:hover {
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
    }
    
    /* Password strength colors */
    .border-green-300 {
        border-color: #86efac;
    }
    
    .border-red-300 {
        border-color: #fca5a5;
    }
</style>
@endsection