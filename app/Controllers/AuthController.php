<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;
use stdClass;
use App\Models\User;
use App\Models\Transaction;
use App\Services\ResponseService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AuthController
{

    public function __construct()
    {
        //Code here
        $this->response_service = new ResponseService();
    }

    public function login($request, $response)
    {

        $param = json_decode($request->getBody());

        $username = $param->username;
        $password = $param->password;
        $data = new stdClass;

        $data->user = User::where('username', $username)->first();

        if (!empty($data->user)) {
            if($data->user->status === 'active'){
                if (password_verify($password, $data->user->password)) {
                    
                    $data->user->token_hash = md5(getenv('SALT_KEY') . strtotime(Carbon::now()));
                    $data->user->token_expiry = Carbon::now()->addDays(30);
                    $data->user->save();

                    // $log = new Logger('name');
                    // $log->pushHandler(new StreamHandler('logs/app.log', Logger::INFO));

                    // // add records to the log
                    // $log->info($data->user->username.' loggedin at '.carbon::now().' from device'.$data->user->terminal_id);

                    $status = 'success';
                    $message = 'Welcome, you are now login!';
                    $code = 200;

                } else {
                    $status = 'error';
                    $message = 'Something wrong? Yeah, better you go for exercise?';
                    $code = 401;
                }
            }else {
                    $status = 'error';
                    $message = 'Your account is not active, please call super hero Taha for assist!';
                    $code = 401;
                }
        } else {
            $status = 'error';
            $message = 'Why not authorized? Ask Wawan';
            $code = 403;
        }

        $results = $this->response_service->render($data, $status, $message, $code);
        return $response->withJson($results, $code);
    }

    public function createTransaction($request, $response, $args)
    {

        $data = new stdClass;
        $param = json_decode($request->getBody());
        $transactionData = $param->transaction;

        //check if token exist and matched a user
        $user = User::where('token_hash', $transactionData->user_token)->first();
        
        if (!empty($user)) {
            if($user->status === 'active'){
                    $transaction = new Transaction;
                    $transaction->terminal_id = $transactionData->terminal_id;
                    $transaction->terminal_time = $transactionData->terminal_time;
                    $transaction->device_id = $transactionData->device_id;
                    $transaction->device_time = $transactionData->device_time;
                    $transaction->action = $transactionData->action;
                    $transaction->username = $user->username;
                    $transaction->save();

                    $data->transaction=$transaction;
                    $status = 'success';
                    $message = 'Transaction created';
                    $code = 200;
            }else {
                    $status = 'error';
                    $message = 'Your account is inactive, please call super hero Taha for assist!';
                    $code = 401;
            }
        } else {
            $status = 'error';
            $message = 'User not found. Have you try to login?';
            $code = 403;
        }

        $results = $this->response_service->render($data, $status, $message, $code);
        return $response->withJson($results, $code);
    }

    public function register($request, $response)
    {
        $data = new stdClass;
        $params = json_decode($request->getBody());

        //VALIDATION GOES THROUGH HERE
        
        $data->user = new User();
        $data->user->email = $params->user->email;
        $data->user->username = $params->user->username;
        $data->user->password = password_hash($params->user->password, PASSWORD_DEFAULT);
                
        try {
            
            $data->user->save();

            //RESPONSE MESSAGE IS SUCCESS
            $status = 'Success';
            $code = 200;//Code created
            $message = 'Now you in the club of JONG!';
        
        }catch (Exception $e ){
            
            //RESPONSE MESSAGE IS FAILED
            $status = 'error';
            $message = 'Database error : ' . $e;
            $code = 403;
        
        }
        
        $results = $this->response_service->render($data, $status, $message, $code);
        return $response->withJson($results, $code);

    }
}