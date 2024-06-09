<!DOCTYPE html>
<html>
<head>
    <title>Intervention Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #3d4852;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: #f8fafc;
        }
        .content {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .content p {
            text-align: left;
        }
        .header {
            background-color: #f8fafc;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 12px;
            text-align: center;
        }
        .button {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CounselCare</h1>
        </div>
        <div class="content">
            <h1 style="text-align: center;">Intervention Appointment Scheduled</h1>
            <p>Dear {{ $studentName }},</p>
            <p>We hope you're doing well! We wanted to let you know that you have an <strong>intervention appointment</strong> in the <strong>counseling room</strong> scheduled on:</p>
            <p><strong>Date: {{ $appointmentDate }}</strong></p>
            <p><strong>Time: {{ $appointmentTime }}</strong></p>
            <p>We're here to support you, so please make sure to come on time. If you have any questions or need to reschedule, feel free to reach out to us.</p>
            <p>Looking forward to seeing you then!</p>
            <p>Best regards,<br>Teacher {{ $counsellorName }}<br>SM Stella Maris Counselling Unit</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CounselCare. All rights reserved.
        </div>
    </div>
</body>
</html>
