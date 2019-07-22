<?php

class BeCategoryController extends BaseController {

	protected $mod_category;
	protected $modUserGroup;
	public function __construct() {
		$this->mod_category = new MCategory();
		$this->modUserGroup = new UserGroup();
	}

	/**
	 *
	 * fetchCategoryTreeList: this function using for listing sub category
	 * @return array category tree list
	 * @access public
	 */
	public function listCategory(){
		if(!$this->modUserGroup->isAccessPermission('admin/categories')){
			return Redirect::to('admin/deny-permisson-page');
		}
		$status = array(''=>'Select Category Status',0=>'Disable', 1=>'Enable');
		$categoryList = $this->mod_category->fetchCategoryTreeList();
		return View::make('backend.modules.category.list')
		->with('categoryList',$categoryList)
		->with('status', $status);
	}

	/**
	 *
	 * filterCategory: this function using for filter sub category
	 * @return array category tree list
	 * @access public
	 */
	public function filterCategory(){
		$categoryList = $this->mod_category->fetchCategoryTreeList();
		return View::make('backend.modules.category.filter_category')
		->with('categoryList',$categoryList);
	}

	/**
	 *
	 * createCategory: this function using for saving new category
	 * @return true if the data has been saved successfully
	 * @access public
	 */
	public function createCategory(){
		if(!$this->modUserGroup->isAccessPermission('admin/create-category')){
			return Redirect::to('admin/deny-permisson-page');
		}
		if(Input::has('btnSubmit')){
			if(!$this->modUserGroup->isModifyPermission('admin/create-category')){
				return Redirect::to('admin/categories')
				->with('ERROR_MODIFY_MESSAGE','You do not have permission to modify!');
			}
			$rules = array(
				'name_lml' => 'required|unique:m_category',
				'name_utf'=>'required|unique:m_category',
				'slug'=>'unique:m_category',
			);

					$validator = Validator::make(Input::all(), $rules);
					if ($validator->passes()) {
						$data = self::prepareDataBind();
						$this->mod_category->addSaveCategory($data);
						return Redirect::to('admin/categories')->with('SECCESS_MESSAGE','Category has been created');
					}else{
						return Redirect::to('admin/create-category')->withInput()->withErrors($validator);
					}
		}else{
			$categories = $this->mod_category->fetchCategoryTree();
			return View::make('backend.modules.category.add')->with('categories',$categories);
		}
	}

	/**
	 *
	 * editCategory: this function using for edit saved for category
	 * @param integer $id: the id of category
	 * @return true: if the category has been updated successfully
	 * @access public
	 */
	public function editCategory($id = null){
		if(!$this->modUserGroup->isAccessPermission('admin/edit-category')){
			return Redirect::to('admin/deny-permisson-page');
		}
		if(Input::has('btnSubmit')){
			if(!$this->modUserGroup->isModifyPermission('admin/edit-category')){
				return Redirect::to('admin/categories')
				->with('ERROR_MODIFY_MESSAGE','You do not have permission to modify!');
			}
			$id = Input::get('id');
			$rules = array(
				'name_lml' => 'required',
				'name_utf'=>'required',
			);

					$validator = Validator::make(Input::all(), $rules);
					if ($validator->passes()) {
						$data = self::prepareDataBind();
						$this->mod_category->editSaveCategory($id,$data);
						return Redirect::to('admin/categories')->with('SECCESS_MESSAGE','Category has been updated');
					}else{
						return Redirect::to('admin/edit-category/'.$id)->withInput()->withErrors($validator);
					}
		}
		$id = (integer) $id;
		$cagegoryById = $this->mod_category->getCategoryById($id);

		$categories = $this->mod_category->fetchCategoryTree();
		return View::make('backend.modules.category.edit')
		->with('categoryById',$cagegoryById->data)
		->with('categories',$categories);
	}

	/**
	 *
	 * deleteCategory: this function using for delete child of category depending on parent id
	 * @param integer $id: the id of category
	 * @return true: if the child category has been deleted
	 * @access public
	 */
	public function deleteCategory($id = null){
		if(!$this->modUserGroup->isModifyPermission('admin/delete-category')){
				return Redirect::to('admin/categories')
				->with('ERROR_MODIFY_MESSAGE','You do not have permission to modify!');
			}
		$id = (integer) $id;
		$this->mod_category->deleteCategory($id);
		return Redirect::to('admin/categories')->with('SECCESS_MESSAGE','Category has been deleted');
	}

