<?php
use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email from tinker script', function($msg) {
        $msg->to('admin@mysipma.com')->subject('Test Delivery');
    });
    echo "Mail sending attempt completed without exceptions.\n";
} catch (\Exception $e) {
    echo "Exception caught:\n";
    echo $e->getMessage() . "\n";
}
