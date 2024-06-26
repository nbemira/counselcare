@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                Edit Student
            </div>
            <div class="p-4">
                @if(Session::has('message'))
                    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ Session::get('message') }}
                    </div>
                @endif

                @if($student)
                <form method="post" action="{{ route('admin.edit-student', $student->ic) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">IC Number</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="ic"
                                        id="ic"
                                        value="{{ $student->ic }}"
                                        class="p-2 border rounded-md bg-gray-100 w-full"
                                        maxlength="12"
                                        readonly
                                        onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                        onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"
                                    >
                                    <p class="text-gray-500 text-xs mt-1">IC number cannot be changed.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Full Name</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $student->name) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validateName(this);"
                                    >
                                    @error('name')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Email</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', $student->email) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('email')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Class</td>
                                <td class="px-6 py-4">
                                    <select
                                        name="class"
                                        id="class"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                        <option value="1S" @if($student->class === '1S') selected @endif>1S</option>
                                        <option value="1T" @if($student->class === '1T') selected @endif>1T</option>
                                        <option value="1E" @if($student->class === '1E') selected @endif>1E</option>
                                        <option value="1L" @if($student->class === '1L') selected @endif>1L</option>
                                        <option value="2S" @if($student->class === '2S') selected @endif>2S</option>
                                        <option value="2T" @if($student->class === '2T') selected @endif>2T</option>
                                        <option value="2E" @if($student->class === '2E') selected @endif>2E</option>
                                        <option value="2L" @if($student->class === '2L') selected @endif>2L</option>
                                        <option value="2A" @if($student->class === '2A') selected @endif>2A</option>
                                        <option value="3S" @if($student->class === '3S') selected @endif>3S</option>
                                        <option value="3T" @if($student->class === '3T') selected @endif>3T</option>
                                        <option value="3E" @if($student->class === '3E') selected @endif>3E</option>
                                        <option value="3L" @if($student->class === '3L') selected @endif>3L</option>
                                        <option value="3A" @if($student->class === '3A') selected @endif>3A</option>
                                        <option value="4S" @if($student->class === '4S') selected @endif>4S</option>
                                        <option value="4T" @if($student->class === '4T') selected @endif>4T</option>
                                        <option value="4E" @if($student->class === '4E') selected @endif>4E</option>
                                        <option value="4L" @if($student->class === '4L') selected @endif>4L</option>
                                        <option value="4A" @if($student->class === '4A') selected @endif>4A</option>
                                        <option value="5S" @if($student->class === '5S') selected @endif>5S</option>
                                        <option value="5T" @if($student->class === '5T') selected @endif>5T</option>
                                        <option value="5E" @if($student->class === '5E') selected @endif>5E</option>
                                        <option value="5L" @if($student->class === '5L') selected @endif>5L</option>
                                        <option value="5A" @if($student->class === '5A') selected @endif>5A</option>
                                    </select>
                                    @error('class')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Gender</td>
                                <td class="px-6 py-4">
                                    <select
                                        name="gender"
                                        id="gender"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                        <option value="female" @if($student->gender === 'female') selected @endif>Female</option>
                                        <option value="male" @if($student->gender === 'male') selected @endif>Male</option>
                                    </select>
                                    @error('gender')
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
                                    <button onclick="event.preventDefault(); location.href='{{ route('admin.manage-students') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                @else
                    <p class="text-red-500">Student not found!</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function validateName(input) {
        const regex = /^[A-Za-z\s@]+$/;
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^A-Za-z\s@]/g, '');
        }
    }
</script>
@endsection
