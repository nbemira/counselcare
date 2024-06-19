<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CounselCare') }}</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .background {
            background-image: url('/images/smsm_bg.jpg');
            background-size: cover;
            background-position: center;
        }
        .eye-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
        }
        .relative {
            position: relative;
        }
        .input-container {
            position: relative;
        }
        .input-container input {
            padding-right: 2.5rem; /* Add space for the eye icon */
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100 background">
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="flex justify-center mb-6 relative">
            <div class="rounded-full bg-white bg-opacity-50">
                <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-32 h-32">
                </a>
            </div>
        </div>

        <!-- Form Container -->
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="mb-4 text-red-500 text-sm">
                {{ session('error') }}
            </div>
        @endif

            <!-- Form -->
            <form method="POST" action="{{ route('student.login') }}">
                @csrf

                <!-- IC -->
                <div class="mb-4">
                    <label for="ic" class="block text-sm font-medium text-gray-700">{{ __('IC') }}</label>
                    <div class="input-container">
                        <input id="ic" class="block mt-1 w-full px-3 py-2 border rounded-md" type="text" name="ic" value="{{ old('ic') }}" required autofocus pattern="\d{12}" maxlength="12" title="IC must be exactly 12 digits" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)" />
                        @error('ic')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <div class="input-container relative">
                        <input id="password" class="block mt-1 w-full px-3 py-2 border rounded-md" type="password" name="password" required autocomplete="current-password" />
                        <div id="togglePassword" class="eye-icon">
                            <!-- Closed Eye Icon -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                <path d="M3 15l2.5 -3.8" />
                                <path d="M21 14.976l-2.492 -3.776" />
                                <path d="M9 17l.5 -4" />
                                <path d="M15 17l-.5 -4" />
                            </svg>
                            <!-- Open Eye Icon -->
                            <svg id="eyeOpen" class="hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('student.password.request') }}" class="text-sm text-blue-700 hover:text-blue-900">{{ __('Forgot your password?') }}</a>
                    <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 transition ease-in-out duration-150">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function (e) {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye icons
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    </script>
</body>
</html>
