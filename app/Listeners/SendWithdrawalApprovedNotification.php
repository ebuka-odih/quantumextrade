<?php

namespace App\Listeners;

use App\Events\WithdrawalApproved;
use App\Services\NotificationService;

class SendWithdrawalApprovedNotification
{
    protected NotificationService $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalApproved $event): void
    {
        // Create notification for the user whose withdrawal was approved
        $this->notificationService->createNotification(
            $event->user,
            'withdrawal_approved',
            'Withdrawal Approved',
            "Your withdrawal request of $" . number_format($event->amount, 2) . " has been approved and will be processed within 24-48 hours.",
            [
                'amount' => $event->amount,
                'payment_method' => $event->paymentMethod,
                'from_account' => $event->fromAccount,
                'withdrawal_id' => $event->withdrawal->id,
                'status' => 'approved',
                'type' => 'withdrawal_approved'
            ]
        );

        // Log the approval for admin tracking
        \Log::info('Withdrawal approved', [
            'user_id' => $event->user->id,
            'amount' => $event->amount,
            'payment_method' => $event->paymentMethod,
            'from_account' => $event->fromAccount,
            'withdrawal_id' => $event->withdrawal->id
        ]);
    }
}
