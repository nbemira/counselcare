@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded shadow p-4">
                <div class="border-b p-2 text-xl font-semibold">
                    Edit Psychologist
                </div>
                <div class="p-4">
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if($psychologist)
                    <form method="post" action="{{ route('admin.edit-psychologist', ['id' => $psychologist->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                            <!-- Icon Field -->
                            <div class="flex flex-col mb-4">
                                <label for="icon" class="block text-sm mt-2 mb-2 font-semibold text-base">Icon</label>
                                <input
                                    type="file"
                                    name="icon"
                                    id="icon"
                                    class="p-2 border rounded-md w-full"
                                >
                                @if ($psychologist->icon)
                                    <span class="text-gray-500">Current icon:</span>
                                    <img src="{{ asset('images/psychologists/' . $psychologist->icon) }}" alt="Current Icon" class="mt-2 w-20 h-20 object-contain">
                                @endif
                                @error('icon')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Name Field -->
                            <div class="flex flex-col mb-4">
                                <label for="name" class="block text-sm mt-2 mb-2 font-semibold text-base">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $psychologist->name) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Qualifications Field -->
                            <div class="flex flex-col mb-4">
                                <label for="qualifications" class="block text-sm mt-2 mb-2 font-semibold text-base">Qualifications</label>
                                <input
                                    type="text"
                                    name="qualifications"
                                    id="qualifications"
                                    value="{{ old('qualifications', $psychologist->qualifications) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('qualifications')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Specialization Field -->
                            <div class="flex flex-col mb-4">
                                <label for="specialization" class="block text-sm mt-2 mb-2 font-semibold text-base">Specialization</label>
                                <input
                                    type="text"
                                    name="specialization"
                                    id="specialization"
                                    value="{{ old('specialization', $psychologist->specialization) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('specialization')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="flex flex-col mb-4">
                                <label for="email" class="block text-sm mt-2 mb-2 font-semibold text-base">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $psychologist->email) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="flex flex-col mb-4">
                                <label for="phone" class="block text-sm mt-2 mb-2 font-semibold text-base">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    maxlength="11"
                                    value="{{ old('phone', $psychologist->phone) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('phone')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Location Field -->
                            <div class="flex flex-col mb-4">
                                <label for="location" class="block text-sm mt-2 mb-2 font-semibold text-base">Location</label>
                                <input
                                    type="text"
                                    name="location"
                                    id="location"
                                    value="{{ old('location', $psychologist->location) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('location')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Availability Field -->
                            <div class="flex flex-col mb-4">
                                <label for="availability" class="block text-sm mt-2 mb-2 font-semibold text-base">Availability</label>
                                <input
                                    type="text"
                                    name="availability"
                                    id="availability"
                                    value="{{ old('availability', $psychologist->availability) }}"
                                    class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                >
                                @error('availability')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="flex justify-end mt-5 space-x-2">
                                <button type="submit" class="px-4 py-2 bg-blue-500 w-20 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Save
                                </button>
                                <a href="{{ route('admin.manage_psychologists') }}" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                    Cancel
                                </a>
                            </div>
                    </form>
                    @else
                        <p class="text-red-500">Psychologist not found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection