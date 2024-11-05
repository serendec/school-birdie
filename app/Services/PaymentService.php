<?php
namespace App\Services;

use DateTime;
use Stripe\StripeClient;

class PaymentService
{
    protected $stripe;

    public function __construct($schoolId)
    {
        $stripeSettings = config("services.stripe")[$schoolId];
        $this->stripe = new StripeClient($stripeSettings['secret_key']);
    }

    public function createSubscription($user, $stripePlanId, $paymentToken)
    {
        // Create a new customer in Stripe
        $customer = $this->stripe->customers->create([
            'name'  => $user['family_name'].' '.$user['first_name'],
            'phone' => $user['tel'],
            'email' => $user['email'],
            'metadata' => [
                'user_id' => $user['id']
            ],
        ]);

        // 支払い方法を顧客にアタッチ
        $this->stripe->paymentMethods->attach(
            $paymentToken,
            ['customer' => $customer->id]
        );

        // 顧客のデフォルト支払い方法を設定
        $this->stripe->customers->update($customer->id, [
            'invoice_settings' => [
                'default_payment_method' => $paymentToken,
            ],
        ]);

        // サブスクリプションを作成（月末までで日割り計算）
        // $endOfMonth = strtotime('last day of this month 23:59:59');
        // $subscription = $this->stripe->subscriptions->create([
        //     'customer' => $customer->id,
        //     'items' => [
        //         ['plan' => $stripePlanId]
        //     ],
        //     'billing_cycle_anchor' => $endOfMonth,
        //     'proration_behavior' => 'create_prorations'
        // ]);

        // 翌月分からサブスク開始（月末まではトライアル扱い）
        $endOfMonth = new DateTime('last day of this month 23:59:59');
        $endOfMonthTimestamp = $endOfMonth->getTimestamp();
        $subscription = $this->stripe->subscriptions->create([
            'customer' => $customer->id,
            'items' => [
                ['plan' => $stripePlanId]
            ],
            'billing_cycle_anchor' => $endOfMonthTimestamp,
            'trial_end' => $endOfMonthTimestamp,
            'payment_behavior' => 'error_if_incomplete',
            'off_session' => true
        ]);
        return $subscription;
    }
}
