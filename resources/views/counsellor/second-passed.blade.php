@extends('counsellor.case-management')

@section('nested-content')
<div class="mt-6">
    <h3 class="text-xl font-semibold mb-6 text-center text-gray-800">Second Passed Cases</h3>

    <!-- Search Form -->
    <form method="GET" action="{{ route('counsellor.secondPassed') }}" class="flex items-center space-x-2 mb-6">
        <input type="text" name="search" id="searchInput" class="form-input w-full px-4 py-2 border rounded-l-md" placeholder="Search by name, IC, or class..." value="{{ request('search') }}">
        <button type="submit" class="text-zinc-500 px-4 py-2 rounded-r-md flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a5 5 0 11-10 0 5 5 0 0110 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
            </svg>
        </button>
        <a href="{{ route('counsellor.secondPassed') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Clear</a>
    </form>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">#</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">Name</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">IC</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">Class</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">Date Submitted</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-100" colspan="3">First Assessment</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-100" colspan="3">Second Assessment</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">D</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">A</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">S</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">D</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">A</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">S</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($secondPassedStudents as $index => $student)
                <tr>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->name }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->ic }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->class }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ \Carbon\Carbon::parse($student->second_created_at)->format('d M Y g:i A') }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->first_marks_d }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->first_marks_a }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->first_marks_s }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->second_marks_d }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->second_marks_a }}</td>
                    <td class="px-6 py-2 text-center text-sm text-gray-900">{{ $student->second_marks_s }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
