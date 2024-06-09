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
                <form method="post" action="{{ route('admin.add-student') }}" enctype="multipart/form-data">
                    @csrf
                        <!-- IC Number Field -->
                        <div class="flex flex-col">
                            <label for="ic" class="block text-sm mt-2 font-semibold text-base">IC Number</label>
                            <p class="text-gray-500 text-xs mb-2">Enter the IC number without dashes ("-").</p>
                            <input
                                type="text"
                                name="ic"
                                id="ic"
                                value="{{ old('ic') }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                maxlength="12"
                                oninput="removeNonNumeric(this); removeDash(this); validateIC(this); updatePassword(this, document.getElementById('password'));"
                                onblur="checkICLength(this);"
                                aria-describedby="ic-error"
                            >
                            @error('ic')
                                <span id="ic-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="flex flex-col">
                            <label for="password" class="block text-sm mt-4 mb-2 font-semibold text-base">Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                readonly
                                onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"                            >
                            @error('password')
                                <span id="password-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Full Name Field -->
                        <div class="flex flex-col">
                            <label for="name" class="block text-sm mt-4 mb-2 font-semibold text-base">Full Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                aria-describedby="name-error"
                            >
                            @error('name')
                                <span id="name-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="flex flex-col">
                            <label for="email" class="block text-sm mt-4 mb-2 font-semibold text-base">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                aria-describedby="email-error"
                            >
                            @error('email')
                                <span id="email-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Class Field -->
                        <div class="flex flex-col">
                            <label for="class" class="block text-sm mt-4 mb-2 font-semibold text-base">Class</label>
                            <select
                                name="class"
                                id="class"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                aria-describedby="class-error"
                            >
                                <option value="1S">1S</option>
                                <option value="1T">1T</option>
                                <option value="2S">2S</option>
                                <option value="2T">2T</option>
                                <option value="3S">3S</option>
                                <option value="3T">3T</option>
                                <option value="4S">4S</option>
                                <option value="4T">4T</option>
                                <option value="5S">5S</option>
                                <option value="5T">5T</option>
                            </select>
                            @error('class')
                                <span id="class-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender Field -->
                        <div class="flex flex-col">
                            <label for="gender" class="block text-sm mt-4 mb-2 font-semibold text-base">Gender</label>
                            <select
                                name="gender"
                                id="gender"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                                aria-describedby="gender-error"
                            >
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                            @error('gender')
                                <span id="gender-error" class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-5 space-x-2">
                            <button type="submit" class="px-4 py-2 w-20 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                Save
                            </button>
                            <button onclick="event.preventDefault(); location.href='{{ route('admin.dashboard') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded-md hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Execute the script when the page loads
    window.onload = function () {
        // Initial password generation based on IC number
        updatePassword(document.getElementById('ic'), document.getElementById('password'));
    };

    function removeNonNumeric(input) {
        // Allow only numeric input
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function removeDash(input) {
        // Check if a dash is present and remove it
        if (input.value.includes('-')) {
            input.value = input.value.replace(/-/g, '');
        }
    }

    function validateIC(input) {
        let icNumber = input.value;

        // Remove any non-numeric characters
        icNumber = icNumber.replace(/[^0-9]/g, '');

        // Ensure the length is exactly 12 characters
        if (icNumber.length !== 12) {
            // Delay showing the alert until onBlur event
            input.setAttribute('data-length-error', true);
        } else {
            input.removeAttribute('data-length-error');
        }
    }

    function checkICLength(input) {
        // Check for length error flag
        if (input.getAttribute('data-length-error')) {
            alert('IC number must be 12 characters long.');
            input.value = ''; // Clear the input if not valid
        }
    }

    function updatePassword(icInput, passwordInput) {
        icInput.addEventListener('input', function () {
            let icNumber = this.value;
            icNumber = icNumber.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            passwordInput.value = icNumber;
        });
    }
</script>
@endsection
