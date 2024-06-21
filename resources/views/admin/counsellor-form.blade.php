@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                Add New Counsellor
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
                <form method="post" action="{{ route('admin.add-counsellor') }}" enctype="multipart/form-data">
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
                                    >
                                    @error('ic')
                                        <span class="text-red-500">{{ $message }}</span>
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
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                        readonly
                                        onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                        onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"
                                    >
                                    @error('password')
                                        <span class="text-red-500">{{ $message }}</span>
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
                                        value="{{ old('email') }}"
                                        class="p-2 border rounded-md focus:border-blue-500 focus:outline-none w-full"
                                    >
                                    @error('email')
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
                                    <button onclick="event.preventDefault(); location.href='{{ route('admin.manage-counsellors') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded-md hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
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
