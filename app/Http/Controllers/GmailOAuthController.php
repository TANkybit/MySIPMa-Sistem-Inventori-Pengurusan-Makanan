<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GmailOAuthController extends Controller
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        $this->clientId = env('GMAIL_CLIENT_ID');
        $this->clientSecret = env('GMAIL_CLIENT_SECRET');
        $this->redirectUri = env('APP_URL') . '/gmail/oauth/callback';
    }

    public function redirect()
    {
        $state = bin2hex(random_bytes(16));
        Cache::put('gmail_oauth_state_' . $state, true, now()->addMinutes(10));

        $params = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/gmail.send',
            'access_type' => 'offline',
            'state' => $state,
            'prompt' => 'consent',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/auth?' . $params);
    }

    public function callback(Request $request)
    {
        if ($request->state) {
            $cached = Cache::pull('gmail_oauth_state_' . $request->state);
            if (!$cached) {
                return response('Invalid state parameter', 400);
            }
        }

        if ($request->error) {
            return response('Authorization denied: ' . $request->error, 400);
        }

        $code = $request->code;
        if (!$code) {
            return response('No authorization code received', 400);
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'grant_type' => 'authorization_code',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        if (isset($data['error'])) {
            return response('Token error: ' . ($data['error_description'] ?? $data['error']), 400);
        }

        $refreshToken = $data['refresh_token'] ?? null;

        if (!$refreshToken) {
            return response('No refresh token returned. Did you authorize with prompt=consent?', 400);
        }

        return response("
            <h2>OAuth Setup Complete</h2>
            <p>Add this to your <code>.env</code> file:</p>
            <pre>
GMAIL_CLIENT_ID={$this->clientId}
GMAIL_CLIENT_SECRET={$this->clientSecret}
GMAIL_REFRESH_TOKEN={$refreshToken}
            </pre>
            <p><strong>Important:</strong> Access token: {$data['access_token']} (expires in {$data['expires_in']}s)</p>
        ")->header('Content-Type', 'text/html');
    }
}
