<?php

class BeProductController extends BaseController {
	const PRODUCT_FREE_PAGE = 'backend.modules.product.list_products_free';
	const PRODUCT_PREMIUM_PAGE = 'backend.modules.product.list_products_premium';
	const FREE_USER_ACCOUNT = 1;
	const PREMIUM_USER_ACCOUNT = 2;
	const DISABLE_STATUS = 0;
	const ENABLE_STATUS = 1;
	protected $mod_post;
	protected $mod_category;
	protected $mod_store;
	function __construct() {
		$this->mod_category = new MCategory();
		$this->mod_post = new Post();
		$this->mod_store = new Store();
	}
	public function post()
	{
		$products = $this->searchOperation();
		return View::make('backend.modules.product.list_products')
			->with('products', $products);
	}
	public function add() {
		if(Input::has('addp')) {
            $rules = array (
					'file' => 'required',
					'unicode' => 'required',
					'limon' => 'required', 
			);
			$validator = Validator::make ( Input::all (), $rules );
			$Artist = Input::get('Artist');
			$artistDataArr = array();
			$artistSlugArr = array();
			$artistIDArr = array();
			if(!empty($Artist)) {
				$ArtistArr = explode(',', $Artist);
				if(!empty($ArtistArr)) {
					foreach ($ArtistArr as $term) {
						$getTerm = $this->mod_category->findCategoryBySlug('artist', $term);
						if(!empty($getTerm->result[0])) {
							$artistDataArr[] = $getTerm->result[0];
							array_push($artistSlugArr, $getTerm->result[0]->slug);
							array_push($artistIDArr, $getTerm->result[0]->id);
						}
					}
				}
			}
			
			$getRhythm = '';
			$getRhythmID = '';
			$getRhythmData = $this->mod_category->getCategoryById(Input::get('rhythm'));
			if(!empty($getRhythmData->data)) {
				$getRhythm = $getRhythmData->data->slug;
				$getRhythmID = $getRhythmData->data->id;
			}

			$getType = '';
			$getTypeID = '';
			$getTypeData = $this->mod_category->getCategoryById(Input::get('type'));
			if(!empty($getTypeData->data)) {
				$getType = $getTypeData->data->slug;
				$getTypeID = $getTypeData->data->id;
			}

			$getPro = '';
			$getProID = '';
			$getProData = $this->mod_category->getCategoryById(Input::get('production'));
			if(!empty($getProData->data)) {
				$getPro = $getProData->data->slug;
				$getProID = $getProData->data->id;
			}
			if ($validator->passes ()) {
				$files = Input::file('file');
				$destinationPath = base_path () . Config::get ( 'constants.DIR_IMAGE.DIR_MP3' );
				$mp3 = $this->mod_store->doUpoad ( $files, $destinationPath);

				$addVol = $this->mod_category->addCategoryByName($getPro . '-vol-' . Input::get('vol'));
				$volSlug = '';
				if($addVol) {
					echo $addVol;
					$volData = $this->mod_category->getCategoryById($addVol);
					if(!empty($volData)) {
						$volSlug = $volData->data->slug;
					}
				}

				$content = array(
	                'mp3' => $mp3['image'],
	                'artist' => $artistSlugArr,
	                'lyrict' => Input::get('image'),
	                'production' => $getPro,
	                'vol' => $volSlug,
	                'titleEnglist' => Input::get('english'),
	                'rhythm' => $getRhythm,
	                'type' => $getType,
	            );

				$nowtime = time();
	            $dataPost = array(
	                'title_utf' => trim(Input::get('unicode')),
	                'title_lml' => trim(Input::get('limon')),
	                'created_date' => $nowtime,
	                'status' => 1,
	                'content' => json_encode($content),
	            );
	            $getLastPostID = $this->mod_post->addPosts($dataPost);
	            if($getLastPostID) {
	            	/*add related category into a track*/
	                $cateInTrack = array(
	                    (int) $addVol,
	                    (int) $getProID,
	                    (int) $getRhythmID,
	                    (int) $getTypeID,
	                );
	                $dataCateInTrack = array_merge($artistIDArr, $cateInTrack);
	                foreach ($dataCateInTrack as $key => $value) {
	                	if(!empty($value)) {
		                		$dataCateRelated = array(
		                        'ppost_id'=>$getLastPostID,
		                        'category_id'=>$value,
		                    );
		                    $this->mod_post->addCategoryRelatedPosts($dataCateRelated);
	                	}
	                }
	                /*end add related category into a track*/

	                /*add url id*/
	                // $link = !empty($link) ? $link : $fileName;
	                // $dataGetUrl = array(
	                //     'url_to' => $getTrackId.'-'. $link,
	                //     'page_id' => $getTrackId,
	                //     'page_name' => 'songTrack',
	                // );
	                // insert($dbh, 'somneang_geturl',$dataGetUrl);
	                /*add url id*/
	            }
			} else {
				return Redirect::to ( 'admin/products/add' )->withInput ()->withErrors ( $validator );
			}
		} 
		
		return View::make('backend.modules.product.add');
	}


