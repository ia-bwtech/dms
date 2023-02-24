<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeactivateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $subscription) {
            $duration = $subscription->package->duration;
            if ($duration == 'monthly') {
                $duration = 30;
            }
            if ($duration == 'daily') {
                $duration = 1;
            }
            if ($duration == 'weekly') {
                $duration = 7;
            }
            $expiry_date = $subscription->created_at->addDays($duration);
            $current_date = Carbon::now();

            if ($current_date > $expiry_date) {
                Subscription::where('id', $subscription->id)->update(['status' => 0]);
            }
        }
        Log::info('Successfully Deactivated Subscriptions at ' . date('Y-m-d H:i:s A'));
    }
}
