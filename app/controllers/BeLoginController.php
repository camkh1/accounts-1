<?php

class BeLoginController extends BaseController {

 	protected  $user;

	public function __construct() {
		$this->user = new User();
	}

	/**
	 * showLogin: this function display form login page
	 *
	 */
	public function showLogin()
	{
		if(!empty($_COOKIE['myIP'])) {
			$currentIP = $_COOKIE['myIP'];
		} else {
			setcookie('myIP', $_SERVER['REMOTE_ADDR'], time() + (86400 * 30));
			$currentIP = @$_COOKIE['myIP'];
		}
		$continue = trim(Input::get('continue'));
		if($continue) {
			Session::put('continue', $continue);
		}
		if (Auth::check()) {
			$beUser = new BeUserController();
			$user = Auth::user();
			$userCheck = $beUser->myAccountDetail($user->id, 'local');
			$userStatus = json_decode($userCheck);
			if(empty($userStatus->error)) {
				if(Session::has('continue')) {
					return Redirect::to(Session::get('continue') . '?id=' . $user->id);
				} else {
					return Redirect::to('myaccount');
				}
			} else {
				$this->doLogout();
			}
		} 
		$this->accountStatus();
		return View::make('backend.modules.login.index');
	}

	/**
	 * doLogin: this function validation username and password
	 * @return true | false
	 *
	 */
	public function doLogin(){
		if (Auth::check()) {
			return Redirect::to('myaccount');
		}
		if(Input::has('btnLogin')){
			if(isset($_COOKIE['myIP'])) {
				$currentIP = $_COOKIE['myIP'];
			} else {
				setcookie('myIP', $_SERVER['REMOTE_ADDR'], time() + (86400 * 30));
				$currentIP = $_COOKIE['myIP'];
			}

			Session::forget ( 'user' );
			$input = Input::all();
			$email = trim(Input::get('email'));
			$continue = trim(Input::get('continue'));
			if($continue) {
				Session::put('continue', $continue);
			}
			$password = trim($input['password']);
// 			$data['password'] = Hash::make($password);
// 			var_dump($data['password']);
// die;
			$password = trim($input['password']);
				$rules = array(
					'email' => 'required',
					'password' => 'required',
				);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->passes()) {
				$user = array('email' => $email, 'password' => $password,'u_status'=>1);
				$getRemember = false;
				if(Input::get('remember')) {
					$getRemember = true;
				}
				if (Auth::attempt($user,$getRemember)) {
					/*check status user*/					
					$user = Auth::user();
					$online = Auth::user()->u_online;
					$uip = Auth::user()->u_ip;
					if($currentIP != $uip && $online == 1) {
						Session::push ( 'user.u_ip', 'Your_used_with_other');
					}
					// if($online == 1) {
					// 	Session::push ( 'user.u_online', 'Your_used_with_other');
					// }

					if(Session::has ( 'user' )) {
						return Redirect::to('/')->with('invalid',trans('login.Your_used_with_other'));
					}
					/*end check status user*/

					Session::put('SESSION_USER_ID', Auth::user()->id);
					Session::put('SESSION_USER_EMAIL', Auth::user()->email);
					Session::put('SESSION_USER_TYPE',Auth::user()->u_type);
					Session::put('SESSION_LOGIN_NAME',Auth::user()->u_name);
					if (Input::has('remember')) {
						setcookie('remember_username', Auth::user()->email, time() + (86400 * 30));
						setcookie('remember_password', $password, time() + (86400 * 30));
					} elseif (!Input::has('remember')) {
						$past = time() - 100;
						setcookie('remember_username', 'gone', $past);
						setcookie('remember_password', 'gone', $past);
					}

					/*set user status to online*/
					$this->user->where('id','=',Auth::user()->id)->update(array('u_online'=>1,'lastActiveTime'=> time(),'u_ip'=>$currentIP));
					/*end set user status to online*/

					if('admin' == Auth::user()->u_type){
						if(Session::get('continue')) {
							return Redirect::to(Session::get('continue') . '?id=' . Auth::user()->id);
						} else {
							return Redirect::to('admin/dashboard');
						}
						
					}else{
						if(Session::get('continue')) {
							return Redirect::to(Session::get('continue') . '?id=' . Auth::user()->id);
						} else {
							return Redirect::to('myaccount');
						}
						
					}
				}else {
					return Redirect::to('/')->with('invalid','User name and Password are not matched!');
				}

			}else{
				return Redirect::to('/')->withInput()->withErrors($validator);
			}
		}


