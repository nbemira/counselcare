@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-xl font-semibold">
            List of all students
            </div>
            <div class="p-2">
                <!-- Message and Add New Student Button -->
                <div class="mb-4">
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
                    <div class="flex items-center justify-between mt-2">
                    <a href="{{ route('admin.student-form') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-4 py-2 rounded-md shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Add New Student
                    </a>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.manage-students') }}" class="flex items-center space-x-2">
                            <input type="text" name="search" id="searchInput" class="form-input w-full px-4 py-2 border rounded-l-md" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="text-gray-700 p-2 transition duration-300 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a5 5 0 11-10 0 5 5 0 0110 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
                                </svg>
                            </button>
                            <a href="{{ route('admin.manage-students') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                Clear
                            </a>
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
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">IC</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($students as $student)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->ic }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->class }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($student->gender) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.edit-student-form', $student->ic) }}" class="inline-block text-blue-500 mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{ route('admin.delete-student', $student->ic) }}" class="inline-block delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="inline-block text-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
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
                                    {{ $students->appends(['search' => request('search')])->links() }}
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
    document.querySelectorAll('form.delete-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!confirm('Are you sure you want to delete this student?')) {
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
            let classField = row.querySelector('td:nth-child(4)').textContent.toUpperCase();
            let email = row.querySelector('td:nth-child(5)').textContent.toUpperCase();
            if (ic.includes(filter) || name.includes(filter) || classField.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