	public function getAjax() {
		$type = Input::get('p');
		switch ($type) {
			case 'artist':
				$name = Input::get('term');
				$All = $this->mod_category->findCategoryBySlug('artist', $name);
				$data = array();
				if(!empty($All->result)) {
					foreach ($All->result as $value) {
						$data[] = array(
							'id' => $value->slug,
							'label' => $value->name_lml
						);
					}
				}
				echo json_encode($data);
				break;
			
			default:
				# code...
				break;
		}
		die;
	}
	public function listAllProductsPremium()
	{
		$products = $this->searchOperation(self::PREMIUM_USER_ACCOUNT);
		
		return View::make(self::PRODUCT_PREMIUM_PAGE)
			->with('products', $products);
	}

	private function searchOperation()
	{
		$tblProduct = Config::get ('constants.TABLE_NAME.POST');
		$TblRelate = Config::get ('constants.TABLE_NAME.POST_IN_CATEGORY');
		$qb = DB::table($tblProduct .' AS pro');
		$qb->select(DB::raw('pro.id as pro_id, pro.*'));

		if (Input::has('title')) {
			$qb->where('pro.title_utf', Input::get('title'));
		}


		if (Input::has('date_create')) {
			$qb->where('pro.publish_date', Input::get('date_create'));
		}

		if (Input::has('status')) {
			$status = (Input::get('status') == 1) ? 1 : 0;
			$qb->where('pro.status', $status);
		}

		$qb->orderBy('pro.id','desc');
		$qb->groupBy('pro.id');
		$products = $qb->paginate(10);
		return $products;
	}

	public function disableAndEnableProduct($page, $productid, $status)
	{
		if ($status == 2) {
			$this->statusOperation($productid, self::DISABLE_STATUS);
		}

		if ($status == 1) {
			$this->statusOperation($productid, self::ENABLE_STATUS);
		}
		$redirectPage = ($page === 'free') ? 'admin/products/free' : 'admin/products/premium';
		
		return Redirect::to($redirectPage)
			->with('SMG_SUCCESS','Data has been saved successfully!'); 
	}

	public function deleteProduct($page, $productid)
	{
		$tblProduct = Config::get ('constants.TABLE_NAME.PRODUCT');
		$product = DB::table($tblProduct.' AS pro')
			->where('id', '=', $productid)
			->select(DB::raw('pro.id as pro_id, pro.*'))
			->first();
		$pictures = json_decode($product->pictures, true);
		$this->deletePictures($pictures);
		$this->deleteOperation($productid);

		$redirectPage = ($page === 'free') ? 'admin/products/free' : 'admin/products/premium';
		return Redirect::to($redirectPage)
			->with('SMG_SUCCESS','Record has been deleted successfully!'); 
	}

	private function statusOperation($productid, $status)
	{
		$tblProduct = Config::get ('constants.TABLE_NAME.PRODUCT');
		$products = DB::table($tblProduct)
			->where('id', '=', $productid)
			->update(array('admin_status' => $status));
	}

	private function deleteOperation($productid)
	{
		$tblProduct = Config::get ('constants.TABLE_NAME.PRODUCT');
		$products = DB::table($tblProduct)
			->where('id', '=', $productid)
			->delete();
	}

	private function deletePictures($pictures)
	{
		if (!empty($pictures)) {
			$destinationPath = base_path() . '/public/upload/product/';
	        $destinationThumb = $destinationPath.'thumb/';
			foreach ($pictures as $file) {
				if (!empty($file)) {
					File::delete($destinationPath . $file['pic']);
					File::delete($destinationThumb . $file['pic']);
				}
			}
		}
	}
}