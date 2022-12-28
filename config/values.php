<?php

return [
    'stripe_test' => env('STRIPE_SECRET_TEST'),
    'stripe_test_publishable' => env('STRIPE_PUBLISH_TEST'),
    'stripe_live' => env('STRIPE_SECRET_LIVE'),
    'stripe_live_publishable' => env('STRIPE_PUBLISH_LIVE'),
];