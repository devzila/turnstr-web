<?php
namespace App\Helpers;
use Response;

class ResponseClass{

//public static function Prepare_Response($status = true,$statusCode=200,$message="",$data="",$extras = array())
    public static function Prepare_Response($data="",$message='',$status = true,$statusCode=200, $extras = array()) {
        $res = array();
        
        $res['data'] = $data;
        $res['message'] = $message;
        $res['status'] = $status;
        $res['statusCode'] = $statusCode;
        if (count($extras)) {
            foreach ($extras as $k => $v) {
                $res[$k] = $v;
            }
        }
        return Response::json($res, $statusCode);
    }
}
?>