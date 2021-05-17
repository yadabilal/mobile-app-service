<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CheckSubscriptionResource;
use App\Http\Resources\PurchaseSubscriptionResource;
use App\Models\Device;
use App\Models\Subscription;
use App\Traits\VerifyTrait;
use App\Http\Requests\CheckSubscriptionRequest;
use App\Http\Requests\PurchaseSubscriptionRequest;
use Symfony\Component\HttpFoundation\Response;


class SubscriptionController extends ApiController
{
    use VerifyTrait;

    /**
     * @param PurchaseSubscriptionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function purchase(PurchaseSubscriptionRequest $request)
    {
        $request->validated();

        $hash = $request->receipt;
        $clientToken = $request->client_token;
        $expireDate = $request->expire_date;

        $device = Device::where("client_token", $clientToken)->first();

        if(!$device) {
            return \response([ 'data' => ['message' => 'Geçersiz token.']],Response::HTTP_BAD_REQUEST);
        }

        $response = $this->verification($device, $hash);

        if (!$response ['verified']) {
            return \response([ 'data' => ['message' => 'Doğrulama başarısız.']],Response::HTTP_BAD_REQUEST);
        }

        $subscription = Subscription::where("device_id", $device->id)->first();

        if (!$subscription) {

            $data = [ 'device_id' => $device->id, 'expire_date' => $expireDate];
            $subscription = Subscription::create($data);

            return \response([ 'data' => new PurchaseSubscriptionResource($subscription) ],Response::HTTP_OK);

        } else {
            return \response([ 'data' => ['message' => 'Cihaz zaten kayıtlı.']],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @param CheckSubscriptionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function check(CheckSubscriptionRequest $request)
    {
        $request->validated();

        $clientToken = $request->client_token;

        $device = Device::where("client_token", $clientToken)->first();

        if(!$device) {
            return \response([ 'data' => ['message' => 'Geçersiz token.']],Response::HTTP_BAD_REQUEST);
        }

        $subscription = $device->subscription;

        if ($subscription) {
            return \response([ 'data' => new CheckSubscriptionResource($subscription) ],Response::HTTP_OK);
        }

        return \response([ 'data' => ['message' => 'Hay aksi! Bir şeyler ters gitti.']],Response::HTTP_BAD_REQUEST);
    }
}


