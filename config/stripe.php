<?php

return [
    'status' => [
        'draft' => '下書き',
        'open' => '未支払い',
        'paid' => '支払い済み',
        'uncollectible' => '回収不能',
        'void' => '無効',
    ],
    'billing_reason' => [
        'subscription_create' => 'サブスクリプション作成',
        'subscription_cycle' => 'サブスクリプションサイクル',
        'subscription_update' => 'サブスクリプション更新',
        'subscription' => 'サブスクリプション',
        'manual' => '手動',
        'upcoming' => '今後の請求',
        'subscription_threshold' => 'サブスクリプションしきい値',
        'invoice_over_threshold' => 'しきい値超え請求',
    ],
    'frequency' => [
        'month' => '毎月',
        'year' => '毎年',
    ],
];
