<?php
namespace App\Services;

use Illuminate\Support\Str;

class FundiinService
{
    public function execPostRequest($url, $data, $clientId, $secretKey)
    {
        // Generate headers
        $requestTime = now()->format('c');
        $idempotencyKey = Str::uuid()->toString();

        // Ensure JSON encoding is consistent
        $jsonData = json_encode($data);
        $signature = bin2hex(
            hash_hmac("sha256", $jsonData, $secretKey, true)
        );

        $headers = [
            'Content-Type: application/json; charset=UTF-8',
            'Request-Time: ' . $requestTime,
            'Client-Id: ' . $clientId,
            'Signature: ' . $signature,
            'Idempotency-Key: ' . $idempotencyKey,
            'Content-Length: ' . strlen($jsonData)
        ];

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        // Execute cURL request
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
