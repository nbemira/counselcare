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

                        <!-- IC Number Field -->
                        <div class="flex flex-col mb-4">
                            <label for="ic" class="text-sm mt-2 font-semibold text-base">IC Number</label>
                            <p class="text-gray-500 text-xs mb-2">IC number cannot be changed.</p>
                            <input
                                type="text"
                                name="ic"
                                id="ic"
                                value="{{ $counsellor->ic }}"
                                class="p-2 border rounded-md bg-gray-100"
                                maxlength="12"
                                readonly
                                onfocus="this.removeAttribute('readonly'); this.setAttribute('disabled', true);"
                                onblur="this.removeAttribute('disabled'); this.setAttribute('readonly', true);"
                            >
                        </div>

                        <!-- Full Name Field -->
                        <div class="flex flex-col mb-4">
                            <label for="name" class="text-sm mt-2 mb-2 font-semibold text-base">Full Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ $counsellor->name }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                            @error('name')
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
                                value="{{ $counsellor->email }}"
                                class="p-2 border rounded-md focus:border-blue-500 focus:outline-none"
                            >
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-5 space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-500 w-20 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                Save
                            </button>
                            <button onclick="event.preventDefault(); location.href='{{ route('admin.manage-counsellors') }}';" class="px-4 py-2 w-20 text-gray-500 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                Cancel
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="text-red-500">Counsellor not found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
