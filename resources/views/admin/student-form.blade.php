@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                Add New Student
            </div>
            <div class="p-4">
                @if(Session::has('message'))
                    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <form method="post" action="{{ route('admin.add-student') }}" enctype="multipart/form-data">
                    @csrf
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">IC Number</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="ic"
                                        id="ic"
                                        value="{{ old('ic') }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        maxlength="12"
                                        oninput="removeNonNumeric(this); removeDash(this); validateIC(this); updatePassword(this, document.getElementById('password'));"
                                        onblur="checkICLength(this);"
                                        aria-describedby="ic-error"
                                    >
                                    @error('ic')
                                        <span id="ic-error" class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    <p class="text-gray-500 text-xs mt-1">Enter the IC number without dashes ("-").</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Password</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        value="{{ old('ic') }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        readonly
                                        onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                        onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"
                                    >
                                    @error('password')
                                        <span id="password-error" class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">Full Name</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        oninput="validateName(this);"
                                        aria-describedby="name-error"
                                    >
                                    @error('name')
                                        <span id="name-error" class="text-red-500">{{ $message }}</span>
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
                                        value="{{ old('email') }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        aria-describedby="email-error"
                                    >
                                    @error('email')
                                        <span id="email-error" class="text-red-500">{{ $message }}</span>
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
                                        aria-describedby="class-error"
                                    >
                                        <!-- Add all class options here -->
                                        <option value="1S" {{ old('class') == '1S' ? 'selected' : '' }}>1S</option>
                                        <option value="1T" {{ old('class') == '1T' ? 'selected' : '' }}>1T</option>
                                        <option value="1E" {{ old('class') == '1E' ? 'selected' : '' }}>1E</option>
                                        <option value="1L" {{ old('class') == '1L' ? 'selected' : '' }}>1L</option>
                                        <option value="2S" {{ old('class') == '2S' ? 'selected' : '' }}>2S</option>
                                        <option value="2T" {{ old('class') == '2T' ? 'selected' : '' }}>2T</option>
                                        <option value="2E" {{ old('class') == '2E' ? 'selected' : '' }}>2E</option>
                                        <option value="2L" {{ old('class') == '2L' ? 'selected' : '' }}>2L</option>
                                        <option value="2A" {{ old('class') == '2A' ? 'selected' : '' }}>2A</option>
                                        <option value="3S" {{ old('class') == '3S' ? 'selected' : '' }}>3S</option>
                                        <option value="3T" {{ old('class') == '3T' ? 'selected' : '' }}>3T</option>
                                        <option value="3E" {{ old('class') == '3E' ? 'selected' : '' }}>3E</option>
                                        <option value="3L" {{ old('class') == '3L' ? 'selected' : '' }}>3L</option>
                                        <option value="3A" {{ old('class') == '3A' ? 'selected' : '' }}>3A</option>
                                        <option value="4S" {{ old('class') == '4S' ? 'selected' : '' }}>4S</option>
                                        <option value="4T" {{ old('class') == '4T' ? 'selected' : '' }}>4T</option>
                                        <option value="4E" {{ old('class') == '4E' ? 'selected' : '' }}>4E</option>
                                        <option value="4L" {{ old('class') == '4L' ? 'selected' : '' }}>4L</option>
                                        <option value="4A" {{ old('class') == '4A' ? 'selected' : '' }}>4A</option>
                                        <option value="5S" {{ old('class') == '5S' ? 'selected' : '' }}>5S</option>
                                        <option value="5T" {{ old('class') == '5T' ? 'selected' : '' }}>5T</option>
                                        <option value="5E" {{ old('class') == '5E' ? 'selected' : '' }}>5E</option>
                                        <option value="5L" {{ old('class') == '5L' ? 'selected' : '' }}>5L</option>
                                        <option value="5A" {{ old('class') == '5A' ? 'selected' : '' }}>5A</option>
                                    </select>
                                    @error('class')
                                        <span id="class-error" class="text-red-500">{{ $message }}</span>
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
                                        aria-describedby="gender-error"
                                    >
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    </select>
                                    @error('gender')
                                        <span id="gender-error" class="text-red-500">{{ $message }}</span>
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
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        updatePassword(document.getElementById('ic'), document.getElementById('password'));
    };

    function removeNonNumeric(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function removeDash(input) {
        if (input.value.includes('-')) {
            input.value = input.value.replace(/-/g, '');
        }
    }

    function validateIC(input) {
        let icNumber = input.value;
        icNumber = icNumber.replace(/[^0-9]/g, '');
        if (icNumber.length !== 12) {
            input.setAttribute('data-length-error', true);
        } else {
            input.removeAttribute('data-length-error');
        }
    }

    function checkICLength(input) {
        if (input.getAttribute('data-length-error')) {
            alert('IC number must be 12 characters long.');
            input.value = '';
        }
    }

    function updatePassword(icInput, passwordInput) {
        icInput.addEventListener('input', function () {
            let icNumber = this.value;
            icNumber = icNumber.replace(/[^0-9]/g, '');
            passwordInput.value = icNumber;
        });
        passwordInput.value = icInput.value.replace(/[^0-9]/g, ''); // Initial load
    }

    function validateName(input) {
        const regex = /^[A-Za-z\s@]+$/;
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^A-Za-z\s@]/g, '');
        }
    }
</script>
@endsection
