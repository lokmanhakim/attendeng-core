<?php

namespace Makanplz\Services;

use Illuminate\Support\Facades\Hash;
use Makanplz\Models\User;
use Makanplz\Models\UserProfile;
use Makanplz\Models\Location;
use Makanplz\Models\UserLocation;
use Makanplz\Services\LocationService;
use Makanplz\Services\AuditTrailService;
use Makanplz\Services\ResponseService;
use Exception;
use stdClass;
use Illuminate\Database\Capsule\Manager as DB;

class UserService
{

    public function __construct()
    {
        $this->response_service = new ResponseService();
    }

    public function save($params, $user = null)
    {
        $isCreated = false;
        $data = new stdClass;

        if (isset($params->user))
            $userData = $params->user;

        if (is_null($user)) {
            $user = new User();
            $isCreated = true;
        }

        if (isset($userData->email))
            $user->email = $userData->email;

        if (isset($userData->role))
            $user->role = $userData->role;

        if (isset($userData->password))
            $user->password = password_hash($userData->password, PASSWORD_DEFAULT);

        DB::beginTransaction();
        
        try {
                
            $user->save();
            if (isset($userData->user_profile)) {

                if (!isset($userData->user_profile->user_id))
                    $userData->user_profile->user_id = $user->id;
                
                $result_user_profile = $this->saveUserProfile($userData, $user->UserProfile);

                if( $result_user_profile->response->code === 403)
                    throw new \Exception('Seller Profile created failed');
            }
            $data->user = $user;
            $data->user->user_profile = $result_user_profile;
            DB::commit();

            //RESPONSE MESSAGE IS SUCCESS
            $status = 'Success';
            $code = 200;//Code created

            if ($isCreated) {$message = 'User successful registered!';}
            else {$message = 'User successful updated!';}

        } catch (ValidationException  $e) {
            DB::rollback();
        }catch (Exception $e ){
            //RESPONSE MESSAGE IS FAILED
            $status = 'error';
            $message = 'Database error : ' . $e;
            $code = 403;
        }
        
        $results = $this->response_service->render($data, $status, $message, $code);
        return $results;
    }

    public function saveUserProfile($params = null, $userprofile = null)
    {

        $locationservice = new LocationService();
        $isCreated = false;//if created so message 'successfully created'
        $profileData = $params->user_profile;
        $data = new stdClass;

        if (is_null($userprofile)) {
            $userprofile = new UserProfile();
            $isCreated = true;
        }

        if (isset($profileData->user_id))
            $userprofile->user_id = $profileData->user_id;

        if (isset($profileData->phone1))
            $userprofile->phone1 = $profileData->phone1;

        if (isset($profileData->phone2))
            $userprofile->phone2 = $profileData->phone2;

        if (isset($profileData->full_name))
            $userprofile->full_name = $profileData->full_name;

        if (isset($profileData->gender))
            $userprofile->gender = $profileData->gender;

        if (isset($profileData->credits))
            $userprofile->credits = $profileData->credits;

        try {
            $userprofile->save();
            $data->user_profile = $userprofile;
            $status = 'Success';
            $code = 200;//Code created

            if (isset($profileData->locations)) {
                for ($i = 0; $i < count($profileData->locations); $i++) {
                    if (isset($profileData->locations[$i]->id)) {
                        if (!is_null($userprofile->User->Locations)) {
                            for ($j = 0; $j < count($userprofile->User->Locations); $j++) {
                                if ($profileData->locations[$i]->id === $userprofile->User->Locations[$j]->location_id) {
                                    $result_userlocation = $locationservice->saveUserLocation($profileData->locations[$i], $userprofile, $userprofile->User->Locations[$j]);
                                }
                            }
                        }
                    } else {
                        $result_userlocation = $locationservice->saveUserLocation($profileData->locations[$i], $userprofile);
                        $userprofile->User->Locations()->save($result_userlocation->location->userlocation);
                        $userprofile->User->Locations;//To be able the result include locations in user 
                    }
                }
            }

            if ($isCreated){$message = 'User profile successful registered!';}
            else{$message = 'User profile successful updated!';}

        } catch (Exception $exception) {
            $status = 'error';
            $message = 'Database error : ' . $exception;
            $code = 403;
        }
        $results = $this->response_service->render($data, $status, $message, $code);
        return $results;
    }

    public function updateCredit($data, $user = null, AuditTrailService $audittrailservice)
    {
        $this->response_service = new ResponseService();

        $user->Loyalty->current_point = $user->Loyalty->current_point - $data->credit;
        $user->Loyalty->total_point = $user->Loyalty->total_point - $data->point;

        $audit = new Object();
        $audit->activity_id = $order->id;
        // $audit->created_by = //Authenticate ID
        $audit->activity_type = 'Makanplz\Models\Loyalty';

        if ($isNew) {
            $audit->description = "{Authenticate Name} created an new order(ORDER ID)";
        } else {
            $audit->description = "{Authenticate Name} updated an new order(ORDER ID)";
        }
        $audit = $audittrailservice->save($audit);

        if (isset($data->address))
            $sellerprofile->address = $data->address;

        try {
            $is_user_sellerprofile = $sellerprofile->save();
            $status = 'Success';
            $message = 'Credit successful updated!';
            $code = 201;
        } catch (Exception $exception) {
            $status = 'Error';
            $message = 'Database error: ' . $exception;
            $code = 403;
        }
        $results = $this->response_service->render($data, $status, $message, $code);
        return $results;
    }

    public function statusToken($token)
    {   
        $data = new stdClass();
        //Default result
        $status = 'error';
        $message = 'No token or user found!';    
        $code = 403;
        

        if(!is_null($token)){

            $data->user = User::with('UserProfile', 'Locations', 'SellerProfile')->where('token_hash', $token)->first();

            if (!empty($data->user)) {
                
                $exp_token = strtotime($data->user->token_expiry);
                $now = strtotime(date("Y-m-d H:i:s"));

                if($exp_token > $now){
                    $status = 'success';
                    $message = 'Token alive';    
                    $code = 200;

                }else{
                    $data->user = null;
                    $status = 'error';
                    $message = 'Token expired';    
                    $code = 403;
                }
            } 
        } 
        $results = $this->response_service->render($data, $status, $message, $code);
        
        return $results;
    }

}