<?php

class BeLicenceController extends BaseController {

	protected  $licence;
	const Day = '86400';
	const Week = '604800';
	const Month = '2592000';
	const Year = '31536000';

	const CLIENT_USER = 4;

	public function __construct() {
		$this->licence = new Licence();
	}

	/**
	 * listlicence: this function display all modules in controll panel
	 *
	 */
	public function listlicence(){
		$licence = array();
		$userType = Session::get('SESSION_USER_TYPE');
		if($userType == 'admin') {
			//$this->licence->where('user_id','=', Session::get('SESSION_USER_ID'));
			//$this->licence->where('l_status','!=', 0);
			$this->licence->orderBy('l_start_date','DESC');
			$licence = $this->licence->paginate(10);
		} else {
			$this->licence->where('user_id','=', Session::get('SESSION_USER_ID'));
			$this->licence->where('l_status','!=', 0);
			$licence = $this->licence->paginate(10);
		}
		return View::make('backend.modules.licence.index')->with('list', $licence);
	}

	/**
	 * addlicence: this function display all modules in controll panel
	 *
	 */
	public function addlicence(){
		$userId = Session::get('SESSION_USER_ID');
		$licence = array();
		if(Input::has('submit')){
			$rules = array(
				'moneyid' => 'required',
				'phone' => 'required',
				'name'=>'required'
			);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->passes()) {
				$moneyByMonth = Input::get('money');
				switch ($moneyByMonth) {
					case 1:
						$num = 7;
						$endDate = $num * self::Day;
						$nameOf = 'd';
						$price = 3;
						break;
					case 2:
						$num = 14;
						$endDate = $num * self::Day;
						$nameOf = 'd';
						$price = 5;
						break;
					case 3:
						$num = 1;
						$endDate = $num * self::Month;
						$nameOf = 'm';
						$price = 7;
						break;
					case 4:
						$num = 3;
						$endDate = $num * self::Month;
						$nameOf = 'm';
						$price = 18;
						break;
					case 5:
						$num = 6;
						$endDate = $num * self::Month;
						$nameOf = 'm';
						$price = 30;
						break;
					case 6:
						$num = 1;
						$endDate = $num * self::Year;
						$nameOf = 'y';
						$price = 50;
						break;
				}
				$startDate = time();
				$endOnDate = $startDate + $endDate;
				$moneyId = Input::get( 'moneyid' );
				$name = Input::get( 'name' );			
				$phone = Input::get( 'phone' );
				$postId = Input::get( 'postid' );

				/* add data to post */
				$licenceTable = 'licence';
				$method = (string) Input::get( 'stransferBy' );
				$dataLicence = array(
					'l_name' => $name,
					'l_price' => $price,
					'l_tel' => $phone,
					'l_transfer_by' => $method,
					'l_money_id' => $moneyId,
	                'l_start_date' => $startDate,
	                'l_end_date' => $endOnDate,
	                'l_status'=>2,
	                'user_id'=>$userId,
	                'l_type'=>'paid',
	                'l_loc'=>'',
	            );
	            $this->licence->insert($dataLicence);
	            return Redirect::to('admin/licence');
			}
		}
		return View::make('backend.modules.licence.add');
	}
}
