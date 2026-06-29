<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function send(Request $request) {
        // Log the incoming request
        \Log::info('Contact form submission received');
        \Log::info('Request data: ', $request->all());
        
        // Validate reCAPTCHA token first
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|string',
        ]);

        // Check if email domain has valid MX records
        $domain = substr(strrchr($data['email'], '@'), 1);
        if (!$domain || !checkdnsrr($domain, 'MX')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Alamat emel tidak wujud atau domain tidak sah.', 422);
            }
            return back()->with('error', 'Alamat emel tidak wujud atau domain tidak sah.');
        }

        \Log::info('Form data validated', ['name' => $data['name'], 'email' => $data['email']]);
        \Log::info('reCAPTCHA token received: ' . substr($data['g-recaptcha-response'], 0, 20) . '...');

        // Verify reCAPTCHA token with Google
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $data['g-recaptcha-response'],
        ]);

        $recaptchaResult = $recaptchaResponse->json();
        
        // Log the response for debugging
        \Log::info('reCAPTCHA Response:', $recaptchaResult);

        // Check if reCAPTCHA verification was successful (v2 only checks success flag)
        $success = $recaptchaResult['success'] ?? false;
        
        \Log::info('reCAPTCHA Check - Success: ' . ($success ? 'true' : 'false'));
        
        if (!$success) {
            \Log::warning('reCAPTCHA Failed: reCAPTCHA verification failed');
            
            if ($request->ajax() || $request->wantsJson()) {
                return response('reCAPTCHA verification failed. Please try again.', 422);
            }
            return back()->with('error', 'reCAPTCHA verification failed. Please try again.');
        }

        \Log::info('reCAPTCHA verification passed');

        // Remove the reCAPTCHA token from data before sending email
        unset($data['g-recaptcha-response']);

        try {
            Mail::to('admin@mysipma.com')->send(new \App\Mail\ContactMail($data));
        } catch (\Exception $e) {
            // Log the actual email error so we can debug it
            \Log::error('Email Delivery Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // For AJAX requests return error body so the frontend can show it
            if ($request->ajax() || $request->wantsJson()) {
                return response('Error: Pengeposan emel gagal (' . $e->getMessage() . ').', 500);
            }

            return back()->with('error', 'Gagal menghantar mesej. Sila cuba lagi.');
        }

        // The php-email-form JS expects a plain text "OK" response for success
        if ($request->ajax() || $request->wantsJson()) {
            return response('OK', 200);
        }

        return back()->with('success', 'Mesej berjaya dihantar!');
    }
}
