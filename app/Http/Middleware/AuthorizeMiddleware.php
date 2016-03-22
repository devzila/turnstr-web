<?php namespace App\Http\Middleware;

use Closure;
use DB;
use Config;
use App\Models\Api;
use App\Models\SessionUser;
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
            $response['status'] = Config::get(Api::ERROR_CODE);
            $response['msg']= "Please login into your Wowtables account.";
            return response()->json($response, 200);
        }

        $userDevice = UserDevice::where(['device_id' => $accessDevice, 'access_token' => $accessToken])->get();


        if(!$userDevice){
            $arrResponse['status'] = Config::get(Api::ERROR_CODE);
            $arrResponse['msg'] = "Access key have been expired or invalid. Please login again";
            return $arrResponse;
        }

        SessionUser::set($userDevice->user_id);
        return $next($request);

    }
}