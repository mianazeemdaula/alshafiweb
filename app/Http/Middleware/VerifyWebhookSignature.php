<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $courier = null)
    {
        // Skip verification in local environment for testing
        if (app()->environment('local')) {
            return $next($request);
        }

        $signature = $request->header('X-Webhook-Signature') ?? $request->header('Signature');
        $payload = $request->getContent();

        if (!$signature || !$payload) {
            Log::warning('Webhook signature verification failed: Missing signature or payload');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized webhook request'
            ], 401);
        }

        // Get the webhook secret based on courier
        $secret = $this->getWebhookSecret($courier);
        
        if (!$secret) {
            Log::warning("Webhook secret not configured for courier: {$courier}");
            return response()->json([
                'success' => false,
                'message' => 'Webhook configuration error'
            ], 500);
        }

        // Verify signature
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        
        if (!hash_equals($signature, $expectedSignature)) {
            Log::warning('Webhook signature verification failed', [
                'courier' => $courier,
                'provided_signature' => $signature,
                'expected_signature' => $expectedSignature
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature'
            ], 401);
        }

        return $next($request);
    }

    /**
     * Get webhook secret for specific courier
     */
    private function getWebhookSecret($courier)
    {
        $secrets = [
            'trax' => config('services.trax.webhook_secret'),
            'tcs' => config('services.tcs.webhook_secret'),
            'leopards' => config('services.leopards.webhook_secret'),
        ];

        return $secrets[$courier] ?? null;
    }
}