<?php
class Post extends Eloquent {

	/**
	 *
	 * addPosts: this function using for saving new song
	 * @param array $data: this data holding all data from posting
	 * @return true if the data has been saved successfully
	 * @access public
	 */
	public function addPosts($data){
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.POST'))->insertGetId($data);
			$response = $result;
		}catch (\Eexception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
			$response = 0;
		}

		return $response;
	}

	/**
	 *
	 * addCategoryRelatedPosts: this function using for saving new related post by category
	 * @param array $data: this data holding all data from posting
	 * @return true if the data has been saved successfully
	 * @access public
	 */
	public function addCategoryRelatedPosts($data){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.POST_IN_CATEGORY'))->insertGetId($data);
			$response->result = $result;
		}catch (\Eexception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
			$response->result = 0;
		}

		return $response;
	}

}
