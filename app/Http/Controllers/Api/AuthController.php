<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends ApiController
{
    /**
     * @param DeviceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(DeviceRequest $request)
    {
        $request->validated();

        $data  = $request->all();
        $appId = $request->app_id;
        $uid = $request->uid;

        $device = Device::where("uid", $uid)->where("app_id", $appId)->first();

        if (!$device) {

            $device = Device::create($data);

        } else {
            $device->update($data);
        }

        return \response([ 'data' => new DeviceResource($device) ],Response::HTTP_CREATED);
    }

}


