<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VerificationRequest;
use App\Models\Device;
use App\Traits\GoogleVerifyTrait;
use App\Traits\IosVerifyTrait;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends ApiController
{
    use GoogleVerifyTrait, IosVerifyTrait;

    /**
     * @param VerificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function verify(VerificationRequest $request)
    {
        $request->validated();

        $os = $request->operating_system;
        $hash = $request->hash;
        $state = false;

        if($os == Device::OPERATING_TYPE_GOOGLE) {
            $state = $this->googleVerify($hash);
        }else if($os == Device::OPERATING_TYPE_IOS) {
            $state = $this->iosVerify($hash);
        }

        return \response([ 'data' => ['verified' => $state]],Response::HTTP_OK);

    }
}


