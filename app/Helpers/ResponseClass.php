<?php
namespace App\Helpers;
use Response;

class ResponseClass{

    public static function Prepare_Response($data="",$status = true,$statusCode=200, $extras = array()) {
        $res = array();
        
        $res['status'] = $status;
        $res['data'] = $data;
        if (count($extras)) {
            foreach ($extras as $k => $v) {
                $res[$k] = $v;
            }
        }
        return Response::json($res, $statusCode);
    }
}
?>