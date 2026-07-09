
<?php
use Illuminate\Support\Facades\Mail;

try {
    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'This is a test message body.'
    ];
    $mail = new \App\Mail\ContactMail($data);
    $mail->render();
    echo "Mailable render attempt completed without exceptions.\n";
} catch (\Exception $e) {
    echo "Exception caught:\n";
    echo $e->getMessage() . "\n";
}
