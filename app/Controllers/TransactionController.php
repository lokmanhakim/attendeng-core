<?php

namespace App\Controllers;

use App\Models\Transaction;
use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;
use stdClass;
use App\Models\User;
use App\Services\ResponseService;

class TransactionController
{

    public function __construct()
    {
        //Code here
        $this->response_service = new ResponseService();
    }

    public function getAll($request, $response)
    {
        return $response->withJson(Transaction::all());
    }
    
}