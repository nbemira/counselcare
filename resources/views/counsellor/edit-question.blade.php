@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                Edit Question
            </div>
            <div class="p-2">
                <!-- Message Alert -->
                @if(Session::has('message'))
                    <div class="bg-green-500 text-white px-4 py-2 rounded">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('counsellor.put-edit-question', $question->id) }}">
                    @csrf
                    @method('PUT')
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Question</td>
                                <td class="px-6 py-4">
                                    <textarea id="question" name="question" class="p-2 border rounded-md focus:border-blue-500 focus:outline-none no-scrollbar w-full" rows="1" oninput="validateQuestion(this);">{{ $question->question }}</textarea>
                                    @error('question')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Category</td>
                                <td class="px-6 py-4">
                                    <select id="category" name="category" class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full">
                                        <option value="1" @if($question->category_id == 1) selected @endif>Depression</option>
                                        <option value="2" @if($question->category_id == 2) selected @endif>Anxiety</option>
                                        <option value="3" @if($question->category_id == 3) selected @endif>Stress</option>
                                    </select>
                                    @error('category')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 flex justify-end space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 w-20 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                        Save
                                    </button>
                                    <button onclick="event.preventDefault(); location.href='{{ route('counsellor.assessment') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS to hide resizing arrow and scrollbar */
    textarea {
        resize: none; /* Disable resizing */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }
</style>

<script>
    function validateQuestion(input) {
        const regex = /^[^\d]*$/;
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/\d+/g, '');
        }
    }

    // Adjust textarea height dynamically based on content
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('textarea').forEach(function(textarea) {
            autoExpand(textarea);
            textarea.addEventListener('input', function() {
                autoExpand(this);
            });
        });
    });
    
    function autoExpand(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
</script>
@endsection
