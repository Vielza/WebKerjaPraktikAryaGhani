@extends('layouts.auth')

@section('title', 'Login')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

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
                        <i class="fas fa-wrench text-white text-3xl"></i>
                    </div>
                </div>
                
                {{-- Brand Name --}}
                <h1 class="text-3xl font-bold text-white mb-2">Harum Motor</h1>
                <p class="text-red-100 text-sm font-medium tracking-wider">BENGKEL TERPERCAYA</p>
                
                {{-- Decorative Elements --}}
                <div class="absolute top-4 right-4 w-8 h-8 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute bottom-4 left-4 w-6 h-6 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            
            {{-- Form Section --}}
            <div class="px-8 py-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang Kembali!</h2>
                    <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
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

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
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
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Password Field - DIPERBAIKI --}}
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-red-500 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required 
                                   class="w-full px-4 py-4 pl-12 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-gray-50 hover:bg-white"
                                   placeholder="••••••••">
                            
                            <!-- Icon Lock di kiri -->
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            
                            <!-- Tombol Toggle Password di kanan -->
                            <button type="button" 
                                    id="togglePasswordBtn"
                                    onclick="togglePassword()" 
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-600 focus:outline-none transition-colors duration-200 p-1 rounded-md hover:bg-gray-100">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator (Optional) -->
                        <div class="mt-2 text-xs text-gray-500" id="passwordHint" style="display: none;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Password terlihat. Klik mata untuk menyembunyikan.
                        </div>
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 transition-colors">
                            <span class="ml-2 text-sm text-gray-600 select-none">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-red-600 hover:text-red-800 font-medium transition-colors hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" 
                            id="loginBtn"
                            class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-4 rounded-xl font-bold text-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <span id="loginBtnText">MASUK SEKARANG</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm font-medium">ATAU</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
            
                {{-- Register Link --}}
                <div class="mt-8 text-center">
                    <p class="text-gray-600 mb-4">Belum punya akun?</p>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>
                        DAFTAR SEKARANG
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Footer Info --}}
        <div class="text-center mt-8 text-gray-500">
            <p class="text-sm">
                © {{ date('Y') }} Harum Motor. Bengkel terpercaya untuk kendaraan Anda.
            </p>
        </div>
    </div>
</div>

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
    
    /* Toggle button hover effect */
    #togglePasswordBtn:hover {
        background-color: rgba(239, 68, 68, 0.1);
        transform: translateY(-50%) scale(1.1);
    }
    
    /* Smooth transitions */
    #toggleIcon {
        transition: all 0.3s ease;
    }
</style>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility Function
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        const passwordHint = document.getElementById('passwordHint');
        
        if (passwordInput.type === 'password') {
            // Show password
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
            toggleIcon.style.color = '#000000'; // Black color when showing
            passwordHint.style.display = 'block';
            
            // Add small animation
            toggleIcon.style.transform = 'scale(1.2)';
            setTimeout(() => {
                toggleIcon.style.transform = 'scale(1)';
            }, 150);
            
        } else {
            // Hide password
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
            toggleIcon.style.color = '#000000'; // Black color when hiding
            passwordHint.style.display = 'none';
            
            // Add small animation
            toggleIcon.style.transform = 'scale(1.2)';
            setTimeout(() => {
                toggleIcon.style.transform = 'scale(1)';
            }, 150);
        }
    }

    // Form submission with loading state
    document.querySelector('form').addEventListener('submit', function(e) {
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        
        // Disable button and show loading
        loginBtn.disabled = true;
        loginBtnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        
        // Optional: Add timeout to re-enable if there's an error
        setTimeout(() => {
            if (loginBtn.disabled) {
                loginBtn.disabled = false;
                loginBtnText.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>MASUK SEKARANG';
            }
        }, 10000); // 10 seconds timeout
    });

    // Add floating animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.max-w-md');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.8s ease-out';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }

        // Auto-focus on first input
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }

        // Keyboard shortcut: Enter key on email field focuses password
        document.getElementById('email').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });

        // Keyboard shortcut: Ctrl+Shift+P to toggle password visibility
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                togglePassword();
            }
        });
    });

    // Auto-hide error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const errorDiv = document.querySelector('.bg-red-50');
        if (errorDiv) {
            setTimeout(() => {
                errorDiv.style.transition = 'all 0.5s ease-out';
                errorDiv.style.opacity = '0';
                errorDiv.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    errorDiv.remove();
                }, 500);
            }, 5000);
        }
    });
</script>
@endpush