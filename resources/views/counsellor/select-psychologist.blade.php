@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg shadow-md p-6">
            <div class="border-b pb-2 mb-2 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Select Psychologist for {{ $student_name }}</h2>
            </div>
            <div class="p-2">
                @if(Session::has('message'))
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow-sm">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('counsellor.generatePdf') }}">
                @csrf
                <input type="hidden" name="student_ic" value="{{ $student_ic }}">
                <input type="hidden" name="psychologist_id" id="selectedPsychologistId">

                <div class="mb-4">
                    <label for="customMessage" class="block text-sm font-medium text-gray-700">Counsellor's Note from First Intervention Appointment to Psychologist</label>
                    <textarea id="customMessage" name="customMessage" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($psychologists as $psychologist)
                    <div class="psychologist-card bg-white border rounded-lg shadow-md cursor-pointer text-center transition duration-300 ease-in-out transform hover:scale-105 hover:border-blue-500 p-4 flex flex-col items-center" onclick="selectPsychologist(this, '{{ $psychologist->id }}')">
                        @if($psychologist->icon)
                        <div class="relative">
                            <div class="w-32 h-32">
                                <img src="{{ asset('images/psychologists/' . $psychologist->icon) }}" alt="{{ $psychologist->name }}" class="object-cover w-full h-full rounded-full">
                            </div>
                        </div>
                        @endif
                        <h3 class="text-lg font-semibold mt-4">{{ $psychologist->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $psychologist->specialization }}</p>
                        <ul class="list-disc list-inside text-left mx-auto">
                            @foreach($psychologist->getAttributes() as $key => $value)
                                @if($value !== null && !in_array($key, ['icon', 'created_at', 'updated_at', 'id', 'name', 'specialization']))
                                    <li><span class="font-semibold">{{ ucwords(str_replace('_', ' ', $key)) }}:</span> {{ $value }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-500 w-20 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition duration-300 ease-in-out disabled:opacity-50" id="submitButton" disabled>
                        Next
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPsychologist(card, psychologistId) {
        var selectedPsychologistId = document.getElementById('selectedPsychologistId');
        var submitButton = document.getElementById('submitButton');
        
        // Remove selection from all cards
        var cards = document.querySelectorAll('.psychologist-card');
        cards.forEach(function(card) {
            card.classList.remove('border-2', 'border-blue-500', 'scale-105');
        });

        // Add selection to the clicked card
        card.classList.add('border-2', 'border-blue-500', 'scale-105');
        
        // Set the selected psychologist ID
        selectedPsychologistId.value = psychologistId;
        
        // Enable the submit button
        submitButton.disabled = false;
    }
</script>

@endsection