		/*create account*/
		if(Input::has('btnRegister')){
			$rules = array(
				'email' => 'required|unique:users',
				'password' => 'required|min:8',
				'password_confirm'=>'required|same:password',
				'captcha' => array (
					'required',
					'captcha' 
				)
			);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->passes()) {
				$data = $this->prepareDataBind('add');
				$this->user->insert($data);
				return Redirect::to('/')->with('success','register_success');
			}else{
				return Redirect::to('register')->withInput()->withErrors($validator);
			}
		}
		/*end create account*/

	}


	public function checkAccount()
	{
		if(Input::has('user')) {
			$users = $this->user->getUserBy(array('email'=>Input::get('user')));
			echo json_encode($users);
			die;
		}
		
	}

	public function creatAccount() {
		if (Auth::check()) {
			return Redirect::to('myaccount');
		}
		// if (Session::has('SESSION_USER_ID')){
		// 	return Redirect::to('myaccount');
		// }
		return View::make('backend.modules.login.register');
	}
	/**
	 * doLogout: this function using for logout operation
	 * @return true if logout success
	 */
	public function doLogout(){
		User::where('id','=',Session::get('SESSION_USER_ID'))->update(array('u_online'=>0));
		Auth::logout();
		Session::flush();
		$continue = trim(Input::get('continue'));
		if($continue) {
			Session::put('continue', $continue);
		}
		return Redirect::to('/');
	}

	/**
	 * dashboard: this function display all modules in controll panel
	 *
	 */
	public function dashboard(){
		return View::make('backend.partials.dashboard');
	}

	/**
	 *
	 * sendResetPassword:this function using for sending email for reset password
	 */
	public function sendResetPassword(){
		$type = Input::get('type');
		if(Input::has('btnSendResetPassword')){
			$input = Input::all();
			$email = trim($input['email']);
				$rules = array(
					'email' => 'required|email'
				);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->passes()) {
				$users = $this->user->getUserBy(array('email'=>$email));

				if(!empty($users->result[0])) {
					$user = $users->result[0];
					$mailUser = array('name'=>$user->u_name,'address'=>$user->email);
					Mail::send('message', $mailUser, function($message) use ($user)
					{

						$message->to($user->email, 'Reset password - autopost')->subject('Testing!');
					});
				} else {
					if($type=='json') {
						$data = array('error'=> 'Your Email is not matched!');
					} else {
						return Redirect::to('admin/send-forget-password')->with('invalid','Your Email is not matched!');
					}
				}
				
			}else{
				if($type=='json') {
					$data = array('error'=> 'your type is not in formated');
				} else {
					return Redirect::to('admin/send-forget-password')->withInput()->withErrors($validator);
				}
				
			}
		}
		if($type!='json') {
			return View::make('backend.modules.login.send_reset_password');
		} else {
			$setData = new stdClass();
			if(!empty($user)) {
				$data = $user;
				$setData->errro = false;
				$setData->data = $user;
			} else {
				$setData->errro = true;
				$setData->data = 'no data';
			}
			echo json_encode($setData);
			die;
		}
	}

	/**
	 * resetPassword:this function using for reset password
	 */
	public function resetPassword(){
		return View::make('backend.modules.login.reset_password');
	}


	/**
	 *
	 * prepareDataBind: this function handling with preparing data bine
	 * @param param: add or edit
	 * @param id: the id of user
	 */
	public function prepareDataBind($param){
		$visitor_browser = array(
			'browser' => $this->getBrowser()['name']
		);
		$currentIP = $_COOKIE['myIP'];
		if($param == 'add'){
				$data = array(
					'email'=>trim(Input::get('email')),
					'u_name'=>trim(Input::get('name')),
					'u_type'=>'normal',
					'u_status'=>1,
					'u_ip'=>$currentIP,
					'json'=>json_encode($visitor_browser),
				);
				$password = trim(Input::get('password'));
				$data['password'] = Hash::make($password);
				$data['u_dtime']= time();
		}else if($param == 'edit'){
				$data = array(
					'email'=>trim(Input::get('email')),
					'u_name'=>trim(Input::get('name')),
					'user_type'=>Input::get('role'),
					'telephone'=>Input::get('telephone'),
					'address'=>Input::get('address'),
				);
				$data['u_dmodify']= date('Y-m-d');
		}
		return $data;
	}

	/*
	 * get divice function
	 */
	function getBrowser() {
		$u_agent = $_SERVER ['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version = "";
		
		// First get the platform?
		if (preg_match ( '/linux/i', $u_agent )) {
			$platform = 'linux';
		} elseif (preg_match ( '/macintosh|mac os x/i', $u_agent )) {
			$platform = 'mac';
		} elseif (preg_match ( '/windows|win32/i', $u_agent )) {
			$platform = 'windows';
		}
		
		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match ( '/MSIE/i', $u_agent ) && ! preg_match ( '/Opera/i', $u_agent )) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif (preg_match ( '/Firefox/i', $u_agent )) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif (preg_match ( '/Chrome/i', $u_agent )) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif (preg_match ( '/Safari/i', $u_agent )) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif (preg_match ( '/Opera/i', $u_agent )) {
			$bname = 'Opera';
			$ub = "Opera";
		} elseif (preg_match ( '/Netscape/i', $u_agent )) {
			$bname = 'Netscape';
			$ub = "Netscape";
		}
		
		// finally get the correct version number
		$known = array (
				'Version',
				$ub,
				'other' 
		);
		$pattern = '#(?<browser>' . join ( '|', $known ) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (! preg_match_all ( $pattern, $u_agent, $matches )) {
			// we have no matching number just continue
		}
		
		// see how many we have
		$i = count ( $matches ['browser'] );
		if ($i != 1) {
			// we will have two since we are not using 'other' argument yet
			// see if version is before or after the name
			if (strripos ( $u_agent, "Version" ) < strripos ( $u_agent, $ub )) {
				$version = $matches ['version'] [0];
			} else {
				$version = $matches ['version'] [1];
			}
		} else {
			$version = $matches ['version'] [0];
		}
		
		// check if we have a number
		if ($version == null || $version == "") {
			$version = "?";
		}
		
		return array (
				'userAgent' => $u_agent,
				'name' => $bname,
				'version' => $version,
				'platform' => $platform,
				'pattern' => $pattern 
		);
	}

	public function unique_array_key($the_array){
   		$r = rand();
	   if (array_key_exists("$r", $the_array)) {
	     return unique_array_key($the_array);
	   } else {
	     return $r;
	   }
	}

	public function accountStatus() {
		$currentTime = time() - 60;
		$users = $this->user->where('lastActiveTime','<',$currentTime)->where('u_online','=',1)->get();
		if(!empty($users)) {
			foreach ($users as $online) {
				$this->user->where('id','=',$online->id)->update(array('u_online'=>0));
			}
		}
		/*end check status user*/
	}

}
