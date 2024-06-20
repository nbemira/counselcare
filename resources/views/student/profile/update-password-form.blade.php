@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div id="status-message" class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6 bg-white shadow-lg sm:rounded-lg border border-gray-200">
            <div class="max-w-xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Update Password</h2>
                <form id="update-password-form" method="POST" action="{{ route('student.profile.update-password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">
                            Current Password
                        </label>
                        <input id="current_password" type="password" name="current_password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-outline">
                        @error('current_password')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            New Password
                        </label>
                        <input id="password" type="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-outline">
                        @error('password')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                            Confirm Password
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-outline">
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()" class="mr-2">
                        <label for="show_password" class="text-gray-700 text-sm font-bold">Show Password</label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function togglePasswordVisibility() {
        const passwordFields = [
            document.getElementById('current_password'),
            document.getElementById('password'),
            document.getElementById('password_confirmation')
        ];

        passwordFields.forEach(field => {
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        });
    }
</script>

<style>
    .input-container {
        position: relative;
    }
    .text-red-500 {
        color: #f56565;
    }
    .text-sm {
        font-size: 0.875rem;
    }
    .mt-2 {
        margin-top: 0.5rem;
    }
    .bg-red-500 ul {
        list-style: none;
        padding-left: 0;
    }
    .bg-red-500 li {
        margin-bottom: 0.5rem;
    }
    .bg-red-500 {
        position: relative;
        transition: all 0.3s ease;
    }
</style>
