<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiringOrganizationMail;
use App\Mail\SubscriptionExpiringAdminMail;
use Carbon\Carbon;

class CheckExpiringSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for subscriptions expiring in 3 days and send alerts.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find subscriptions expiring exactly 3 days from today
        $targetDate = Carbon::now()->addDays(3)->toDateString();
        
        $expiringSubscriptions = Subscription::with('user')
            ->whereIn('status', ['active', 'active_trial']) // Checking common active statuses, you might need to adjust based on your app's exact status strings
            ->whereDate('expires_at', $targetDate)
            ->get();

        foreach ($expiringSubscriptions as $subscription) {
            $user = $subscription->user;
            
            if ($user) {
                try {
                    // Send to Organization
                    Mail::to($user->email)->send(new SubscriptionExpiringOrganizationMail($subscription, $user));
                    
                    // Send to Admin
                    Mail::to('sumatra.sales2424@gmail.com')->send(new SubscriptionExpiringAdminMail($subscription, $user));
                    
                    $this->info("Alert sent for subscription ID: {$subscription->id} for user {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send alert for subscription ID: {$subscription->id}. Error: " . $e->getMessage());
                }
            }
        }
        
        $this->info('Completed checking expiring subscriptions.');
    }
}
