<?php
namespace App\Http\Controllers\Auth;

use Session;
use Constant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Helpers\AppHelper as Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TokensController extends Controller
{
    const USER_ID = 'user_id';
    const REFRESH_TOKEN = 'refresh_token';
    const ACCESS_TOKEN = 'access_token';
    const USERNAME = 'username';
    const SESSION_LARAVEL = 'keycloak_laravel';
    const USER_INFO = 'user_info';
    const USERS = 'users';
    const EMAIL = 'email';
    const NAME = 'name';
    const DELEGATE_ROLE = 'app.delegate_role_id';

    /**
     * RP-18
     * @param Request $request
     * @return type
     */
    public function clearToken(Request $request){
        try{
            $get_session_data = $request->session()->get(TokensController::SESSION_LARAVEL);
            $user_info = $request->session()->get(TokensController::USER_INFO);

            if(!empty($user_info)){
                $refresh_token = "";
                $user_role = 0;

                if(!empty($get_session_data)) {
                    $refresh_token = $get_session_data[TokensController::REFRESH_TOKEN];
                }

                if(empty($get_session_data[TokensController::USER_ID])) {
                    $get_session_data[TokensController::USER_ID] = !empty($user_info->id)? $user_info->id:0;
                }
                
                //logout user from platform
                //$host_api = Helper::instance()->getAPIUrlCS();
                $host_api = config('app.platform_url');
                $url = $host_api."logout";               
                $client_id = config('app.client_id');
                $user_id = $user_info->id;

                $data["client_id"] = $client_id;
                $data["user_id"] = $user_id;
                $method = "POST";

                //Helper::instance()->curlCallJson($url, json_encode($data), $method);
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_SSL_VERIFYPEER=>false,
                    CURLOPT_SSL_VERIFYHOST=>false,
                    CURLOPT_HTTPHEADER => array("accept: application/json")
                )); 
                               
                
                $result = curl_exec($curl); 
                
                if(curl_errno($curl)){
                    echo 'Request Error:' . curl_error($curl);
                }
                curl_close($curl); 
                

                $this->deleteSessions();
                // $return_url = url("/")."/authLogin";
                // $error_url = url("/")."/error"; 
                
                // if(!empty($user_info) && property_exists($user_info, 'role_ids')){
                //     $user_role = $user_info->role_ids;
                // }

                // if(!empty(config(TokensController::DELEGATE_ROLE)) && ($user_role == config(TokensController::DELEGATE_ROLE))){
                //     Session::flush();            
                //     // return view('auth.logout');
                //     return redirect()->to("/");
                // } else{
                //     $login_with_returnUrl = $url.'?client_id='.$client_id.'&redirect_uri='.$return_url.'&error_uri='.$error_url.'&'.TokensController::USER_ID.'='.$get_session_data[TokensController::USER_ID].'&'.TokensController::REFRESH_TOKEN.'='.$refresh_token;    
                // }
                
                // return redirect($login_with_returnUrl);
            }

            return redirect()->back();
        } catch(Exception $e){
            Helper::instance()->errorAPICall($e);
        }
    }
    
    public function authLogin(Request $request) {
        try{
            $data = $request->all();             
            if(!empty($data['author'])){
                $author_data = json_decode(base64_decode($data['author']));
                $external = 'external-user';                 
                $auth_url       = config('app.swagger_externaluser_email').$author_data->email;
                $authors        = Helper::instance()->commonCurlCall('', $auth_url, 'GET');
                $author         = $authors->data[0]->$external[0];
                $url = trim(config('app.swagger_set_user').'?id='.$author->id.'&'.TokensController::USER_ID.'='.$author->id.'&'.TokensController::NAME.'='.$author->first_name.'&external=Y&roles=500'.'&'.TokensController::EMAIL.'='.urlencode($author_data->email).'&product='.config('app.swagger_product_name').'&token='.config('app.swagger_token'));
                
                $user = Helper::instance()->commonCurlCall('', $url, 'PUT');
                //After saving user data create session for user using user id and save user related data into sessions
                if (!Auth::check()){
                    Auth::loginUsingId($author->id);
                }
                $user_info = array("role_name" => "Delegate", "role_ids" => 500, "profile_image" => null, "display_name" => Auth::user()->display_name, "theme"=>'shiraz-megenta-cyan','user_id' =>$author->id , 'display_name' => $author->first_name, 'email' => $author->email, 'id' =>$author->id );
                $session_data = array(TokensController::ACCESS_TOKEN => TokensController::ACCESS_TOKEN,TokensController::REFRESH_TOKEN => TokensController::REFRESH_TOKEN,TokensController::USERNAME => Auth::user()->name,TokensController::USER_ID => Auth::user()->id,
                        TokensController::EMAIL => Auth::user()->email,TokensController::NAME => Auth::user()->display_name);
                
                $request->session()->put(TokensController::SESSION_LARAVEL, $session_data);
                $request->session()->put('user_info', (object) $user_info);
                $comp_url       = config('app.swagger_get_component_id').'?key='.$author_data->misc;
                $component      = Helper::instance()->commonCurlCall('', $comp_url, 'GET');            
                $process_id     = $component->data[0]->components[0]->process_id; 
                if($process_id==2){
                    $process = '3c_edit';
                }else{
                    $process = '3c_qc';
                }
                return redirect('/workitem?key='.$author_data->misc.'&process='.$process);    
            }
            
            if(!empty($data)){
                $user_info = json_decode(base64_decode($data[TokensController::USER_INFO])); 
                //dd($user_info);                 
                $groups = isset($user_info->group)?'['.implode(",",$user_info->group).']':'[1]';
                $teams = isset($user_info->team)?'['.implode(",",$user_info->team).']':'[1]';
                setcookie('login_group', $groups[1]);
                $user_id = explode("_",$user_info->username);
                $designation = isset($user_info->designation)?$user_info->designation:'';
                $profile_image = isset($user_info->profile_image)?$user_info->profile_image:'';
                // $url = trim(config('app.swagger_set_user').'?id='.$user_info->id.'&'.TokensController::USER_ID.'='.urlencode($user_id[1]).'&'.TokensController::NAME.'='.urlencode($user_info->name).'&'.TokensController::EMAIL.'='.urlencode($user_info->email).'&theme='.urlencode($user_info->theme).'&groups='.$groups.'&teams='.$teams.'&image='.$profile_image.'&roles='.$user_info->role.'&designation='.urlencode($designation).'&product='.config('app.swagger_product_name').'&token='.config('app.swagger_token'));                                     
                // $user = Helper::instance()->commonCurlCall('', $url, 'PUT');  
                // $user_api_url = config('app.swagger_user_info').'?user='.$user_info->id.'&product='.config('app.swagger_product_name').'&token='.config('app.swagger_token');                   
                // $user_details = Helper::instance()->commonCurlCall('', $user_api_url, 'GET');
                // $userInfo = $user_details->data[0]->{"user-information"}[0];
                // $request->session()->put(TokensController::USER_INFO, $user_details->data[0]);

               $userInfo= DB::table('users')->where('email', $user_info->email)->first();                              

                $request->session()->put(TokensController::USER_INFO, $user_info);
                $email = !empty($user_info->email)?$user_info->email: "productdevelopment_team@spi-global.com";

                $session_data = array(
                    TokensController::ACCESS_TOKEN => $data[TokensController::ACCESS_TOKEN],
                    TokensController::REFRESH_TOKEN => $data[TokensController::REFRESH_TOKEN],
                    TokensController::USERNAME => $data[TokensController::USERNAME],
                    // TokensController::USER_ID => $user_details->data[0]->id,
                    // TokensController::EMAIL => $user_details->data[0]->email,
                    // TokensController::NAME => $user_details->data[0]->display_name
                    TokensController::USER_ID => $userInfo->id,
                    TokensController::EMAIL => $userInfo->email,
                    TokensController::NAME => $userInfo->name
                );

                $request->session()->put(TokensController::SESSION_LARAVEL, $session_data);
                
                if (!Auth::check()){
                    Auth::loginUsingId($userInfo->id);
                }
            } else {
                Session::forget(TokensController::SESSION_LARAVEL);
                Auth::logout();
                Session::flush();
                Session::regenerate();
            }

            $check_intended_url_session = session()->get('app_intended_url');

            if(!empty($check_intended_url_session)){
                return redirect()->to($check_intended_url_session);
            }   

            return redirect('/');
        } catch(\Exception $e){
            dd($e);           
            //Helper::instance()->errorAPICall($e);
        }
    }
    
    public function loginError(Request $request) {
        try{
            return redirect('/');
        }catch(\Exception $e){
            Helper::instance()->errorAPICall($e);
        }
    }
    
    public function deleteSessions() {        
        // if(isset(Auth::user()->user_id) && !empty(Auth::user()->user_id)){            
            Auth::logout();
            Session::flush();
            Session::regenerate();
        // }
            
        return true;
    }
    
    public function getMaintenancePage(){
        return view('layouts/maintenance');
    }
}/* end of controller class */