<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;
use stdClass;
use App\Models\User;
use App\Services\ResponseService;

class UserController
{

    public function __construct()
    {
        //Code here
        $this->response_service = new ResponseService();
    }

    public function getAllUsers($request, $response)
    {
        $data=new stdClass();
        try {
            $data->users = User::all();
            $status = 'success';
            $message = 'Succesfully retrieve data';
            $code = 200;
        } catch (Exception $exception) {
            $status = 'error';
            $message = 'Database error : ' . $exception;
            $code = 403;
        }

        $results = $this->response_service->render($data, $status, $message, $code);
        return $response->withJson($results, $code);
    }
    
}