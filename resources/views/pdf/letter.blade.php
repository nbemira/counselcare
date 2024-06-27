<!DOCTYPE html>
<html>
<head>
    <title>{{ $student->name }} Intervention Letter</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 5mm 10mm; /* Reduced top and bottom margins */
        }
        .header {
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .content {
            margin: 10px 0;
        }
        .letter {
            margin-left: 20px;
            margin-right: 20px;
        }
        .logo {
            width: 130px; /* Adjust logo size */
            height: auto;
            margin: 0;
            padding: 0;
        }
        .justified {
            text-align: justify;
        }
        table.visible-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.visible-table th, table.visible-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        table.visible-table th {
            text-align: center; /* Center-align the text in headers */
        }
        table.visible-table td {
            text-align: center; /* Center-align the text in all cells by default */
        }
        table.visible-table td:first-child {
            text-align: left; /* Left-align the text in the first column */
        }
        table.hidden-table {
            width: 100%;
            margin-bottom: 20px;
        }
        table.hidden-table td {
            padding: 5px;
            text-align: left;
            border: none;
        }
        .label {
            width: 30%;
            vertical-align: top;
            text-align: left;
            padding-right: 5px;
            padding-left: 10px; /* Indent labels */
        }
        .colon {
            width: 5%;
            vertical-align: top;
            text-align: center;
        }
        .value {
            width: 65%;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Page Break CSS */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logosmsm.png') }}" alt="Logo" class="logo">
    </div>
    <div class="content">
        <div class="letter">
            <p>SM Stella Maris Counselling Unit</p>
            <p>Tanjung Aru, 88100</p>
            <p>Kota Kinabalu, Sabah</p>
            <p></p>
            <p>{{ $date }}</p>
        </div>
        <div class="letter">
            <p>Dear Parents/Guardians,</p>
            <p></p>
            <p class="justified">We are writing to inform you that {{ $student->name }}'s assessment results from the first and second rounds have raised concerns, prompting us to take this step to ensure her well-being. Hence, a psychologist has been assigned to assist {{ $student->name }} with their mental health. Please find the details of her assessment marks, the counsellor’s note to the psychologist, and the details of the assigned psychologist below:</p>
            <p></p>
            <p class="justified"><strong>Screening Score Reference:</strong></p>
            <table class="visible-table">
                <tr>
                    <th>Category</th>
                    <th>Normal</th>
                    <th>Mild</th>
                    <th>Moderate</th>
                    <th>Severe</th>
                    <th>Very Severe</th>
                </tr>
                <tr>
                    <td><strong>Depression</strong></td>
                    <td>0 - 5</td>
                    <td>6 - 7</td>
                    <td>8 - 10</td>
                    <td>11 - 14</td>
                    <td>15+</td>
                </tr>
                <tr>
                    <td><strong>Anxiety</strong></td>
                    <td>0 - 4</td>
                    <td>5 - 6</td>
                    <td>7 - 8</td>
                    <td>9 - 10</td>
                    <td>11+</td>
                </tr>
                <tr>
                    <td><strong>Stress</strong></td>
                    <td>0 - 7</td>
                    <td>8 - 9</td>
                    <td>10 - 13</td>
                    <td>14 - 17</td>
                    <td>18+</td>
                </tr>
            </table>
            <p></p>
            <p class="justified"><strong>{{ $student->name }}'s Assessment Marks:</strong></p>
            <table class="visible-table">
                <tr>
                    <th>Assessment Round</th>
                    <th>Depression Marks</th>
                    <th>Anxiety Marks</th>
                    <th>Stress Marks</th>
                </tr>
                <tr>
                    <td><strong>First Assessment</strong></td>
                    <td>{{ $firstAssessment->first_marks_d ?? 'N/A' }}</td>
                    <td>{{ $firstAssessment->first_marks_a ?? 'N/A' }}</td>
                    <td>{{ $firstAssessment->first_marks_s ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Second Assessment</strong></td>
                    <td>{{ $secondAssessment->second_marks_d ?? 'N/A' }}</td>
                    <td>{{ $secondAssessment->second_marks_a ?? 'N/A' }}</td>
                    <td>{{ $secondAssessment->second_marks_s ?? 'N/A' }}</td>
                </tr>
            </table>
            <div class="page-break"></div>
            <p><strong>Counsellor's Note from First Intervention Appointment to Psychologist:</strong></p>
            @if($customMessage)
                <p class="justified">{{ $customMessage }}</p>
            @endif
            <p></p>
            <p><strong>Assigned Psychologist for {{ $student->name }}</strong></p>
            <table class="hidden-table">
                @if($psychologist->name)
                    <tr>
                        <td class="label">Psychologist</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->name }}</td>
                    </tr>
                @endif
                @if($psychologist->qualifications)
                    <tr>
                        <td class="label">Qualifications</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->qualifications }}</td>
                    </tr>
                @endif
                @if($psychologist->specialization)
                    <tr>
                        <td class="label">Specialization</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->specialization }}</td>
                    </tr>
                @endif
                @if($psychologist->email)
                    <tr>
                        <td class="label">Email</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->email }}</td>
                    </tr>
                @endif
                @if($psychologist->phone)
                    <tr>
                        <td class="label">Phone</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->phone }}</td>
                    </tr>
                @endif
                @if($psychologist->location)
                    <tr>
                        <td class="label">Location</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->location }}</td>
                    </tr>
                @endif
                @if($psychologist->availability)
                    <tr>
                        <td class="label">Availability</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $psychologist->availability }}</td>
                    </tr>
                @endif
            </table>
            <p></p>
            <p class="justified">Kindly contact the psychologist to arrange {{ $student->name }}'s first session. We understand this may feel overwhelming, but our team is here to support you and {{ $student->name }} every step of the way. Our goal is to ensure the well-being and success of all our students.</p>
            <p></p>
            <p class="justified">Please do not hesitate to reach out to us if you have any questions or concerns. Together, we can create a positive and supportive environment for {{ $student->name }}.</p>
            <p></p>
            <p>Best regards,</p>
            <p>Teacher {{ $counsellor->name }}</p>
            <p>SM Stella Maris Counselling Unit</p>
        </div>
    </div>
    <div class="footer">
    </div>
</body>
</html>
