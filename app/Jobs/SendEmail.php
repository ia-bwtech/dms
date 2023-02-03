<?php
namespace App\Jobs;

use App\Mail\BulkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EmailForQueuing;
use App\Mail\NewRegistration;
use App\Mail\RegistrationAlert;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$data)
    {
        $this->details = $details;
        $this->data = $data;

    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails=$this->details;
        foreach($emails as $email){
            dd($emails);
            Mail::to($email)->send(new BulkMail($this->data));

        }
    }
}
