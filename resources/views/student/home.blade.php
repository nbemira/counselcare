@extends('layouts.app')

@push('styles')
<!-- Include Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@600&display=swap" rel="stylesheet">
<link href="https://fonts.bunny.net/css?family=andada-pro:600&display=swap" rel="stylesheet">
@endpush

@section('content')
    <div class="w-full mx-auto my-8 bg-white min-h-screen p-8">
        @if (session('status'))
            <div id="status-message" class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex flex-col items-center text-center w-full">
            <h1 class="mb-8" style="font-family: 'Andada Pro', serif; font-weight: 600; color: #1e3a8a; font-size: 2.625rem;">
                CounselCare Mental Health Assessment
            </h1>

            <!-- Logo Section -->
            <div class="mb-8">
                <img src="{{ asset('images/logosmsm.png') }}" alt="Logo" class="w-36 h-36 mx-auto">
            </div>

            <!-- Text Section -->
            <div class="max-w-3xl text-left mb-8 w-full">
                <p class="text-lg text-gray-700 leading-relaxed mb-4 text-justify">
                    CounselCare utilizes the Depression, Anxiety and Stress Scale (DASS-21) to conduct the Mental Health Assessment.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed text-justify">
                    DASS-21 is a short standardized assessment consisting of 21 items that will help you determine your risk factors for depression, anxiety, and stress. While the assessment is an indicator of risk factors, it is not intended to diagnose any conditions.
                </p>
            </div>
            
            <!-- Assessment Details and Start Button Section -->
            <div class="w-full flex flex-col items-center space-y-4">
                <div class="flex items-center mb-4 justify-center space-x-4">
                    <div class="text-center">
                        <div class="text-xl font-bold text-blue-800">21</div>
                        <div class="text-sm text-blue-800">Questions</div>
                    </div>
                    <!-- Divider -->
                    <div class="border-r-2 border-blue-500 h-10 mx-4"></div>
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mx-auto text-blue-800">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 12l2 2l4 -4" />
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                        </svg>
                        <div class="text-sm text-blue-800">Multiple choice</div>
                    </div>
                </div>

                <!-- Start Assessment Button -->
                <div class="text-center">
                    <button type="button" onclick="window.location.href='{{ route('student.assessment') }}'" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-8 rounded-full transition-transform transform hover:scale-105 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-400 focus:ring-opacity-75">
                        Start Assessment
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
