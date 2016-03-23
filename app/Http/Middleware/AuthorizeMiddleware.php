<?php namespace App\Http\Middleware;

use Closure;
use DB;
use Config;
use App\Models\Api;
use App\Models\DeviceSession;
use App\Models\UserDevice;
/**
 * Middleware class to verify user access for
 * API requests.
 *
 */
class AuthorizeMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $accessToken = (array_key_exists('HTTP_X_TOKEN', $_SERVER)) ? $_SERVER['HTTP_X_TOKEN']:"";
        $accessDevice = (array_key_exists('HTTP_X_DEVICE', $_SERVER)) ? $_SERVER['HTTP_X_DEVICE']:"";

        if(empty($accessToken) || empty($accessDevice)){
            $response=array();
            $response['status'] =Api::ERROR_CODE;
            $response['msg']= "Please login into your Turnstr account.";
            return response()->json($response, 200);
        }

        $userDevice = UserDevice::where(['device_id' => $accessDevice, 'access_token' => $accessToken])->get()->first();


        if(!$userDevice){
            $arrResponse['status'] = Api::ERROR_CODE;
            $arrResponse['msg'] = "Access key have been expired or invalid. Please login again";
            return response()->json($arrResponse, 200);
        }

        DeviceSession::set($userDevice);
        return $next($request);

    }
}