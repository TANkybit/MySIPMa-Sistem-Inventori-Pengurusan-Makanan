<?php

namespace App\Services;

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;

class GmailService
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $refreshToken;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 30]);
        $this->clientId = env('GMAIL_CLIENT_ID');
        $this->clientSecret = env('GMAIL_CLIENT_SECRET');
        $this->refreshToken = env('GMAIL_REFRESH_TOKEN');
    }

    public function isConfigured(): bool
    {
        return !empty($this->clientId) && !empty($this->clientSecret) && !empty($this->refreshToken);
    }

    public function sendEmail(string $to, string $subject, string $htmlBody): array
    {
        $accessToken = $this->getAccessToken();
        $mimeMessage = $this->buildMimeMessage($to, $subject, $htmlBody);

        $response = $this->client->post('https://gmail.googleapis.com/gmail/v1/users/me/messages/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'raw' => strtr(base64_encode($mimeMessage), '+/', '-_'),
            ],
        ]);

        $body = (string) $response->getBody();
        $result = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Gmail API returned invalid JSON: ' . $body);
        }

        return $result;
    }

    private function getAccessToken(): string
    {
        $response = $this->client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => $this->refreshToken,
                'grant_type' => 'refresh_token',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        if (isset($data['error'])) {
            throw new \RuntimeException('OAuth error: ' . ($data['error_description'] ?? $data['error']));
        }

        return $data['access_token'];
    }

    private function buildMimeMessage(string $to, string $subject, string $htmlBody): string
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('mysipma@gmail.com', 'Sistem MySIPMa');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->preSend();
        return $mail->getSentMIMEMessage();
    }
}
