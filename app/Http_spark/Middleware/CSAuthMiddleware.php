<?php
namespace App\Http\Middleware;

use DB;
use Closure;
use Session;
use App\User;
use Constant;
use Illuminate\Http\Request;
use App\Helpers\AppHelper as Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Exception;
use Illuminate\Contracts\View\Factory;

class CSAuthMiddleware {

    const ACCESS_TOKEN = 'access_token';
    const IDENTITY = 'identity';
    const KEYCLOAK_CLIENT_ID = 'KEYCLOAK_CLIENT_ID';
    const SESSION_LARAVEL = 'keycloak_laravel';
    const REFRESH_TOKEN = 'refresh_token';
    const AUTH_LOGIN = 'authLogin';
    const SESSION_DATA = 'session_data';
    const USER_ID = 'user_id';
    const APP_CLIENT_ID= 'app.client_id';
    const CLIENT_ID='client_id';
    const USERNAME= 'username';
    /**
     * Handle an incoming request.
     * RP-18, RP-20
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $except = [
        '/'.CSAuthMiddleware::AUTH_LOGIN,
        '/logout'
    ];

    public function handle($request, Closure $next) {
        try {
            //dd($request->all());
            //Skip routes
            $continue = 0;
            if ($request->fullUrlIs(CSAuthMiddleware::AUTH_LOGIN) || $request->is(CSAuthMiddleware::AUTH_LOGIN)) {  $continue = 1;   }
            if ($request->fullUrlIs('logout') || $request->is('logout')) { $continue = 1; }
            if ($request->fullUrlIs('verify') || $request->is('verify')) { $continue = 1; }            
            if ($request->fullUrlIs('freelancerVerification') || $request->is('freelancerVerification')) { $continue = 1; }
            if ($request->fullUrlIs('maintenance') || $request->is('maintenance')) { $continue = 1; }
            
            //exclude middleware fo ajax calls
            if($request->ajax()) {
                $continue = 1;
            }
            $response = $next($request);
            if(isset($continue) && $continue == 1){
                return $response;
            }
            
            
            $redirect = false;
            //Non-CS users from direct URL access validation
            @$identity = $request->input(CSAuthMiddleware::IDENTITY);
            try {
                if (!empty($identity)) {
                    $request->session()->put(CSAuthMiddleware::IDENTITY, 1);                    
                    $author = json_decode(base64_decode($request->input(CSAuthMiddleware::IDENTITY)));                   
                    $redirect_uri = url("/")."/".CSAuthMiddleware::AUTH_LOGIN;
                    $return_url = url("/")."/workitem?key=".$request->input('key')."&process=".$request->input('process');
                    $error_url = url("/")."/error";
                     //$host_api = Helper::instance()->getAPIUrlCS();
                     $host_api = config('app.platform_url');
                    
                    
                    $misc = $request->input('key');
                    $login_with_returnUrl = $host_api . 'verify?'.CSAuthMiddleware::CLIENT_ID.'=' . config(CSAuthMiddleware::APP_CLIENT_ID) . '&redirect_uri='.$redirect_uri.'&return_url=' . $return_url . '&error_uri=' . $error_url . '&email=' . $identity. '&misc=' . $misc;
                    return redirect($login_with_returnUrl);
                }

                //General session validation
                if (!Auth::check()) {                   
                    $redirect = true;
                } else{
                    $session_user_role = 0;
                    $session_user = $request->session()->get('user_info');  
                    if(!empty($session_user)) { 
                        //dd($session_user);                                 
                        $session_user_role = $session_user->role; 
                    }                                                         
                }
              
                //Session check allowed only for valid CS users through direct login
                if (isset($session_user_role) && $session_user_role != config('app.delegate_role_id')) {
                    $get_session_data = $request->session()->get(CSAuthMiddleware::SESSION_LARAVEL);
                    //Skips session check if cs users login through encrypted url
                    $url_based_auth = $request->session()->get(CSAuthMiddleware::IDENTITY);

                    if(!empty($url_based_auth)){
                        return $response;
                    }

                    if (!empty($get_session_data) && Auth::check()) {
                        //$host_api = Helper::instance()->getAPIUrlCS();
                        $host_api = config('app.platform_url');
                        $url = $host_api."session";

                        $data = array(
                            'token' => $get_session_data['refresh_token'],
                            CSAuthMiddleware::CLIENT_ID => config(CSAuthMiddleware::APP_CLIENT_ID),
                            'client_secret' => config('app.client_secret'),
                        );
                        
                        $detail = null;                                
                        //$host_api = Helper::instance()->getAPIUrlCS();
                        $host_api = config('app.platform_url');
                        $url = $host_api."session";
                        $data = array(
                            CSAuthMiddleware::USERNAME => Auth::user()->username,
                            CSAuthMiddleware::CLIENT_ID => env(CSAuthMiddleware::KEYCLOAK_CLIENT_ID),
                            'client_secret' => env("KEYCLOAK_CLIENT_SECRET"),
                        );

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $data,
                            CURLOPT_SSL_VERIFYPEER=>false,
                            CURLOPT_SSL_VERIFYHOST=>false,
                            CURLOPT_HTTPHEADER => array("accept: application/json")
                        ));          
                        $result = curl_exec($curl); 
                        curl_close($curl);   

                        
                       // $result = Helper::instance()->commonCurlCall($data, $url, 'POST',true);
                        $userdata = json_decode($result);                        
                        if(empty($userdata->username)){
                            $array = array(CSAuthMiddleware::USERNAME=>null, "active"=>false, CSAuthMiddleware::CLIENT_ID=>$data[CSAuthMiddleware::CLIENT_ID], "transaction_id"=>$detail);
                            $result = json_encode($array);
                        } else{
                            $array = array(CSAuthMiddleware::USERNAME=>$userdata->username, "active"=>true, CSAuthMiddleware::CLIENT_ID=>$data[CSAuthMiddleware::CLIENT_ID], "transaction_id"=>$detail);
                            $result = json_encode($array);
                        }       
                        
                        $userdata = json_decode($result);
                        if (isset($userdata->active) && !($userdata->active) ) {
                            $redirect = true;
                        }
                    } else {
                        $redirect = true;
                    }
                }
            } catch (Exception $e) {
                dd($e);
                //Helper::instance()->errorAPICall($e);
            }

            //Redirect to login page is session not found or expired
            if ($redirect) {
                //Helper::instance()->clearLocalSession();
                $user = !empty($request->input('user'))? $request->input('user') : null ;    
                $return_url = url("/")."/".CSAuthMiddleware::AUTH_LOGIN;
                $error_url = url("/")."/error";
                //$host_api = Helper::instance()->getAPIUrlCS();
                $host_api = config('app.platform_url');
                $login_with_returnUrl = $host_api . 'login?'.CSAuthMiddleware::CLIENT_ID.'=' . config(CSAuthMiddleware::APP_CLIENT_ID) . '&redirect_uri=' . $return_url . '&error_uri=' . $error_url . '&user=' . $user;

                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                session()->put('app_intended_url', $actual_link);

                return redirect($login_with_returnUrl);
            }
        } catch (Exception $e) {
            dd($e);
            //Helper::instance()->errorAPICall($e);
        }

        return $response;
    }    
}
