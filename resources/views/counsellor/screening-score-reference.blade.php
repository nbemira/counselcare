@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg shadow p-6">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-xl font-semibold text-center mb-6">Screening Score Reference</h2>
            </div>
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
                        <tr class="border-b border-gray-200 @if(strtolower($data[0]) == 'depression') bg-blue-50 @elseif(strtolower($data[0]) == 'anxiety') bg-yellow-50 @elseif(strtolower($data[0]) == 'stress') bg-pink-50 @endif">
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
@endsection