<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class InterventionAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $appointmentDate;
    public $appointmentTime;
    public $counsellorName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($studentName, $appointmentDate, $counsellorName)
    {
        $this->studentName = $studentName;
        $this->appointmentDate = Carbon::parse($appointmentDate)->format('l, d F Y');
        $this->appointmentTime = Carbon::parse($appointmentDate)->format('h:i A');
        $this->counsellorName = $counsellorName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.intervention_appointment')
                    ->with([
                        'studentName' => $this->studentName,
                        'appointmentDate' => $this->appointmentDate,
                        'appointmentTime' => $this->appointmentTime,
                        'counsellorName' => $this->counsellorName,
                    ]);
    }
}
