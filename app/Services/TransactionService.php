<?php

namespace Makanplz\Services;

use Makanplz\Models\TransactionHistory;
use \Makanplz\Services\ResponseService;
use Exception;
use stdClass;

class TransactionService
{

    public function save($data, $transaction = null)
    {
        $this->response_service = new ResponseService();

        if (is_null($transaction))
            $transaction = new TransactionHistory();

        if (isset($data->created_by))//Auth id of user
            $transaction->created_by = $data->created_by;

        if (isset($data->type_id))
            $transaction->type_id = $data->type_id;

        if (isset($data->food_price))
            $transaction->food_price = $data->food_price;

        if (isset($data->activity))
            $transaction->activity = $data->activity;

        try {
            $is_transaction_save = $transaction->save();
            $status = 'Success';
            $message = 'Transaction successful created!';
            $code = 201;
        } catch (Exception $exception) {
            $status = 'Error';
            $message = 'Database error : ' . $exception;
            $code = 403;
        }
        $results = $this->response_service->render($data, $status, $message, $code);
        return $results;

        // $transaction->save();

        // return $order;
    }

    // public function saveStatus(data, $order) {
    //     $order->status = $data->status;
    //     $order->save();
    //     return $response->withJson($order);
    // }
}