	/**
	 *
	 * isPublicCategory: this function uisng for enable or disable status
	 * @param integer $id: the id of category
	 * @param integer $status: the status of category
	 * @return true: if the category status has been changed
	 * @access public
	 */
	public function isPublicCategory($id=null, $status=null){
		if(!$this->modUserGroup->isModifyPermission('admin/status-category')){
				return Redirect::to('admin/categories')
				->with('ERROR_MODIFY_MESSAGE','You do not have permission to modify!');
		}
		$id = (integer) $id;
		$status = (integer) $status;
		$this->mod_category->isStatusPublic($id, $status);
		return Redirect::to('admin/categories')->with('SECCESS_MESSAGE','Category status has been changed');
	}

	/**
	 *
	 * prepareDataBind: this function using for preparing data before inserting data into database
	 * @param param: Edit | Add
	 * @access private
	 * @return array object
	 */
	private static function prepareDataBind(){
		$invalid = array(
        'Š' => '&Scaron;',
        'š' => '&scaron;',
        'Ð' => '&ETH;',
        'Ž' => '&#381;',
        'ž' => '&#382;',
        'À' => '&Agrave;',
        'Á' => '&Aacute;',
        'Â' => '&Acirc;',
        'Ã' => '&Atilde;',
        'Ä' => '&Auml;',
        'Å' => '&Aring;',
        'Æ' => '&AElig;',
        'Ç' => '&Ccedil;',
        'È' => '&Egrave;',
        'É' => '&Eacute;',
        'Ê' => '&Ecirc;',
        'Ë' => '&Euml;',
        'Ì' => '&Igrave;',
        'Í' => '&Iacute;',
        'Î' => '&Icirc;',
        'Ï' => '&Iuml;',
        'Ñ' => '&Ntilde;',
        'Ò' => '&Ograve;',
        'Ó' => '&Oacute;',
        'Ô' => '&Ocirc;',
        'Õ' => '&Otilde;',
        'Ö' => '&Ouml;',
        'Ø' => '&Oslash;',
        'Ù' => '&Ugrave;',
        'Ú' => '&Uacute;',
        'Û' => '&Ucirc;',
        'Ü' => '&Uuml;',
        'Ý' => '&Yacute;',
        'Þ' => '&THORN;',
        'ß' => '&szlig;',
        'à' => '&agrave;',
        'á' => '&aacute;',
        'â' => '&acirc;',
        'ã' => '&atilde;',
        'ä' => '&auml;',
        'å' => '&aring;',
        'æ' => '&aelig;',
        'ç' => '&ccedil;',
        'è' => '&egrave;',
        'é' => '&eacute;',
        'ê' => '&ecirc;',
        'ë' => '&euml;',
        'ì' => '&igrave;',
        'í' => '&iacute;',
        'î' => '&icirc;',
        'ï' => '&iuml;',
        'ð' => '&eth;',
        'ñ' => '&ntilde;',
        'ò' => '&ograve;',
        'ó' => '&oacute;',
        'ô' => '&ocirc;',
        'õ' => '&otilde;',
        'ö' => '&ouml;',
        'ø' => '&oslash;',
        'ù' => '&ugrave;',
        'ú' => '&uacute;',
        'û' => '&ucirc;',
        'ý' => '&yacute;',
        'ý' => '&yacute;',
        'þ' => '&thorn;',
        'ÿ' => '&yuml;',
        'ƒ' => '&fnof;',
        "`" => "'",
        "´" => "'",
        "„" => ",",
        "`" => "'",
        "´" => "'",
        "“" => "\"",
        "”" => "\"",
        "´" => "'",
        "&acirc;€™" => "'",
        "{" => "",
        "~" => "",
        "–" => "-",
        "’" => "'",
        "°" => "&#176;",
        "º" => "&#176;",
    );

    $str = str_replace(array_keys($invalid), array_values($invalid), Input::get('name_lml'));
		if(!empty(Input::get('slug'))) {
			$cat_slug 		= Input::get('slug');
			$cat_slug 		= preg_replace("/[[:space:]]/", "-", $cat_slug);
			$cat_slug 		= strtolower($cat_slug);
		} else {
			$cat_slug 		= preg_replace("/[[:space:]]/", "-", $str);
			$cat_slug 		= strtolower($cat_slug);
		}
    	
		$data = array(
				'name_utf'=>trim(Input::get('name_utf')),
				'name_lml'=>trim($str),
				'slug'=>$cat_slug,
				'image'=>trim(Input::get('image')),
				'parent_id'=>trim(Input::get('parent_id'))
		);
		return $data;
	}

	public function decode_entities($text) {
	    $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
	    $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
	    $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
	    return $text;
	}
	/**
	 *
	 * __destruct: this is margic method using for auctomatically destroy unuseful object
	 * @return true: the unuseful object has been destroyed
	 *
	 */
	public function __destruct(){
		$this->mod_category;
	}
}
