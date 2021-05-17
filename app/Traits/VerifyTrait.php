<?php

namespace App\Traits;

use App\Models\Device;
use App\Models\Log;
use App\Models\Subscription;
use GuzzleHttp\Client;

trait VerifyTrait
{
    /**
     * @param $device
     * @param $hash
     * @throws mixed
     */
    public function verification($device, $hash)
    {
        $client = new Client(['base_uri' => env("APP_URL", "http://localhost")]);
        $os = $device->operating_system ?? Device::OPERATING_TYPE_GOOGLE;

        $headers = [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Authentication' => "Basic testuser:testpassword"
            ],
        ];

        $params = [ 'operating_type' => $os, 'hash' => $hash];
        $response = $client->request('POST', 'api/verification',[ $headers, 'form_params' => $params ]);

        $responseData = $response->getBody()->getContents();
        $responseData = json_decode($responseData, true);

        $subscription = Subscription::where("device_id", $device->id)->first();

        if($subscription) {

            $logData['status'] = $responseData['verified'] ? Subscription::STATUS_SUCCESS : Subscription::STATUS_ERROR;
            $logData['subscription_id'] = $subscription->id;
            Log::create($logData);

        }


        return $responseData['verified'];
    }

}
