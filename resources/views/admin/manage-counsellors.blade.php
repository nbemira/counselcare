@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
                List of all counsellors
            </div>
            <div class="p-2">
                <!-- Message Alert -->
                <div class="mb-4">
                    @if(Session::has('message'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                            {{ session('error') }}
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <a href="{{ route('admin.counsellor-form') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-4 py-2 rounded-md shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Add New Counsellor</a>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.manage-counsellors') }}" class="flex items-center space-x-2">
                            <input type="text" name="search" id="searchInput" class="form-input w-full px-4 py-2 border rounded-l-md" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="text-zinc-500 px-4 py-2 rounded-r-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a5 5 0 11-10 0 5 5 0 0110 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
                                </svg>
                            </button>
                            <a href="{{ route('admin.manage-counsellors') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Clear</a>
                        </form>
                    </div>
                </div>

                <div class="flex flex-col mt-4">
                    <div class="overflow-x-auto sm:px-6 lg:px-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($counsellors as $counsellor)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration + ($counsellors->currentPage() - 1) * $counsellors->perPage() }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $counsellor->ic }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $counsellor->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $counsellor->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.edit-counsellor-form', $counsellor->ic) }}" class="inline-block text-blue-500 mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{ route('admin.delete-counsellor', $counsellor->ic) }}" class="inline-block delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="inline-block text-red-500 delete-button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Pagination Links -->
                                <div class="mt-4 mb-4 px-6 lg:px-8">
                                    {{ $counsellors->appends(['search' => request('search')])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Confirm before deleting
    document.querySelectorAll('button.delete-button').forEach(button => {
        button.addEventListener('click', function (event) {
            if (!confirm('Are you sure you want to delete this counsellor?')) {
                event.preventDefault();
            }
        });
    });

    // Client-side search filter
    document.getElementById('searchInput').addEventListener('input', function () {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let ic = row.querySelector('td:nth-child(2)').textContent.toUpperCase();
            let name = row.querySelector('td:nth-child(3)').textContent.toUpperCase();
            let email = row.querySelector('td:nth-child(4)').textContent.toUpperCase();
            if (ic.includes(filter) || name.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
