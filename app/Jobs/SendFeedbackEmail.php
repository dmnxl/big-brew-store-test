<?php

namespace App\Jobs;

use App\Mail\FeedbackMail;
use App\Mail\SendMailTicket;
use App\Mail\SendMailTicketAssigned;
use App\Mail\SendMailTicketLink;
use App\Mail\SendMailTicketPause;
use App\Mail\SendMailTicketQueue;
use App\Mail\SendMailTicketTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendFeedbackEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $EmailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $EmailData)
    {
        $this->EmailData = $EmailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->EmailData['Status_id'] == 0) {
                Mail::to($this->EmailData['email'])->send(new SendMailTicketLink($this->EmailData));
            } else if ($this->EmailData['Status_id'] == 4) {
                if ($this->EmailData['transfer'] == 1) {
                    Mail::to($this->EmailData['assignUserEmail'])->send(new SendMailTicketTransfer($this->EmailData));
                } else {
                    Mail::to($this->EmailData['email'])->send(new SendMailTicketQueue($this->EmailData));
                    Mail::to($this->EmailData['assignUserEmail'])->send(new SendMailTicketAssigned($this->EmailData));
                }
            } else if ($this->EmailData['Status_id'] == 2) {
                Mail::to($this->EmailData['email'])->send(new FeedbackMail($this->EmailData));
            } else if ($this->EmailData['Status_id'] == 1) {
                Mail::to($this->EmailData['assignUserEmail'])->send(new SendMailTicketTransfer($this->EmailData));
            } else if ($this->EmailData['Status_id'] == 3) {
                Mail::to($this->EmailData['email'])->send(new SendMailTicketPause($this->EmailData));
            } else {
                Log::info("Failed Send");
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error("Failed to send email: " . $e->getMessage());

        }
    }
}
