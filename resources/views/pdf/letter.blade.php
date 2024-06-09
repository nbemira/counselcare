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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
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
            <p><strong>Assigned Psychologist for {{ $student->name }}</strong></p>
            <p></p>
            <p class="justified">We are writing to inform you that a psychologist has been assigned to assist {{ $student->name }} with their intervention. Please find the details of the assigned psychologist below:</p>
            <p></p>
            <table>
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
            <p class="justified">Please do not hesitate to reach out to us if you have any questions or concerns. Together, we can create a positive and supportive environment for {{ $student->name }} to thrive.</p>
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
