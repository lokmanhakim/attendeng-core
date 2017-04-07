<?php

namespace App\Services;

use App\Models\File;
use Exception;
use stdClass;

class ResponseService
{

    function render($data, $status = "success", $message, $code)
    {
        if ($status == "success") {
            if ($message == null) {
                $message = "Data has been successfully retrieved";
            }
            $code = 200;
        }
        $result = new stdClass;

        // all results will be here
        $result->results = $data;

        // response information
        $result->response = new stdClass;
        $result->response->status = $status;
        $result->response->code = $code;
        $result->response->message = $message;

        return $result;
    }

}

?>