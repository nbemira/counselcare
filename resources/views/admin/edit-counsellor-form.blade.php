@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                Edit Counsellor
            </div>
            <div class="p-4">
                @if(Session::has('message'))
                    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ Session::get('message') }}
                    </div>
                @endif

                @if($counsellor)
                <form method="post" action="{{ route('admin.edit-counsellor', $counsellor->ic) }}" enctype="multipart/form-data">
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
                                        value="{{ $counsellor->ic }}"
                                        class="p-2 border rounded-md bg-gray-100 w-full"
                                        maxlength="12"
                                        readonly
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
                                        value="{{ old('name', $counsellor->name) }}"
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
                                        value="{{ old('email', $counsellor->email) }}"
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
                @else
                    <p class="text-red-500">Counsellor not found!</p>
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
