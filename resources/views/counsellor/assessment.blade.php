@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-6">
            <div class="border-b p-2 text-xl text-gray-800 font-semibold">
                List of Assessment Questions
            </div>
            <div class="p-4">
                @if(Session::has('message'))
                    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('counsellor.add-question') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-4 py-2 rounded-md shadow-lg transform transition-all duration-300 ease-in-out hover:scale-105">Add New Question</a>
                    <div class="flex items-center space-x-4">
                        <span id="assessmentStatusText" class="text-gray-700">{{ $assessmentEnabled ? 'Assessment Enabled' : 'Assessment Disabled' }}</span>
                        <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in transform">
                            <input type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer shadow-inner transform transition duration-200 ease-in-out" onchange="toggleAssessment()" {{ $assessmentEnabled ? 'checked' : '' }}>
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer shadow-inner transform transition duration-200 ease-in-out"></label>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-md shadow-md">
                        <h3 class="text-lg text-gray-800 font-medium mb-2">Answers for Each Question</h3>
                        <ul class="list-disc list-inside ml-4">
                            <li class="mb-1"><strong>Did not apply to me at all:</strong> 0 point</li>
                            <li class="mb-1"><strong>Applied to me to some degree, or some of the time:</strong> 1 point</li>
                            <li class="mb-1"><strong>Applied to me to a considerable degree, or a good part of the time:</strong> 2 point</li>
                            <li><strong>Applied to me very much, or most of the time:</strong> 3 point</li>
                        </ul>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <div class="min-w-full bg-white shadow overflow-hidden sm:rounded-lg">
                        @php
                            $categories = [
                                1 => 'Depression',
                                2 => 'Anxiety',
                                3 => 'Stress',
                            ];
                        @endphp

                        @foreach($categories as $categoryId => $categoryName)
                            @php
                                $categoryQuestions = $questions->where('category_id', $categoryId);
                            @endphp
                            @if($categoryQuestions->isNotEmpty())
                                <div class="mt-4">
                                    <h3 class="text-lg text-gray-800 font-medium mb-2">{{ $categoryName }}</h3>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10/12">Question</th>
                                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($categoryQuestions as $key => $question)
                                                <tr>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $loop->iteration }}</td>
                                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 text-left">{{ $question->question }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-medium flex items-center justify-center space-x-2">
                                                        <a href="{{ route('counsellor.edit-question', $question->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <form method="post" action="{{ route('counsellor.delete-question', $question->id) }}" class="inline-block" onsubmit="return confirmDelete()">
                                                        @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>                                                    
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if($questions->whereNotIn('category_id', array_keys($categories))->isNotEmpty())
                            <div class="mt-4">
                                <h3 class="text-lg font-medium mb-2">Unknown</h3>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10/12">Question</th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($questions->whereNotIn('category_id', array_keys($categories)) as $key => $question)
                                            <tr>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 text-center">{{ $question->question }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-medium flex items-center justify-center space-x-2">
                                                    <a href="{{ route('counsellor.edit-question', $question->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{ route('counsellor.delete-question', $question->id) }}" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>                                                    
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .toggle-checkbox:checked + .toggle-label {
        background-color: #3b82f6; /* Blue when checked */
    }

    .toggle-checkbox:focus + .toggle-label {
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5); /* Blue shadow when focused */
    }

    .toggle-checkbox:checked + .toggle-label:before {
        transform: translateX(20px); /* Move circle when checked */
    }

    .toggle-checkbox {
        display: none;
    }

    .toggle-label {
        display: block;
        width: 40px;
        height: 20px;
        background-color: #ccc;
        border-radius: 9999px;
        position: relative;
        transition: background-color 0.2s;
    }

    .toggle-label:before {
        content: '';
        display: block;
        width: 14px;
        height: 14px;
        background-color: white;
        border-radius: 9999px;
        position: absolute;
        top: 3px;
        left: 3px;
        transition: transform 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* 3D effect */
    }
</style>

<script>
    function toggleAssessment() {
        const toggle = document.getElementById('toggle');
        const assessmentStatusText = document.getElementById('assessmentStatusText');

        // Update the text content based on the checked state of the toggle
        assessmentStatusText.textContent = toggle.checked ? 'Assessment Enabled' : 'Assessment Disabled';

        // Perform AJAX request to toggle the assessment status
        fetch("{{ route('counsellor.assessment.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update the button text based on the response
            const button = document.querySelector('.toggle-assessment-button');
            button.textContent = data.enabled ? 'Disable Assessment' : 'Enable Assessment';
        })
        .catch(error => console.error('Error toggling assessment:', error));
    }

    function confirmDelete() {
        return confirm('Are you sure you want to delete this question?');
    }
</script>
@endsection
