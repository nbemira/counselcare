@extends('counsellor.case-management')

@section('nested-content')
<div class="mt-6">
    <h3 class="text-xl font-semibold mb-6 text-center text-gray-800">Intervention Cases</h3>

        <!-- Search Form -->
        <form method="GET" action="{{ route('counsellor.intervention') }}" class="flex items-center space-x-2 mb-6">
        <input type="text" name="search" id="searchInput" class="form-input w-full px-4 py-2 border rounded-l-md" placeholder="Search by name, IC, or class..." value="{{ request('search') }}">
        <button type="submit" class="text-zinc-500 px-4 py-2 rounded-r-md flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a5 5 0 11-10 0 5 5 0 0110 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
            </svg>
        </button>
        <a href="{{ route('counsellor.intervention') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Clear</a>
    </form>

    <div class="mb-4 text-center">
            <span class="inline-block bg-green-50 px-3 py-1 rounded text-green-800 font-medium">Second Passed</span>
            <span class="inline-block bg-red-50 px-3 py-1 rounded text-red-800 font-medium">Second Intervention</span>
            <span class="inline-block bg-white px-3 py-1 rounded text-gray-800 border border-gray-300 font-medium">Second Assessment Pending</span>
    </div>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">IC</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date Submitted</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">D</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">A</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">S</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Intervention</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Allow Second Assessment</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($interventionStudents as $index => $student)
                <tr class="@if($student->round2_status == 1) bg-green-50 @elseif($student->round2_status == 2) bg-red-50 @endif">
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->name }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->ic }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $student->class }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-900 whitespace-pre">{{ \Carbon\Carbon::parse($student->created_at)->format('d M Y') . "\n" . \Carbon\Carbon::parse($student->created_at)->format('g:i A') }}</td>
                    <td class="px-6 py-4 text-center text-sm @if($student->marks_d >= 8) text-red-600 @else text-gray-900 @endif">{{ $student->marks_d }}</td>
                    <td class="px-6 py-4 text-center text-sm @if($student->marks_a >= 7) text-red-600 @else text-gray-900 @endif">{{ $student->marks_a }}</td>
                    <td class="px-6 py-4 text-center text-sm @if($student->marks_s >= 10) text-red-600 @else text-gray-900 @endif">{{ $student->marks_s }}</td>
                    <td class="px-6 py-4 text-center relative">
                        <div class="flex items-center gap-2">
                            <div id="datetime-display-{{ $index }}" class="flex-1 cursor-default overflow-hidden whitespace-nowrap text-ellipsis">{{ $student->intervention_appt ? \Carbon\Carbon::parse($student->intervention_appt)->format('d M Y g:i A') : 'Pick date & time' }}</div>
                            <input type="text" id="datetime-input-{{ $index }}" class="absolute opacity-0 pointer-events-none" data-student-ic="{{ $student->ic }}" />
                            <span class="cursor-pointer" onclick="openPicker({{ $index }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-calendar-clock text-blue-600"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <input type="checkbox" name="sec_assessment_approval" class="h-5 w-5 text-blue-600" data-student-ic="{{ $student->ic }}" {{ $student->sec_assessment_approval ? 'checked' : '' }} />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    function openPicker(index) {
        const input = document.getElementById('datetime-input-' + index);
        input._flatpickr.open();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.absolute.opacity-0.pointer-events-none').forEach(function(input, index) {
            flatpickr(input, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minuteIncrement: 30,
                minDate: "today", // Disable past dates
                disable: [
                    function(date) {
                        // Disable weekends
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ],
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        let studentIc = instance.element.getAttribute('data-student-ic');
                        let localDate = selectedDates[0];
                        let interventionDate = new Date(localDate.getTime() - localDate.getTimezoneOffset() * 60000).toISOString().slice(0, 19).replace('T', ' ');
                        let formattedDate = localDate.toLocaleString('en-GB', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
                        formattedDate = formattedDate.replace(/am|pm/i, function(match) {
                            return match.toUpperCase();
                        });
                        document.getElementById('datetime-display-' + index).innerText = formattedDate;

                        fetch('/counsellor/update-intervention-date', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ic: studentIc,
                                intervention_appt: interventionDate
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error updating intervention date.');
                        });
                    }
                }
            });
        });

        document.querySelectorAll('input[name="sec_assessment_approval"]').forEach(function(input) {
            input.addEventListener('change', function() {
                let studentIc = this.getAttribute('data-student-ic');
                let secAssessmentApproval = this.checked ? 1 : 0;

                fetch('/counsellor/update-allow-second-assessment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ic: studentIc,
                        sec_assessment_approval: secAssessmentApproval
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating allow second assessment.');
                });
            });
        });
    });
</script>
