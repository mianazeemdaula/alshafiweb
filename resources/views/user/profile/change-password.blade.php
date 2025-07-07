@extends('layouts.guest')

@section('content')
    @include('components.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('user.profile.show') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Change Password</h1>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Password Security Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800">Password Security Tips</h3>
                            <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                                <li>Use at least 8 characters</li>
                                <li>Include uppercase and lowercase letters</li>
                                <li>Include numbers and special characters</li>
                                <li>Avoid using personal information</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.profile.update-password') }}" method="POST" id="password-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" onclick="togglePassword('current_password')"
                                    class="absolute inset-y-0 right-0 mt-1 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="8"
                                    class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 mt-1 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex space-x-1">
                                    <div id="strength-bar-1" class="h-2 flex-1 bg-gray-200 rounded"></div>
                                    <div id="strength-bar-2" class="h-2 flex-1 bg-gray-200 rounded"></div>
                                    <div id="strength-bar-3" class="h-2 flex-1 bg-gray-200 rounded"></div>
                                    <div id="strength-bar-4" class="h-2 flex-1 bg-gray-200 rounded"></div>
                                </div>
                                <p id="strength-text" class="text-sm text-gray-500 mt-1">Password strength: Weak</p>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 mt-1 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div id="password-match" class="mt-1 text-sm"></div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('user.profile.show') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" id="submit-btn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            const checks = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                numbers: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };

            // Count passed checks
            Object.values(checks).forEach(check => {
                if (check) strength++;
            });

            return {
                strength,
                checks
            };
        }

        function updatePasswordStrength() {
            const password = document.getElementById('password').value;
            const {
                strength
            } = checkPasswordStrength(password);

            // Reset all bars
            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById(`strength-bar-${i}`);
                bar.className = 'h-2 flex-1 bg-gray-200 rounded';
            }

            // Update bars based on strength
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
            const labels = ['Very Weak', 'Weak', 'Good', 'Strong', 'Very Strong'];

            if (password.length > 0) {
                for (let i = 1; i <= Math.min(strength, 4); i++) {
                    const bar = document.getElementById(`strength-bar-${i}`);
                    bar.className = `h-2 flex-1 rounded ${colors[Math.min(strength - 1, 3)]}`;
                }
            }

            document.getElementById('strength-text').textContent =
                `Password strength: ${password.length > 0 ? labels[Math.min(strength, 4)] : 'Weak'}`;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('password-match');
            const submitBtn = document.getElementById('submit-btn');

            if (confirmation.length > 0) {
                if (password === confirmation) {
                    matchDiv.innerHTML = '<span class="text-green-600">✓ Passwords match</span>';
                    submitBtn.disabled = false;
                } else {
                    matchDiv.innerHTML = '<span class="text-red-600">✗ Passwords do not match</span>';
                    submitBtn.disabled = true;
                }
            } else {
                matchDiv.innerHTML = '';
                submitBtn.disabled = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Password strength checker
            document.getElementById('password').addEventListener('input', updatePasswordStrength);

            // Password match checker
            document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
            document.getElementById('password').addEventListener('input', checkPasswordMatch);

            // Auto-hide success messages after 5 seconds
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endsection
