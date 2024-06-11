@extends('layouts.app')

@section('content')
<div class="py-12 bg-gradient-to-r from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl mx-auto px-4 lg:px-8 flex justify-center items-center">
        <div class="bg-white border rounded-lg shadow-xl p-15 flex items-center justify-center w-full">
            <div class="p-4 w-full">
                @if($canAccessAssessment)
                <div class="flex items-center mb-4">
                    <button id="prev-btn" onclick="showPrev()" class="flex items-center text-gray-600 hover:text-gray-800 hidden">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Previous
                    </button>
                </div>
                @endif
                
                @if(!$assessmentEnabled)
                    <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4">
                        Assessment is currently disabled.
                    </div>
                @elseif(!$canAccessAssessment)
                    <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4">
                        You have already completed this assessment.
                    </div>
                @else
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="container">
                        <div class="mt-4 mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div id="progress-bar" class="bg-blue-500 h-2.5 rounded-full" style="width: 0%"></div>
                            </div>
                            <div class="text-right mt-2 text-gray-700" id="progress-text">0% Complete</div>
                        </div>
                        <form id="assessment-form" action="{{ route('submit-assessment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_ic" value="{{ $studentIC }}">
                            <div id="questions-container" class="grid grid-cols-1 gap-8">
                                @php $index = 0; @endphp
                                @foreach($questions as $question)
                                    <div class="question-container p-4 @if($index != 0) hidden @endif" data-question-id="{{ $question->id }}">
                                        <div class="question-text-container text-2xl text-center text-gray-800 font-semibold h-20 overflow-y-auto">
                                            <p class="question-text">{{ $question->question }}</p>
                                        </div>
                                        <div class="grid gap-4 relative w-4/5 mx-auto">
                                            <!-- Labels -->
                                            <label class="block bg-blue-100 p-4 rounded-md transition hover:bg-blue-200 relative w-full max-w-2xl mx-auto border rounded-md focus:border-blue-500">
                                                Did not apply to me at all
                                                <input type="radio" name="answers[{{ $question->id }}]" value="0" class="hidden-radio absolute inset-0 opacity-0">
                                            </label>
                                            <label class="block bg-blue-100 p-4 rounded-md transition hover:bg-blue-200 relative w-full max-w-2xl mx-auto border rounded-md focus:border-blue-500">
                                                Applied to me to some degree, or some of the time
                                                <input type="radio" name="answers[{{ $question->id }}]" value="1" class="hidden-radio absolute inset-0 opacity-0">
                                            </label>
                                            <label class="block bg-blue-100 p-4 rounded-md transition hover:bg-blue-200 relative w-full max-w-2xl mx-auto border rounded-md focus:border-blue-500">
                                                Applied to me to a considerable degree, or a good part of the time
                                                <input type="radio" name="answers[{{ $question->id }}]" value="2" class="hidden-radio absolute inset-0 opacity-0">
                                            </label>
                                            <label class="block bg-blue-100 p-4 rounded-md transition hover:bg-blue-200 relative w-full max-w-2xl mx-auto border rounded-md focus:border-blue-500">
                                                Applied to me very much, or most of the time
                                                <input type="radio" name="answers[{{ $question->id }}]" value="3" class="hidden-radio absolute inset-0 opacity-0">
                                            </label>
                                        </div>
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            </div>
                            <div class="text-center mt-5 mb-4">
                                <button type="submit" id="submit-btn" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-4 py-2 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hidden">Submit</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .selected-answer {
        background-color: #93C5FD; /* Use a darker shade of the original color */
    }
</style>

<script>
    // JavaScript to show/hide questions and go back to the previous question
    var currentQuestion = 0;
    var totalQuestions = document.querySelectorAll('.question-container').length;

    function showNext() {
        if (currentQuestion < totalQuestions - 1) {
            document.querySelectorAll('.question-container')[currentQuestion].classList.add('hidden');
            currentQuestion++;
            document.querySelectorAll('.question-container')[currentQuestion].classList.remove('hidden');
            updateButtonVisibility();
            updateProgressBar();
        }
    }

    function showPrev() {
        if (currentQuestion > 0) {
            document.querySelectorAll('.question-container')[currentQuestion].classList.add('hidden');
            currentQuestion--;
            document.querySelectorAll('.question-container')[currentQuestion].classList.remove('hidden');
            updateButtonVisibility();
            updateProgressBar();
        }
    }

    function updateButtonVisibility() {
        if (currentQuestion === totalQuestions - 1) {
            document.getElementById('submit-btn').classList.remove('hidden');
        } else {
            document.getElementById('submit-btn').classList.add('hidden');
        }

        if (currentQuestion === 0) {
            document.getElementById('prev-btn').classList.add('hidden');
        } else {
            document.getElementById('prev-btn').classList.remove('hidden');
        }
    }

    function updateProgressBar() {
        var progress = (currentQuestion / totalQuestions) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-text').textContent = Math.round(progress) + '% Complete';
    }

    function validateAndProceed() {
        var questionContainer = document.querySelectorAll('.question-container')[currentQuestion];
        var selectedAnswer = questionContainer.querySelector('input[name="answers[' + questionContainer.getAttribute('data-question-id') + ']"]:checked');
        
        console.log('Current Question ID:', questionContainer.getAttribute('data-question-id')); // Debug
        console.log('Selected Answer:', selectedAnswer); // Debug
        
        if (selectedAnswer) {
            // Remove the selected-answer class from all labels
            var allLabels = questionContainer.querySelectorAll('label');
            allLabels.forEach((label) => {
                label.classList.remove('selected-answer');
            });

            // Add the selected-answer class to the label of the selected radio input
            selectedAnswer.parentElement.classList.add('selected-answer');

            // Proceed to the next question if not the last question
            if (currentQuestion < totalQuestions - 1) {
                showNext();
            }
        } else {
            alert('Please select an answer before proceeding.');
        }
    }

    // Automatically proceed to the next question when an answer is selected
    document.querySelectorAll('.question-container input[type="radio"]').forEach((radio) => {
        radio.addEventListener('change', validateAndProceed);
    });

    // Initialize the progress bar
    updateProgressBar();
</script>

@endsection
