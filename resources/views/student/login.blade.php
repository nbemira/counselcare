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
                    <input id="ic" class="block mt-1 w-full px-3 py-2 border rounded-md" type="text" name="ic" value="{{ old('ic') }}" required autofocus pattern="[0-9]+" />
                    @error('ic')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password" class="block mt-1 w-full px-3 py-2 border rounded-md" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
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
                    <a href="{{ route('student.password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Forgot your password?') }}</a>
                    <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 transition ease-in-out duration-150">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
