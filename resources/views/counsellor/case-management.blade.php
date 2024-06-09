@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg shadow p-6">
            <div class="border-b pb-4 mb-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Case Management</h2>
                <a href="{{ route('counsellor.screening-score-reference') }}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Screening Score Reference</a>
            </div>
            <ul class="flex space-x-6 mt-4">
                <li class="relative group">
                    <a href="{{ route('counsellor.unanswered') }}" class="flex items-center space-x-2 px-4 py-2 rounded-md @if(Request::route()->getName() == 'counsellor.unanswered') bg-blue-100 text-blue-600 font-semibold @else text-gray-600 bg-gray-100 hover:bg-gray-200 @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-unknown"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/><path d="M12 17v.01"/><path d="M12 14a1.5 1.5 0 1 0 -1.14 -2.474"/></svg>
                        <span>Unanswered</span>
                    </a>
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </li>
                <li class="relative group">
                    <a href="{{ route('counsellor.passed') }}" class="flex items-center space-x-2 px-4 py-2 rounded-md @if(Request::route()->getName() == 'counsellor.passed') bg-blue-100 text-blue-600 font-semibold @else text-gray-600 bg-gray-100 hover:bg-gray-200 @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                        <span>Passed</span>
                    </a>
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </li>
                <li class="relative group">
                    <a href="{{ route('counsellor.intervention') }}" class="flex items-center space-x-2 px-4 py-2 rounded-md @if(Request::route()->getName() == 'counsellor.intervention') bg-blue-100 text-blue-600 font-semibold @else text-gray-600 bg-gray-100 hover:bg-gray-200 @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-heart-handshake"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/><path d="M12 6l-3.293 3.293a1 1 0 0 0 0 1.414l.543 .543c.69 .69 1.81 .69 2.5 0l1 -1a3.182 3.182 0 0 1 4.5 0l2.25 2.25"/><path d="M12.5 15.5l2 2"/><path d="M15 13l2 2"/></svg>
                        <span>Intervention</span>
                    </a>
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </li>
                <li class="relative group">
                    <a href="{{ route('counsellor.secondPassed') }}" class="flex items-center space-x-2 px-4 py-2 rounded-md @if(Request::route()->getName() == 'counsellor.secondPassed') bg-blue-100 text-blue-600 font-semibold @else text-gray-600 bg-gray-100 hover:bg-gray-200 @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10"/><path d="M2 12l5 5m5 -5l5 -5"/></svg>
                        <span>Second Passed</span>
                    </a>
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </li>
                <li class="relative group">
                    <a href="{{ route('counsellor.secondIntervention') }}" class="flex items-center space-x-2 px-4 py-2 rounded-md @if(Request::route()->getName() == 'counsellor.secondIntervention') bg-blue-100 text-blue-600 font-semibold @else text-gray-600 bg-gray-100 hover:bg-gray-200 @endif">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                        <span>Second Intervention</span>
                    </a>
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </li>
            </ul>
            @yield('nested-content')
        </div>
    </div>
</div>
@endsection
