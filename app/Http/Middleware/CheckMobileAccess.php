<?php namespace App\Http\Middleware;

use Closure;
use DB;
use Config;
use App\Models\Api;
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




        $queryResult = DB::table('user_devices as ud')
            ->where('ud.device_id',$accessDevice)
            ->where('ud.access_token',$accessToken)
            ->select('ud.user_id', 'app_version', 'os_type')
            ->first();
        if($queryResult){
            return $next($request);

        }
        else {
            $arrResponse['status'] = Config::get(Api::ERROR_CODE);
            $arrResponse['msg'] = "Access ke might have been expired. Please login again";
            return $arrResponse;
        }

    }
}