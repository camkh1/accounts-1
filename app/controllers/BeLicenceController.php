<?php

class BeLicenceController extends BaseController {

	protected  $user;
	protected  $modUserGroup;

	const CLIENT_USER = 4;

	public function __construct() {
		$this->user = new User();
		$this->modUserGroup = new UserGroup();
	}

		/**
	 * dashboard: this function display all modules in controll panel
	 *
	 */
	public function listlicence(){
		return View::make('backend.modules.licence.index');
	}
}
