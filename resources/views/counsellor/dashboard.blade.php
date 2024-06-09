@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg shadow-md p-6">
            <div class="border-b pb-2 mb-2 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Dashboard</h2>
            </div>
            <div class="p-2">
                @if(Session::has('message'))
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow-sm">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                <!-- Row for Chart -->
                <div class="col-span-1 md:col-span-3 mb-6">
                    <div id="chart"></div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Row 1 -->
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Total Students</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Assessed Students</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalAssessedStudents }}</p> 
                                <p class="text-l font-bold text-gray-400">({{ round(($totalAssessedStudents / $totalStudents) * 100, 2) }}%)</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ ($totalAssessedStudents / $totalStudents) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Unanswered Students</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $unansweredStudents }}</p>
                                <p class="text-l font-bold text-gray-400">({{ round(($unansweredStudents / $totalStudents) * 100, 2) }}%)</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ ($unansweredStudents / $totalStudents) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Pending Intervention Appointment</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $pendingInterventionAppointment }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Pending Second Assessment</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $pendingSecondAssessment }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-lg p-4 shadow-md flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Students Second Intervention</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $studentsSecondIntervention }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var options = {
        series: [{
            name: 'Total Students Affected',
            data: [{{ $totalDepression }}, {{ $totalAnxiety }}, {{ $totalStress }}]
        }, {
            name: 'Total Students Recovered',
            data: [{{ $totalDepressionSettled }}, {{ $totalAnxietySettled }}, {{ $totalStressSettled }}]
        }],
        chart: {
            type: 'bar',
            height: 300
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Depression', 'Anxiety', 'Stress'],
        },
        yaxis: {
            title: {
                text: 'Number of Students'
            }
        },
        fill: {
            opacity: 1,
        },
        colors: ['#FFDB58', '#36A2EB'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        },
        legend: {
            markers: {
                fillColors: ['#FFDB58', '#36A2EB']
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
});
</script>
