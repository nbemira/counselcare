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
                <form method="post" action="{{ route('admin.edit-psychologist', $psychologist->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Icon</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="file"
                                        name="icon"
                                        id="icon"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('icon')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    @if($psychologist->icon)
                                        <img src="{{ asset('images/psychologists/' . $psychologist->icon) }}" alt="Psychologist Icon" class="mt-2" style="max-height: 100px;">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Name</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $psychologist->name) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validateName(this);"
                                    >
                                    @error('name')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Qualifications</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="qualifications"
                                        id="qualifications"
                                        value="{{ old('qualifications', $psychologist->qualifications) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validateAlphaExtended(this);"
                                    >
                                    @error('qualifications')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Specialization</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="specialization"
                                        id="specialization"
                                        value="{{ old('specialization', $psychologist->specialization) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validateAlphaExtended(this);"
                                    >
                                    @error('specialization')
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
                                        value="{{ old('email', $psychologist->email) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('email')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Phone</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        maxlength="11"
                                        value="{{ old('phone', $psychologist->phone) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validatePhone(this);"
                                    >
                                    @error('phone')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Location</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="location"
                                        id="location"
                                        value="{{ old('location', $psychologist->location) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('location')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Availability</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="availability"
                                        id="availability"
                                        value="{{ old('availability', $psychologist->availability) }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('availability')
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
                                    <a href="{{ route('admin.manage-psychologists') }}" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded-md hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                        Cancel
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                @else
                    <p class="text-red-500">Psychologist not found!</p>
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

    function validateAlphaExtended(input) {
        const regex = /^[A-Za-z\s().]+$/;
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^A-Za-z\s().]/g, '');
        }
    }

    function validatePhone(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>

@endsection
