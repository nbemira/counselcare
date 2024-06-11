@extends('counsellor.case-management')

@section('nested-content')
<div class="mt-6">
    <h3 class="text-xl font-semibold mb-6 text-center text-gray-800">Second Intervention Cases</h3>
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
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" rowspan="2">Assign Psychologist</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-blue-50">D</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-blue-50">A</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-blue-50">S</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-yellow-50">D</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-yellow-50">A</th>
                    <th class="px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12 bg-yellow-50">S</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($secondInterventionStudents as $index => $student)
                <tr>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->name }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->ic }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->class }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ \Carbon\Carbon::parse($student->second_created_at)->format('d M Y g:i A') }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->first_marks_d >= 8) text-red-600 @else text-gray-900 @endif w-12">{{ $student->first_marks_d }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->first_marks_a >= 7) text-red-600 @else text-gray-900 @endif w-12">{{ $student->first_marks_a }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->first_marks_s >= 10) text-red-600 @else text-gray-900 @endif w-12">{{ $student->first_marks_s }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->second_marks_d >= 8) text-red-600 @else text-gray-900 @endif w-12">{{ $student->second_marks_d }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->second_marks_a >= 7) text-red-600 @else text-gray-900 @endif w-12">{{ $student->second_marks_a }}</td>
                    <td class="px-6 py-2 text-center text-sm @if($student->second_marks_s >= 10) text-red-600 @else text-gray-900 @endif w-12">{{ $student->second_marks_s }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('counsellor.selectPsychologist', ['student_ic' => $student->ic]) }}" class="text-blue-500 hover:text-blue-700 block mx-auto" style="width: 24px; height: 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-report-medical">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M10 14l4 0" />
                                <path d="M12 12l0 4" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
