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

                        <!-- IC Number Field -->
                        <div class="flex flex-col">
                            <label for="ic" class="text-sm mt-2 font-semibold text-base">IC Number</label>
                            <p class="text-gray-500 text-xs mb-2">IC number cannot be changed.</p>
                            <input
                                type="text"
                                name="ic"
                                id="ic"
                                value="{{ $student->ic }}"
                                class="p-2 border rounded-md bg-gray-100"
                                maxlength="12"
                                readonly
                                onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"
                            >
                        </div>

                        <!-- Full Name Field -->
                        <div class="flex flex-col">
                            <label for="name" class="text-sm mt-4 mb-2 font-semibold text-base">Full Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ $student->name }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="flex flex-col">
                            <label for="email" class="block text-sm mt-4 mb-2 font-semibold text-base">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ $student->email }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Class Field -->
                        <div class="flex flex-col">
                            <label for="class" class="block text-sm mt-4 mb-2 font-semibold text-base">Class</label>
                            <select
                                name="class"
                                id="class"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                                <option value="1S" @if($student->class === '1S') selected @endif>1S</option>
                                <option value="1T" @if($student->class === '1T') selected @endif>1T</option>
                                <option value="2S" @if($student->class === '2S') selected @endif>2S</option>
                                <option value="2T" @if($student->class === '2T') selected @endif>2T</option>
                                <option value="3S" @if($student->class === '3S') selected @endif>3S</option>
                                <option value="3T" @if($student->class === '3T') selected @endif>3T</option>
                                <option value="4S" @if($student->class === '4S') selected @endif>4S</option>
                                <option value="4T" @if($student->class === '4T') selected @endif>4T</option>
                                <option value="5S" @if($student->class === '5S') selected @endif>5S</option>
                                <option value="5T" @if($student->class === '5T') selected @endif>5T</option>
                            </select>
                            @error('class')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender Field -->
                        <div class="flex flex-col">
                            <label for="gender" class="block text-sm mt-4 mb-2 font-semibold text-base">Gender</label>
                            <select
                                name="gender"
                                id="gender"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                                <option value="female" @if($student->gender === 'female') selected @endif>Female</option>
                                <option value="male" @if($student->gender === 'male') selected @endif>Male</option>
                            </select>
                            @error('gender')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-5 space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-500 w-20 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                Save
                            </button>
                            <button onclick="event.preventDefault(); location.href='{{ route('admin.manage-students') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                Cancel
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="text-red-500">Student not found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
