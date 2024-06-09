@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded shadow p-6">
            <div class="border-b pb-4 mb-6">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </div>

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

            <h2 class="text-xl font-semibold text-center mb-6">Result</h2>
            <div class="flex justify-center gap-4 mb-6">
                @foreach(['Depression' => 'from-blue-200 to-blue-400', 'Anxiety' => 'from-yellow-200 to-yellow-400', 'Stress' => 'from-pink-200 to-pink-400'] as $category => $gradient)
                    <div class="result-card bg-gradient-to-r {{ $gradient }} border-{{ explode('-', $gradient)[1] }}-300 rounded p-6 text-center flex-1 transform transition-transform duration-500 hover:scale-105 hover:shadow-3xl">
                        <h3 class="font-semibold mb-2 text-gray-900">{{ $category }}</h3>
                        <hr class="mb-2 border-gray-900">
                        @php
                            $weightage = $categoryWeightages->firstWhere('category', $category);
                        @endphp
                        <p class="text-lg text-gray-900">
                            {{ $weightage ? $weightage->severity : 'N/A' }}
                        </p>
                        <p class="text-blue-gray">Risk</p>
                    </div>
                @endforeach
            </div>

            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white rounded-lg overflow-hidden border border-gray-200 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b text-center w-1/3">Category</th>
                            <th class="py-2 px-4 border-b text-center w-1/3">Total Score</th>
                            <th class="py-2 px-4 border-b text-center w-1/3">Severity Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryWeightages as $weightage)
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-4 text-center">{{ $weightage->category }}</td>
                                <td class="py-3 px-4 text-center">{{ $weightage->total_weightage }}</td>
                                <td class="py-3 px-4 text-center">{{ $weightage->severity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="my-8">

            <h2 class="text-xl font-semibold text-center mb-6">Screening Score Reference</h2>
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white rounded-lg overflow-hidden border border-gray-200 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b text-center w-1/6">Category</th>
                            <th class="py-2 px-4 border-b text-center w-1/6">Normal</th>
                            <th class="py-2 px-4 border-b text-center w-1/6">Mild</th>
                            <th class="py-2 px-4 border-b text-center w-1/6">Moderate</th>
                            <th class="py-2 px-4 border-b text-center w-1/6">Severe</th>
                            <th class="py-2 px-4 border-b text-center w-1/6">Very Severe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['Depression', [0, 5], [6, 7], [8, 10], [11, 14], [15, '+']],
                            ['Anxiety', [0, 4], [5, 6], [7, 8], [9, 10], [11, '+']],
                            ['Stress', [0, 7], [8, 9], [10, 13], [14, 17], [18, '+']]
                        ] as $data)
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-4 text-center">{{ $data[0] }}</td>
                                @foreach(array_slice($data, 1) as $index => $range)
                                    <td class="py-3 px-4 text-center">
                                        @if($index == 4)
                                            {{ $range[0] }}+
                                        @else
                                            {{ $range[0] }} - {{ $range[1] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .result-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .result-card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
    }
    .hover:shadow-3xl {
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
