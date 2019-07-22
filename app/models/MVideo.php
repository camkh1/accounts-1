<?php
class MVideo extends Eloquent {
	const PAGE_USER = 1;
	const PAGE_WEBSITE = 2;
	const POSITION_TOP = 1;
	const POSITION_BOTTOM = 2;
	protected $table = "videos";
	public $timestamps = false;
	public function getVideoBy($whereArr = array()) {
		$query = DB::table ( $this->table );
		if (! empty ( $whereArr )) {
			$query->where ( $whereArr );
		}
		$list = $query->first ();
		return $list;
	}
	/**
	 * getVideo : is a function for getting Main Page to display front page
	 *
	 * @param        	
	 *
	 * @return array : with no pagination
	 * @access public
	 * @author Socheat
	 */
	public function getVideo($id = null, $whereArr = array(),$limit=0) {
		$response = new stdClass ();
		try {
			if (! is_null ( $id )) {
				$where = array (
						'status' => 1,
						'id' => $id 
				);
			} else {
				$where = array (
						'status' => 1 
				);
			}
			if (! empty ( $whereArr )) {
				$byWhere = $whereArr;
			} else {
				$byWhere = $where;
			}
			$query = DB::table ( Config::get ( 'constants.TABLE_NAME.POST' ) );
			$query->select ( '*' );
			$query->where ( $byWhere );
			$query->orderBy ( 'created_date', 'DESC' );
			if(!empty($limit)) {
				$query->take ( $limit );
			} else {
				$query->take ( $this->getConfig ( 'browse_page' )->value );
			}
			
			$result = $query->get ();
			//$getVideos = $this->getVideoList ( $result );
			return $result;
		} catch ( \Exception $e ) {
			return 0;
			$response->errorMsg = $e->getMessage ();
		}
		
		return $response;
	}
	
	/**
	 * getVideo : is a function for getting Main Page to display front page
	 *
	 * @param        	
	 *
	 * @return array : with no pagination
	 * @access public
	 * @author Socheat
	 */
	public function getVideoLists($id = null, $whereArr = array()) {
		$limit = $this->getConfig ( 'browse_playlist' )->value;
		$response = new stdClass ();
		try {
			if (! is_null ( $id )) {
				$where = array (
						'status' => 1,
						'id' => $id 
				);
			} else {
				$where = array (
						'status' => 1 
				);
			}
			if (! empty ( $whereArr )) {
				$byWhere = $whereArr;
			} else {
				$byWhere = $where;
			}
			$result = DB::table ( Config::get ( 'constants.TABLE_NAME.POST' ) )
			->select ( '*' )
			->where ( $byWhere )
			->orderBy ( 'created_date', 'DESC' )
			->paginate ( $limit );
			$getVideos = $this->getVideoList ( $result, 'artist' );

			/*cate pagination*/
			$total_pages = $result->getTotal();
			$limit = $limit;
			$page = Input::get('page');
			if ($page == 0) $page = 1;
			$prev = $page - 1;                          //previous page is page - 1
		    $next = $page + 1;                          //next page is page + 1
		    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
		    $lpm1 = $lastpage - 1;
		    if($lastpage > 1) {
		    	$previous = $prev;
		    } else {
		    	$previous = null;
		    }
		    if ($page < $lastpage) {
		    	$next = $next;
		    } else {
		    	$next = null;
		    }
			/*end pagination*/
			$allList = array (
					'page' => $result->links (),
					'result' => $getVideos,
					'total' => $getVideos,
					'pagination' => array(
						'next'=> $next,
						'previous'=> $previous,
					)
			);
			return $allList;
		} catch ( \Exception $e ) {
			return 0;
			$response->errorMsg = $e->getMessage ();
		}
		
		return $response;
	}
	
	/**
	 * getVideo : is a function for getting Main Page to display front page
	 *
	 * @param
	 *
	 * @return array : with no pagination
	 * @access public
	 * @author Socheat
	 */
	public function getVideoListsByTag($slugId = null) {
		$response = new stdClass ();
		try {
			$Cat_id = array();
			$whereParent = array(
				'slug'=>$slugId
			);
			//$Cat_id[] = $cateID;
			$CateIn = $this->getCategory(null,$whereParent);			
			switch ($slugId) {
				case 'artist':
					$sub = 1;
					break;
				case 'production':
					$sub = 1;
					break;
				case 'rhythm':
					$sub = 1;
					break;
				case 'type':
					$sub = 1;
					break;
				case 'language':
					$sub = 1;
					break;
				default:
					$sub = 0;
					break;
			}
			if(!empty($CateIn[0])) {
				if(empty($sub)) {
					$Cat_id[] = $CateIn[0]->id;
				} else {
					$getCategory = new MCategory();
					$getAllCateIn = $getCategory->getAllChildCategories($CateIn[0]->id);
					if(is_array($getAllCateIn)) {
						foreach ($getAllCateIn as $tag) {
							if(is_array($tag)) {
								foreach ($tag as $SubTag) {
									$Cat_id[] = $SubTag;
								}
							} else {
								$Cat_id[] = $tag;
							}
						}
					}
				}

				$query = DB::table ( Config::get ( 'constants.TABLE_NAME.POST' ) .' as t' );
				$query->join('post_in_category as cat', 't.id', '=', 'cat.post_id');
				$query->whereIn('cat.category_id', $Cat_id);
				$query->orderBy ( 't.created_date', 'DESC' );
				$query->groupBy ( 't.id' );
				$data = $query->paginate ( $this->getConfig ( 'browse_playlist' )->value );
				//$getVideos = $this->getVideoList ( $result );
				// $allList = array (
				// 	'page' => $result->links (),
				// 	'result' => $getVideos,
				// 	'result_1' => $result,
				// );
			}
			$response->data = $data;
			$response->detail = $CateIn;
			return $response;
		} catch ( \Exception $e ) {
			return 0;
			$response->errorMsg = $e->getMessage ();
		}
	
		return $response;
	}
	/**
	 * make a video list
	 */
	public function getVideoList($param,$path='',$type=null) {
		$response = new stdClass ();
		$list = array ();
		$i = 0;
		try {
			foreach ( $param as $vdo ) {
				$i ++;
				$dataConent = json_decode($vdo->content);
				$list [$i] ['title_en'] = $dataConent->titleEnglist;
				$limonTitle = (!empty($vdo->title_lml))? '<span class="limon">'. $vdo->title_lml . '</span>' : $dataConent->titleEnglist;
				$list [$i] ['title_limon'] = $limonTitle;
				$list [$i] ['title_unicode'] = $vdo->title_utf;
				$sql_date = date ( 'Y-m-d', $vdo->created_date );

				$date_diff = round ( abs ( strtotime ( date ( 'Y-m-d' ) ) - strtotime ( $sql_date ) ) / 86400, 0 );
				if ($date_diff < $this->getConfig ( 'isnew_days' )->value) {
					$list [$i] ['new'] = true;
				}
				if ($vdo->view > $this->getConfig ( 'ispopular' )->value) {
					$list [$i] ['popular'] = true;
				}

				$ArtistArr = array();
				if(!empty($dataConent->artist)) {
					$category = new MCategory();
					$a = 0;
					foreach ($dataConent->artist as $getArtist) {
						$categoryData = $category->getCategoryBySlug($getArtist);
						if(!empty($categoryData)) {
							$artImage = $categoryData->image;
							$artName = $categoryData->name_lml;
							$artNameUnicode = $categoryData->name_utf;
							$ArtistArr[$a]['artName'] = array(
								'en' => $artName,
								'kh' => $artNameUnicode,
							);
							$ArtistArr[$a]['image'] = $this->phpThumPath($artImage, 'artist');
							$ArtistArr[$a]['link'] = Config::get('app.url') .'play/' . $this->makeVideoLink ( $categoryData->id,'category');
						}
						$a++;
					}
				}
				$images = $this->phpThumPath($dataConent->image, 'song');
				$lyrict = $this->phpThumPath($dataConent->lyrict, 'song');

				$list [$i] ['id'] = $vdo->id;
				$list [$i] ['link'] = $this->makeVideoLink ( $vdo->id,$type);
				$list [$i] ['mp3'] = $dataConent->mp3;
				$list [$i] ['artist'] = $ArtistArr;
				$list [$i] ['image'] = $images;
				$list [$i] ['lyrict'] = $lyrict;
				$list [$i] ['production'] = $dataConent->production;
				$list [$i] ['vol'] = $dataConent->vol;
				$list [$i] ['rhythm'] = $dataConent->rhythm;
				$list [$i] ['type'] = $dataConent->type;
				$list [$i] ['views'] = $this->vdo_compact_number_format ( $vdo->view );
			}
			return $list;
		} catch ( Exception $e ) {
			return array (
					'error' => $e->getMessage () 
			);
		}
	}

	/**
	 * make a video list
	 */
	public function getVideoCategoryList($param,$path='') {
		$response = new stdClass ();
		$list = array ();
		$i = 0;
		try {
			foreach ( $param as $vdo ) {
				$i ++;
				$list [$i] ['title_en'] = $vdo->name_lml;
				$list [$i] ['title_unicode'] = $vdo->name_utf;
				
				$sql_date = date ( 'Y-m-d', $vdo->created_date );

				$date_diff = round ( abs ( strtotime ( date ( 'Y-m-d' ) ) - strtotime ( $sql_date ) ) / 86400, 0 );
				if ($date_diff < $this->getConfig ( 'isnew_days' )->value) {
					$list [$i] ['new'] = true;
				}
				if ($vdo->view > $this->getConfig ( 'ispopular' )->value) {
					$list [$i] ['popular'] = true;
				}
				$images = $this->phpThumPath($vdo->image, $path);

				$list [$i] ['id'] = $vdo->id;
				$list [$i] ['link'] = $this->makeVideoLink ($vdo->id, 'category');
				$list [$i] ['image'] = $images . '&h=150&w=150';
				$list [$i] ['views'] = $this->vdo_compact_number_format ( $vdo->view );
			}
			return $list;
		} catch ( Exception $e ) {
			return array (
					'error' => $e->getMessage () 
			);
		}
	}
	/**
	 * make a video list
	 */
	public function getVideoDataList($param) {
		$response = new stdClass ();
		$list = array ();
		$i = 0;
		$dataList ='';
		try {
			foreach ( $param as $nVideo ) {
				$dataList .= '<li>';
				$dataList .= '<div class="pm-li-video">';
				$dataList .= '<div class="new_video">';
				$dataList .= '<span class="pm-video-thumb pm-thumb-145 pm-thumb border-radius2">';
				$dataList .= '<span class="pm-video-li-thumb-info">';
				if (@$nVideo ['new']) {
					$dataList .= '<span class="label label-new">New</span>';
				}
				if (@$nVideo ['popular']) {
					$dataList .= '<span class="label label-pop">Popular</span>';
				}				
				$dataList .= '</span>';
				$dataList .= '<a href="' . Config::get('app.url') .'play/'. $nVideo ['link'] . '" class="pm-thumb-fix pm-thumb-145" title="' . $nVideo ['title_en'] . '">';
				$dataList .= '<span class="pm-thumb-fix-clip">';
				$dataList .= '<img src="' . $nVideo ['image'] . '" width="145"/>';
				$dataList .= '<span class="vertical-align"></span>';
				$dataList .= '</span>';
				$dataList .= '</a>';
				$dataList .= '</span>';
				$dataList .= '</div>';
				$dataList .= '<h3 dir="ltr">';
				$dataList .= '<a href="' . $nVideo ['link'] . '" class="pm-title-link" title="' . $nVideo ['title_en'] . '">';
				$dataList .= $this->rm($nVideo ['title_en'],45);
				$dataList .= '</a>';
				$dataList .= '</h3>';
				$dataList .= '<div class="pm-video-attr">';
				$dataList .= '<span class="pm-video-attr-numbers"><small>' . $nVideo ['views'] . ' Views</small></span>';
				$dataList .= '</div>';
				$dataList .= '</div>';
				$dataList .= '</li>';
			}
			return $dataList;
		} catch ( Exception $e ) {
			return array (
					'error' => $e->getMessage ()
			);
		}
	}
	/**
	 * get config
	 */
	public function getConfig($name = '') {
		$byWhere = array ();
		if (! empty ( $name )) {
			$byWhere = array (
					'name' => $name 
			);
			$result = DB::table ( Config::get ( 'constants.TABLE_NAME.CONFIG' ) )->where ( $byWhere )->first ();
		} else {
			$result = DB::table ( Config::get ( 'constants.TABLE_NAME.CONFIG' ) )->get ();
		}
		return $result;
	}
	public function makeVideoLink($id, $type = 'songTrack') {
		$getData = DB::table ( Config::get ( 'constants.TABLE_NAME.GET_URL' ) )
		->where ('page_id','=',$id)
		->where ('page_name','=',$type)
		->first ();
		if(!empty($getData)) {
			$result = $getData->url_to;
		} else {
			$result = false;	
		}
		return $result;
	}
	
	/* getplaylist */
	public function getPlaylist($getPL, $num, $currentUrl, $image = 'http://3.bp.blogspot.com/-c9VaNAeHkGg/UQ4T7EPwlLI/AAAAAAAAAUQ/ns1lvSm5lf8/s100/fancybox_play-button-icon.png') {
		$currentUrl = Config::get ( 'app.url' ) . $currentUrl;
		$showbyNum = $getPL->playlist->$num;
		
		/* create iframe player */
		switch ($showbyNum->t) {
			case 'yt' :
				$iframe = 'http://www.youtube-nocookie.com/embed/' . $showbyNum->p;
				break;
			case 'vo' :
				$iframe = 'http://player.vimeo.com/video/' . $showbyNum->p;
				break;
			case 'gdo' :
				$iframe = 'https://docs.google.com/file/d/' . $showbyNum->p . '/preview';
				break;
			case 'gdr' :
				$iframe = 'https://docs.google.com/file/d/' . $showbyNum->p . '/preview';
				break;
			case 'dm' :
				$iframe = 'http://www.dailymotion.com/embed/video/' . $showbyNum->p . '?autoPlay=0&hideInfos=0';
				break;
			case 'vi' :
				//https://vid.me/e/yuPd?stats=1&amp;tools=1
				$iframe = 'https://vid.me/e/' . $showbyNum->p;
				break;
			case 'fb' :
				$iframe = 'http://facebook.hot-kh.com/vid.php?id=' . $showbyNum->p;
				break;
			default :
				$iframe = $showbyNum->p;
				break;
		}
		/* end create iframe player */
		
		/* create playlist */
		$geturl = $currentUrl . '?num=';
		if ($num == 0)
			$num = 1; // if no page var is given, default to 1.
		$prev = $num - 1; // previous page is page - 1
		$next = $num + 1; // next page is page + 1
		if ($num > 1) {
			$back = $geturl . $prev;
		} else {
			$back = 'javascript:;';
		}
		
		if ($num < $getPL->total_list) {
			$next = $geturl . $next;
		} else {
			$next = 'javascript:;';
		}
		
		$part = '<select class="paginate" onchange="window.location=&#39;' . $currentUrl . '?num=&#39;+this[this.selectedIndex].value+&#39;&#39;;return false">';
		for($x = 1; $x <= $getPL->total_list; $x ++) {
			if ($num == $x) {
				$selected = 'selected="selected"';
			} else {
				$selected = "";
			}
			$part .= '<option value="' . $x . '" ' . $selected . '>' . $x . '/'.$getPL->total_list.'</option>';
		}
		$part .= '</select>';
		$list = '<div class="video_playlist">';
		$list .= '<div class="borderTop">';
		$list .= '<a href="' . $back . '"><div class="nextStory" title="Prevous"></div></a>';
		$list .= '<a href="javascript:;" id="showlist"><img src="http://1.bp.blogspot.com/-lZBJez_AIUw/VPXwfOgkdFI/AAAAAAAAJ6w/fejlc8WK3uM/s1600/list.png"/></a>';
		$list .= '<a href="javascript:;" id="hidelist" style="display:none;"><img src="http://1.bp.blogspot.com/-DesBST0hqmw/VPXxUrdeClI/AAAAAAAAJ7A/MXq6JebWAMI/s1600/list.png"/></a>';
		$list .= '<div class="countStory">' . $part . '</div>';
		$list .= '<a href="' . $next . '"><div class="prevStory" title="Next"></div></a>';
		$list .= '</div>';
		$list .= '<div class="playlist" id="playlistbar" style="height:364px;overflow:auto">';
		$list .= '<div id="loadmore" style="">';
		$i = 0;
		if (! empty ( $getPL->playlist )) {
			foreach ( $getPL->playlist as $value ) {
				$i ++;
				$page = $num + $i - 1;
				$video_link = $geturl . $i;
				$list .= '<a title="Part ' . $i . '" href="' . $video_link . '">';
				if ($num == $i) {
					$classid = 'playing';
					$onId = "playing";
				} else {
					$onId = '';
					$classid = 'notplaying';
				}
				$list .= '<div class="wrapper_th ' . $classid . '" id="' . $onId . '">';
				$list .= '<div class="number_th">';
				if ($num == $i) {
					$list .= '&#9658;';
				} else {
					$list .= $i;
				}
				$list .= '</div>';
				switch ($value->t) {
					case 'yt' :
						$video_id = 'http://img.youtube.com/vi/' . $value->p . '/mqdefault.jpg';
						break;
					case 'dm' :
						$video_id = 'http://www.dailymotion.com/thumbnail/video/' . $value->p;
						break;
					default :
						$video_id = $image;
						break;
				}
				$list .= '<div class="th_image"><img width="64" height="40" src="' . $video_id . '" style="width:64px;height:40px"/></div>';
				$list .= '<div class="th_name">Part ' . $i . '</div>';
				$list .= '<div class="clear"></div>';
				$list .= '</div>';
				$list .= '</a>';
			}
			$list .= '</div>';
			$list .= '<div class="showAdsRight" style="margin:7px auto 0 7px;">Div1</div>';
			$list .= '</div>';
			$list .= '<div class="borderBottom"></div>';
			$list .= '</div>';
			$list .= '<div class="clear"></div>';
			/* end create playlist */
			
			$data = array(
				'video' => $iframe,
				'playlist' => $list,
			);
		} else {
			$data = array('error'=>'no list');
		}
		return $data;
	}
	/* clean html */
	public function sanitize_title($title) {
		$title = preg_replace ( '/[\x00-\x1F\x80-\xFF]/', '', $title );
		$title = strip_tags ( $title );
		// Preserve escaped octets.
		$title = preg_replace ( '|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title );
		// Remove percent signs that are not part of an octet.
		$title = str_replace ( '%', '', $title );
		// Restore octets.
		$title = preg_replace ( '|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title );
		
		$title = $this->removeAccents ( $title );
		if ($this->seems_utf8 ( $title )) {
			if (function_exists ( 'mb_strtolower' )) {
				$title = mb_strtolower ( $title, 'UTF-8' );
			}
			$title = $this->utf8_uri_encode ( $title, 200 );
		}
		$title = strtolower ( $title );
		$title = preg_replace ( '/&.+?;/', '', $title ); // kill entities
		$title = preg_replace ( '/[^%a-z0-9 _-]/', '', $title );
		$title = preg_replace ( '/\s+/', '-', $title );
		$title = preg_replace ( '|-+|', '-', $title );
		$title = trim ( $title, '-' );
		return $title;
	}

	/**
	 * get category
	 * */
	public function getCategory($id = array(), $byWhere = array(), $whereGetFirst=array()) {
		$query = DB::table ( 'm_category' );
		$query->select ( '*' );
		if(!empty($byWhere)) {
			$query->where ( $byWhere );
		}
		if(!empty($id)) {
			$query->whereIn('id', $id);
		}
		if(!empty($whereGetFirst)) {
			$query->where($whereGetFirst);
		}
		$query->orderBy ( 'name_lml', 'ASC');
		if(!empty($whereGetFirst)) {
			$result = $query->first();
		} else {
			$result = $query->get();
		}
		return $result;
	}

	/*update category view*/
	public function updateCategoryView($id) {
		$table = 'videos_categories';
		$query = DB::table ( $table );
		DB::update("UPDATE $table SET views = views+1 WHERE id = $id");
	}
	
	/*update video view*/
	public function updateVideoView($byWhere) {
		$table = Config::get ( 'constants.TABLE_NAME.VIDEO' );
		$query = DB::table ( $table );
		$Video = $query->where ( $byWhere )->first();
		DB::update("UPDATE $table SET site_views = site_views+1 WHERE id = $Video->id");
	}
	
	
	/*
	 * get page
	 * */
	public function getPage($byWhere =array(), $whereFirst = array()) {
		$table = Config::get ( 'constants.TABLE_NAME.vPage' );
		$query = DB::table ( $table );
		if(!empty($byWhere)) {
			$query->where ( $byWhere );
		}
		if(!empty($whereFirst)) {
			$query->where ( $whereFirst );
			$result = $query->first();
		} else {
			$result = $query->get();
		}
		return $result;
	}
	/*
	 * get get_related_video_list
	 * */
	public function getRelatedVideoList($category_id) {
		$query = DB::table (Config::get ( 'constants.TABLE_NAME.VIDEO' ));
		$query->select ( 'uniq_id','video_title', 'to_site_b','thumb', 'site_views','added','id','playlist' );
		$query->where('category', 'like', "%$category_id%");
		$query->orWhere('category', 'like', "%$category_id");
		$query->orWhere('category', 'like', "$category_id%");
		$query->orWhere('category', '=', $category_id);
		$query->orderByRaw("RAND()");
		$query->take($this->getConfig ( 'watch_related_limit' )->value);
		$result = $query->get();
		
		$list = $this->getVideoList($result);
    	return $list;
	}

	/*
	 * get search by keyword
	 * */
	public function getVideoByKeyword($keyword) {
		$query = DB::table (Config::get ( 'constants.TABLE_NAME.VIDEO' ) . ' as v');
		$query->join(Config::get ( 'constants.TABLE_NAME.VIDEO_RELATED'  ) . ' as re', 're.object_id', '=', 'v.uniq_id');
		$query->join(Config::get ( 'constants.TABLE_NAME.CATEGORY'  ) . ' as c', 'c.id', '=', 're.vdo_categories');
		$query->select ( 'uniq_id','video_title', 'to_site_b','thumb', 'site_views','added','v.id','playlist' );
		$query->where('v.status', '=', 1);
		$query->where(function($query) use ($keyword) {
                return $query->where('v.video_title', '=', $keyword)
                ->orWhere('c.name', 'like', "%$keyword%")
				->orWhere('v.video_title', 'like', "$keyword%")
				->orWhere('v.description', 'like', "$keyword%");
        });
		$query->orderBy ( 'added', 'DESC' );
		$query->groupBy ( 'v.uniq_id' );
		
		$result = $query->paginate ( $this->getConfig ( 'browse_page' )->value );
		$list = $this->getVideoList($result);
		$data = array(
			'paginate'=>$result->links(),
			'list'=>$list,
		);
		
		return $data;
	}
	/*
	 * getTopVideoList
	 * */
	public function getTopVideoList() {
		$query = DB::table (Config::get ( 'constants.TABLE_NAME.VIDEO' ));
		$query->select ( 'uniq_id','video_title', 'to_site_b','thumb', 'site_views','added','id','playlist' );
		$query->orderBy ( 'site_views', 'DESC' );
		$query->take($this->getConfig ( 'top_page_limit' )->value);
		$result = $query->get();
	
		$list = $this->getVideoList($result);
		return $list;
	}
	/**
	 * get video show in list
	 */
	public function queryVideoList($result) {
		$list = '';
    	$i = 0;
    	if(!empty($result)) {
    		foreach ($result as $vdo) {
    			$i ++;
    			$tiles = htmlspecialchars ( stripslashes ( $vdo->video_title ) );
    			$popular = 0;
    			$new = 0;
    			$sql_date = date ( 'Y-m-d', $vdo->added );
    			$date_diff = round ( abs ( strtotime ( date ( 'Y-m-d' ) ) - strtotime ( $sql_date ) ) / 86400, 0 );
    			if ($date_diff < $this->getConfig ( 'isnew_days' )->value) {
    				$new = 1;
    			}
    			if ($vdo->site_views > $this->getConfig ( 'ispopular' )->value) {
    				$popular = 1;
    			}
    			$id = $vdo->id;
    			$link = $this->makeVideoLink ( $vdo->uniq_id, $vdo->video_title, null, $vdo->to_site_b );
    			$thumb = $this->resizeImage ( $vdo->thumb, 'w100-h60-p' );
    			$title = preg_replace ( '/[\x00-\x1F\x80-\xFF]/', '', $tiles );
    			$views = $this->vdo_compact_number_format ( $vdo->site_views );
    			
    			$list .= '<li>';
    			$list .= '<div class="pm-li-top-videos">';
    			$list .= '<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">';
				$list .= '<span class="pm-video-li-thumb-info">';
				if ($new) {
					$list .= '<span class="label label-new">New</span>';
				}
				if ($popular) {
					$list .= '<span class="label label-pop">Popular</span>';
				}
				if ($vdo->to_site_b == 1) {
					$target = "_blank";
				} else {
					$target = "";
				}
				$list .= '<span class="pm-label-duration border-radius3 opac7">' . json_decode ( $vdo->playlist )->total_list . ' Parts</span>';
				$list .= '</span>';
				$list .= '<div class="top_video_thumb">';
				$list .= '<a href="' . $link . '" target="' . $target . '" class="pm-thumb-fix pm-thumb-106">';
				$list .= '<span class="pm-thumb-fix-clip">';
				$list .= '<img src="' . $thumb . '" width="106"/>';
				$list .= '<span class="vertical-align"></span>';
				$list .= '</span>';
				$list .= '</a>';
				$list .= '</div>';
				$list .= '</span>';
				$list .= '<h3 dir="ltr">';
				$list .= '<a href="' . $link . '" target="' . $target . '" class="pm-title-link"  title="' . $title . '">';
				$list .= $this->rm($title,45);
				$list .= '</a>';
				$list .= '</h3>';
				$list .= '<span class="pm-video-attr-numbers"><small>' . $views . ' Views</small></span>';
    			$list .= '</div>';
    			$list .= '</li>';
    		}
    	}
    	return $list;
	}
	
	/**
	 * get video show in list
	 */
	public function queryVideoSlideList($result) {
		$list = '';
		$i = 0;
		if(!empty($result)) {
			foreach ($result as $vdo) {
				$i ++;
				$tiles = htmlspecialchars ( stripslashes ( $vdo->video_title ) );
				$new = 0;
				$sql_date = date ( 'Y-m-d', $vdo->added );
				$date_diff = round ( abs ( strtotime ( date ( 'Y-m-d' ) ) - strtotime ( $sql_date ) ) / 86400, 0 );
				if ($date_diff < $this->getConfig ( 'isnew_days' )->value) {
					$new = 1;
				}
				$popular = 0;
				if ($vdo->site_views > $this->getConfig ( 'ispopular' )->value) {
					$popular = 1;
				}
				$id = $vdo->id;
				$link = $this->makeVideoLink ( $vdo->uniq_id, $vdo->video_title, null, $vdo->to_site_b );
				$thumb = $this->resizeImage ( $vdo->thumb, 'w200-h160-p' );
				$title = preg_replace ( '/[\x00-\x1F\x80-\xFF]/', '', $tiles );
				$views = $this->vdo_compact_number_format ( $vdo->site_views );
				 
				$list .= '<div class="item slide">';
				$list .= '<div class="pm-li-video">';
				$list .= '<span class="pm-video-thumb pm-thumb-145 pm-thumb border-radius2">';
				$list .= '<span class="pm-video-li-thumb-info">';
				if ($new) {
					$list .= '<span class="label label-new">New</span>';
				}
				if ($popular) {
					$list .= '<span class="label label-pop">Popular</span>';
				}
				if ($vdo->to_site_b == 1) {
					$target = "_blank";
				} else {
					$target = "";
				}
				$list .= '<span class="pm-label-duration border-radius3 opac7">' . json_decode ( $vdo->playlist )->total_list . ' Parts</span>';
				$list .= '</span>';
				$list .= '<a href="' . $link . '" target="' . $target . '" class="pm-thumb-fix pm-thumb-145">';
				$list .= '<span class="pm-thumb-fix-clip">';
				$list .= '<img src="' . $thumb . '" width="145"/>';
				$list .= '<span class="vertical-align"></span>';
				$list .= '</span>';
				$list .= '</a>';
				$list .= '</span>';
				$list .= '<h3 dir="ltr">';
				$list .= '<a href="' . $link . '" target="' . $target . '" class="pm-title-link" title="'.$title.'">';
				$list .= $this->rm($title,45);
				$list .= '</a>';
				$list .= '</h3>';
				$list .= '<span class="pm-video-attr-numbers"><small>' . $views . ' Views</small></span>';
				$list .= '</div>';
				$list .= '</div>';
			}
		}
		return $list;
	}
	/**
	 * 
	 * resize image from blogger
	 */
	public function resizeImage($url, $imgsize) {
		if (preg_match ( '/blogspot/', $url )) {
			// inital value
			$newsize = $imgsize;
			$newurl = "";
			// Get Segments
			$path = parse_url ( $url, PHP_URL_PATH );
			$segments = explode ( '/', rtrim ( $path, '/' ) );
			// Get URL Protocol and Domain
			$parsed_url = parse_url ( $url );
			$domain = $parsed_url ['scheme'] . "://" . $parsed_url ['host'];
			
			$newurl_segments = array (
					$domain . "/",
					$segments [1] . "/",
					$segments [2] . "/",
					$segments [3] . "/",
					$segments [4] . "/",
					$newsize . "/", // change this value
					$segments [6] 
			);
			$newurl_segments_count = count ( $newurl_segments );
			for($i = 0; $i < $newurl_segments_count; $i ++) {
				$newurl = $newurl . $newurl_segments [$i];
			}
			return $newurl;
		} else {
			return $url;
		}
	}
	public function utf8_uri_encode($utf8_string, $length = 0) {
		$unicode = '';
		$values = array ();
		$num_octets = 1;
		for($i = 0; $i < strlen ( $utf8_string ); $i ++) {
			$value = ord ( $utf8_string [$i] );
			if ($value < 128) {
				if ($length && (strlen ( $unicode ) + 1 > $length))
					break;
				$unicode .= chr ( $value );
			} else {
				if (count ( $values ) == 0)
					$num_octets = ($value < 224) ? 2 : 3;
				$values [] = $value;
				if ($length && ((strlen ( $unicode ) + ($num_octets * 3)) > $length))
					break;
				if (count ( $values ) == $num_octets) {
					if ($num_octets == 3) {
						$unicode .= '%' . dechex ( $values [0] ) . '%' . dechex ( $values [1] ) . '%' . dechex ( $values [2] );
					} else {
						$unicode .= '%' . dechex ( $values [0] ) . '%' . dechex ( $values [1] );
					}
					$values = array ();
					$num_octets = 1;
				}
			}
		}
		return $unicode;
	}
	public function seems_utf8($str) { // @used by WordPress
		$length = strlen ( $str );
		for($i = 0; $i < $length; $i ++) {
			$c = ord ( $str [$i] );
			if ($c < 0x80)
				$n = 0; // 0bbbbbbb
			elseif (($c & 0xE0) == 0xC0)
				$n = 1; // 110bbbbb
			elseif (($c & 0xF0) == 0xE0)
				$n = 2; // 1110bbbb
			elseif (($c & 0xF8) == 0xF0)
				$n = 3; // 11110bbb
			elseif (($c & 0xFC) == 0xF8)
				$n = 4; // 111110bb
			elseif (($c & 0xFE) == 0xFC)
				$n = 5; // 1111110b
			else
				return false; // Does not match any model
			for($j = 0; $j < $n; $j ++) { // n bytes matching 10bbbbbb follow ?
				if ((++ $i == $length) || ((ord ( $str [$i] ) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
	/* remove charator */
	public function removeAccents($string) { // @used by WordPress
		if (! preg_match ( '/[\x80-\xff]/', $string ))
			return $string;
		
		if ($this->seems_utf8 ( $string )) {
			$chars = array (
					// Decompositions for Latin-1 Supplement
					chr ( 194 ) . chr ( 170 ) => 'a',
					chr ( 194 ) . chr ( 186 ) => 'o',
					chr ( 195 ) . chr ( 128 ) => 'A',
					chr ( 195 ) . chr ( 129 ) => 'A',
					chr ( 195 ) . chr ( 130 ) => 'A',
					chr ( 195 ) . chr ( 131 ) => 'A',
					chr ( 195 ) . chr ( 132 ) => 'A',
					chr ( 195 ) . chr ( 133 ) => 'A',
					chr ( 195 ) . chr ( 134 ) => 'AE',
					chr ( 195 ) . chr ( 135 ) => 'C',
					chr ( 195 ) . chr ( 136 ) => 'E',
					chr ( 195 ) . chr ( 137 ) => 'E',
					chr ( 195 ) . chr ( 138 ) => 'E',
					chr ( 195 ) . chr ( 139 ) => 'E',
					chr ( 195 ) . chr ( 140 ) => 'I',
					chr ( 195 ) . chr ( 141 ) => 'I',
					chr ( 195 ) . chr ( 142 ) => 'I',
					chr ( 195 ) . chr ( 143 ) => 'I',
					chr ( 195 ) . chr ( 144 ) => 'D',
					chr ( 195 ) . chr ( 145 ) => 'N',
					chr ( 195 ) . chr ( 146 ) => 'O',
					chr ( 195 ) . chr ( 147 ) => 'O',
					chr ( 195 ) . chr ( 148 ) => 'O',
					chr ( 195 ) . chr ( 149 ) => 'O',
					chr ( 195 ) . chr ( 150 ) => 'O',
					chr ( 195 ) . chr ( 153 ) => 'U',
					chr ( 195 ) . chr ( 154 ) => 'U',
					chr ( 195 ) . chr ( 155 ) => 'U',
					chr ( 195 ) . chr ( 156 ) => 'U',
					chr ( 195 ) . chr ( 157 ) => 'Y',
					chr ( 195 ) . chr ( 158 ) => 'TH',
					chr ( 195 ) . chr ( 159 ) => 's',
					chr ( 195 ) . chr ( 160 ) => 'a',
					chr ( 195 ) . chr ( 161 ) => 'a',
					chr ( 195 ) . chr ( 162 ) => 'a',
					chr ( 195 ) . chr ( 163 ) => 'a',
					chr ( 195 ) . chr ( 164 ) => 'a',
					chr ( 195 ) . chr ( 165 ) => 'a',
					chr ( 195 ) . chr ( 166 ) => 'ae',
					chr ( 195 ) . chr ( 167 ) => 'c',
					chr ( 195 ) . chr ( 168 ) => 'e',
					chr ( 195 ) . chr ( 169 ) => 'e',
					chr ( 195 ) . chr ( 170 ) => 'e',
					chr ( 195 ) . chr ( 171 ) => 'e',
					chr ( 195 ) . chr ( 172 ) => 'i',
					chr ( 195 ) . chr ( 173 ) => 'i',
					chr ( 195 ) . chr ( 174 ) => 'i',
					chr ( 195 ) . chr ( 175 ) => 'i',
					chr ( 195 ) . chr ( 176 ) => 'd',
					chr ( 195 ) . chr ( 177 ) => 'n',
					chr ( 195 ) . chr ( 178 ) => 'o',
					chr ( 195 ) . chr ( 179 ) => 'o',
					chr ( 195 ) . chr ( 180 ) => 'o',
					chr ( 195 ) . chr ( 181 ) => 'o',
					chr ( 195 ) . chr ( 182 ) => 'o',
					chr ( 195 ) . chr ( 184 ) => 'o',
					chr ( 195 ) . chr ( 185 ) => 'u',
					chr ( 195 ) . chr ( 186 ) => 'u',
					chr ( 195 ) . chr ( 187 ) => 'u',
					chr ( 195 ) . chr ( 188 ) => 'u',
					chr ( 195 ) . chr ( 189 ) => 'y',
					chr ( 195 ) . chr ( 190 ) => 'th',
					chr ( 195 ) . chr ( 191 ) => 'y',
					chr ( 195 ) . chr ( 152 ) => 'O',
					// Decompositions for Latin Extended-A
					chr ( 196 ) . chr ( 128 ) => 'A',
					chr ( 196 ) . chr ( 129 ) => 'a',
					chr ( 196 ) . chr ( 130 ) => 'A',
					chr ( 196 ) . chr ( 131 ) => 'a',
					chr ( 196 ) . chr ( 132 ) => 'A',
					chr ( 196 ) . chr ( 133 ) => 'a',
					chr ( 196 ) . chr ( 134 ) => 'C',
					chr ( 196 ) . chr ( 135 ) => 'c',
					chr ( 196 ) . chr ( 136 ) => 'C',
					chr ( 196 ) . chr ( 137 ) => 'c',
					chr ( 196 ) . chr ( 138 ) => 'C',
					chr ( 196 ) . chr ( 139 ) => 'c',
					chr ( 196 ) . chr ( 140 ) => 'C',
					chr ( 196 ) . chr ( 141 ) => 'c',
					chr ( 196 ) . chr ( 142 ) => 'D',
					chr ( 196 ) . chr ( 143 ) => 'd',
					chr ( 196 ) . chr ( 144 ) => 'D',
					chr ( 196 ) . chr ( 145 ) => 'd',
					chr ( 196 ) . chr ( 146 ) => 'E',
					chr ( 196 ) . chr ( 147 ) => 'e',
					chr ( 196 ) . chr ( 148 ) => 'E',
					chr ( 196 ) . chr ( 149 ) => 'e',
					chr ( 196 ) . chr ( 150 ) => 'E',
					chr ( 196 ) . chr ( 151 ) => 'e',
					chr ( 196 ) . chr ( 152 ) => 'E',
					chr ( 196 ) . chr ( 153 ) => 'e',
					chr ( 196 ) . chr ( 154 ) => 'E',
					chr ( 196 ) . chr ( 155 ) => 'e',
					chr ( 196 ) . chr ( 156 ) => 'G',
					chr ( 196 ) . chr ( 157 ) => 'g',
					chr ( 196 ) . chr ( 158 ) => 'G',
					chr ( 196 ) . chr ( 159 ) => 'g',
					chr ( 196 ) . chr ( 160 ) => 'G',
					chr ( 196 ) . chr ( 161 ) => 'g',
					chr ( 196 ) . chr ( 162 ) => 'G',
					chr ( 196 ) . chr ( 163 ) => 'g',
					chr ( 196 ) . chr ( 164 ) => 'H',
					chr ( 196 ) . chr ( 165 ) => 'h',
					chr ( 196 ) . chr ( 166 ) => 'H',
					chr ( 196 ) . chr ( 167 ) => 'h',
					chr ( 196 ) . chr ( 168 ) => 'I',
					chr ( 196 ) . chr ( 169 ) => 'i',
					chr ( 196 ) . chr ( 170 ) => 'I',
					chr ( 196 ) . chr ( 171 ) => 'i',
					chr ( 196 ) . chr ( 172 ) => 'I',
					chr ( 196 ) . chr ( 173 ) => 'i',
					chr ( 196 ) . chr ( 174 ) => 'I',
					chr ( 196 ) . chr ( 175 ) => 'i',
					chr ( 196 ) . chr ( 176 ) => 'I',
					chr ( 196 ) . chr ( 177 ) => 'i',
					chr ( 196 ) . chr ( 178 ) => 'IJ',
					chr ( 196 ) . chr ( 179 ) => 'ij',
					chr ( 196 ) . chr ( 180 ) => 'J',
					chr ( 196 ) . chr ( 181 ) => 'j',
					chr ( 196 ) . chr ( 182 ) => 'K',
					chr ( 196 ) . chr ( 183 ) => 'k',
					chr ( 196 ) . chr ( 184 ) => 'k',
					chr ( 196 ) . chr ( 185 ) => 'L',
					chr ( 196 ) . chr ( 186 ) => 'l',
					chr ( 196 ) . chr ( 187 ) => 'L',
					chr ( 196 ) . chr ( 188 ) => 'l',
					chr ( 196 ) . chr ( 189 ) => 'L',
					chr ( 196 ) . chr ( 190 ) => 'l',
					chr ( 196 ) . chr ( 191 ) => 'L',
					chr ( 197 ) . chr ( 128 ) => 'l',
					chr ( 197 ) . chr ( 129 ) => 'L',
					chr ( 197 ) . chr ( 130 ) => 'l',
					chr ( 197 ) . chr ( 131 ) => 'N',
					chr ( 197 ) . chr ( 132 ) => 'n',
					chr ( 197 ) . chr ( 133 ) => 'N',
					chr ( 197 ) . chr ( 134 ) => 'n',
					chr ( 197 ) . chr ( 135 ) => 'N',
					chr ( 197 ) . chr ( 136 ) => 'n',
					chr ( 197 ) . chr ( 137 ) => 'N',
					chr ( 197 ) . chr ( 138 ) => 'n',
					chr ( 197 ) . chr ( 139 ) => 'N',
					chr ( 197 ) . chr ( 140 ) => 'O',
					chr ( 197 ) . chr ( 141 ) => 'o',
					chr ( 197 ) . chr ( 142 ) => 'O',
					chr ( 197 ) . chr ( 143 ) => 'o',
					chr ( 197 ) . chr ( 144 ) => 'O',
					chr ( 197 ) . chr ( 145 ) => 'o',
					chr ( 197 ) . chr ( 146 ) => 'OE',
					chr ( 197 ) . chr ( 147 ) => 'oe',
					chr ( 197 ) . chr ( 148 ) => 'R',
					chr ( 197 ) . chr ( 149 ) => 'r',
					chr ( 197 ) . chr ( 150 ) => 'R',
					chr ( 197 ) . chr ( 151 ) => 'r',
					chr ( 197 ) . chr ( 152 ) => 'R',
					chr ( 197 ) . chr ( 153 ) => 'r',
					chr ( 197 ) . chr ( 154 ) => 'S',
					chr ( 197 ) . chr ( 155 ) => 's',
					chr ( 197 ) . chr ( 156 ) => 'S',
					chr ( 197 ) . chr ( 157 ) => 's',
					chr ( 197 ) . chr ( 158 ) => 'S',
					chr ( 197 ) . chr ( 159 ) => 's',
					chr ( 197 ) . chr ( 160 ) => 'S',
					chr ( 197 ) . chr ( 161 ) => 's',
					chr ( 197 ) . chr ( 162 ) => 'T',
					chr ( 197 ) . chr ( 163 ) => 't',
					chr ( 197 ) . chr ( 164 ) => 'T',
					chr ( 197 ) . chr ( 165 ) => 't',
					chr ( 197 ) . chr ( 166 ) => 'T',
					chr ( 197 ) . chr ( 167 ) => 't',
					chr ( 197 ) . chr ( 168 ) => 'U',
					chr ( 197 ) . chr ( 169 ) => 'u',
					chr ( 197 ) . chr ( 170 ) => 'U',
					chr ( 197 ) . chr ( 171 ) => 'u',
					chr ( 197 ) . chr ( 172 ) => 'U',
					chr ( 197 ) . chr ( 173 ) => 'u',
					chr ( 197 ) . chr ( 174 ) => 'U',
					chr ( 197 ) . chr ( 175 ) => 'u',
					chr ( 197 ) . chr ( 176 ) => 'U',
					chr ( 197 ) . chr ( 177 ) => 'u',
					chr ( 197 ) . chr ( 178 ) => 'U',
					chr ( 197 ) . chr ( 179 ) => 'u',
					chr ( 197 ) . chr ( 180 ) => 'W',
					chr ( 197 ) . chr ( 181 ) => 'w',
					chr ( 197 ) . chr ( 182 ) => 'Y',
					chr ( 197 ) . chr ( 183 ) => 'y',
					chr ( 197 ) . chr ( 184 ) => 'Y',
					chr ( 197 ) . chr ( 185 ) => 'Z',
					chr ( 197 ) . chr ( 186 ) => 'z',
					chr ( 197 ) . chr ( 187 ) => 'Z',
					chr ( 197 ) . chr ( 188 ) => 'z',
					chr ( 197 ) . chr ( 189 ) => 'Z',
					chr ( 197 ) . chr ( 190 ) => 'z',
					chr ( 197 ) . chr ( 191 ) => 's',
					// Decompositions for Latin Extended-B
					chr ( 200 ) . chr ( 152 ) => 'S',
					chr ( 200 ) . chr ( 153 ) => 's',
					chr ( 200 ) . chr ( 154 ) => 'T',
					chr ( 200 ) . chr ( 155 ) => 't',
					// Euro Sign
					chr ( 226 ) . chr ( 130 ) . chr ( 172 ) => 'E',
					// GBP (Pound) Sign
					chr ( 194 ) . chr ( 163 ) => '',
					// Vowels with diacritic (Vietnamese)
					// unmarked
					chr ( 198 ) . chr ( 160 ) => 'O',
					chr ( 198 ) . chr ( 161 ) => 'o',
					chr ( 198 ) . chr ( 175 ) => 'U',
					chr ( 198 ) . chr ( 176 ) => 'u',
					// grave accent
					chr ( 225 ) . chr ( 186 ) . chr ( 166 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 167 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 176 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 177 ) => 'a',
					chr ( 225 ) . chr ( 187 ) . chr ( 128 ) => 'E',
					chr ( 225 ) . chr ( 187 ) . chr ( 129 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 146 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 147 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 156 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 157 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 170 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 171 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 178 ) => 'Y',
					chr ( 225 ) . chr ( 187 ) . chr ( 179 ) => 'y',
					// hook
					chr ( 225 ) . chr ( 186 ) . chr ( 162 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 163 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 168 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 169 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 178 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 179 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 186 ) => 'E',
					chr ( 225 ) . chr ( 186 ) . chr ( 187 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 130 ) => 'E',
					chr ( 225 ) . chr ( 187 ) . chr ( 131 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 136 ) => 'I',
					chr ( 225 ) . chr ( 187 ) . chr ( 137 ) => 'i',
					chr ( 225 ) . chr ( 187 ) . chr ( 142 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 143 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 148 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 149 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 158 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 159 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 166 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 167 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 172 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 173 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 182 ) => 'Y',
					chr ( 225 ) . chr ( 187 ) . chr ( 183 ) => 'y',
					// tilde
					chr ( 225 ) . chr ( 186 ) . chr ( 170 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 171 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 180 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 181 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 188 ) => 'E',
					chr ( 225 ) . chr ( 186 ) . chr ( 189 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 132 ) => 'E',
					chr ( 225 ) . chr ( 187 ) . chr ( 133 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 150 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 151 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 160 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 161 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 174 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 175 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 184 ) => 'Y',
					chr ( 225 ) . chr ( 187 ) . chr ( 185 ) => 'y',
					// acute accent
					chr ( 225 ) . chr ( 186 ) . chr ( 164 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 165 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 174 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 175 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 190 ) => 'E',
					chr ( 225 ) . chr ( 186 ) . chr ( 191 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 144 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 145 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 154 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 155 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 168 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 169 ) => 'u',
					// dot below
					chr ( 225 ) . chr ( 186 ) . chr ( 160 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 161 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 172 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 173 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 182 ) => 'A',
					chr ( 225 ) . chr ( 186 ) . chr ( 183 ) => 'a',
					chr ( 225 ) . chr ( 186 ) . chr ( 184 ) => 'E',
					chr ( 225 ) . chr ( 186 ) . chr ( 185 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 134 ) => 'E',
					chr ( 225 ) . chr ( 187 ) . chr ( 135 ) => 'e',
					chr ( 225 ) . chr ( 187 ) . chr ( 138 ) => 'I',
					chr ( 225 ) . chr ( 187 ) . chr ( 139 ) => 'i',
					chr ( 225 ) . chr ( 187 ) . chr ( 140 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 141 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 152 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 153 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 162 ) => 'O',
					chr ( 225 ) . chr ( 187 ) . chr ( 163 ) => 'o',
					chr ( 225 ) . chr ( 187 ) . chr ( 164 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 165 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 176 ) => 'U',
					chr ( 225 ) . chr ( 187 ) . chr ( 177 ) => 'u',
					chr ( 225 ) . chr ( 187 ) . chr ( 180 ) => 'Y',
					chr ( 225 ) . chr ( 187 ) . chr ( 181 ) => 'y',
					// Vowels with diacritic (Chinese, Hanyu Pinyin)
					chr ( 201 ) . chr ( 145 ) => 'a',
					// macron
					chr ( 199 ) . chr ( 149 ) => 'U',
					chr ( 199 ) . chr ( 150 ) => 'u',
					// acute accent
					chr ( 199 ) . chr ( 151 ) => 'U',
					chr ( 199 ) . chr ( 152 ) => 'u',
					// caron
					chr ( 199 ) . chr ( 141 ) => 'A',
					chr ( 199 ) . chr ( 142 ) => 'a',
					chr ( 199 ) . chr ( 143 ) => 'I',
					chr ( 199 ) . chr ( 144 ) => 'i',
					chr ( 199 ) . chr ( 145 ) => 'O',
					chr ( 199 ) . chr ( 146 ) => 'o',
					chr ( 199 ) . chr ( 147 ) => 'U',
					chr ( 199 ) . chr ( 148 ) => 'u',
					chr ( 199 ) . chr ( 153 ) => 'U',
					chr ( 199 ) . chr ( 154 ) => 'u',
					// grave accent
					chr ( 199 ) . chr ( 155 ) => 'U',
					chr ( 199 ) . chr ( 156 ) => 'u' 
			);
			
			$string = strtr ( $string, $chars );
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars ['in'] = chr ( 128 ) . chr ( 131 ) . chr ( 138 ) . chr ( 142 ) . chr ( 154 ) . chr ( 158 ) . chr ( 159 ) . chr ( 162 ) . chr ( 165 ) . chr ( 181 ) . chr ( 192 ) . chr ( 193 ) . chr ( 194 ) . chr ( 195 ) . chr ( 196 ) . chr ( 197 ) . chr ( 199 ) . chr ( 200 ) . chr ( 201 ) . chr ( 202 ) . chr ( 203 ) . chr ( 204 ) . chr ( 205 ) . chr ( 206 ) . chr ( 207 ) . chr ( 209 ) . chr ( 210 ) . chr ( 211 ) . chr ( 212 ) . chr ( 213 ) . chr ( 214 ) . chr ( 216 ) . chr ( 217 ) . chr ( 218 ) . chr ( 219 ) . chr ( 220 ) . chr ( 221 ) . chr ( 224 ) . chr ( 225 ) . chr ( 226 ) . chr ( 227 ) . chr ( 228 ) . chr ( 229 ) . chr ( 231 ) . chr ( 232 ) . chr ( 233 ) . chr ( 234 ) . chr ( 235 ) . chr ( 236 ) . chr ( 237 ) . chr ( 238 ) . chr ( 239 ) . chr ( 241 ) . chr ( 242 ) . chr ( 243 ) . chr ( 244 ) . chr ( 245 ) . chr ( 246 ) . chr ( 248 ) . chr ( 249 ) . chr ( 250 ) . chr ( 251 ) . chr ( 252 ) . chr ( 253 ) . chr ( 255 );
			
			$chars ['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
			
			$string = strtr ( $string, $chars ['in'], $chars ['out'] );
			$double_chars ['in'] = array (
					chr ( 140 ),
					chr ( 156 ),
					chr ( 198 ),
					chr ( 208 ),
					chr ( 222 ),
					chr ( 223 ),
					chr ( 230 ),
					chr ( 240 ),
					chr ( 254 ) 
			);
			$double_chars ['out'] = array (
					'OE',
					'oe',
					'AE',
					'DH',
					'TH',
					'ss',
					'ae',
					'dh',
					'th' 
			);
			$string = str_replace ( $double_chars ['in'], $double_chars ['out'], $string );
		}
		
		return $string;
	}
	public function vdo_number_format($number, $decimals = 0, $dec_point = '.', $thousands_sep = ',') {
		return number_format ( $number, $decimals, $dec_point, $thousands_sep );
	}
	public function vdo_compact_number_format($number) {
		if ($number < 10000) {
			return $this->vdo_number_format ( $number );
		}
		$d = $number < 1000000 ? 1000 : 1000000;
		$f = round ( $number / $d, 1 );
		
		return $this->vdo_number_format ( $f, $f - intval ( $f ) ? 1 : 0 ) . ($d == 1000 ? 'k' : 'M');
	}
	
	public function rm($article, $char) {
		$article = preg_replace ( "/<img[^>]+\>/i", "(image)", $article );
		$article = strip_tags($article);
		$article = preg_replace ( "/(\r?\n){2,}/", "\n\n", $article );
		if (strlen ( $article ) > $char) {
			return substr ( $article, 0, $char ) . '...';
		} else
			return $article;
	}

	/*get image path*/
	public function phpThumPath($image,$path) {

		if(preg_match('/http:/', $image)) {
			$images = $image;
		} else {
			if(preg_match('/product/', $image)) {
				$path = 'image';
			}

			if($image == '') {
				$images = 'no-image-175x175.jpg';
			} else {
				$filename = Config::get ( 'constants.DIR_IMAGE.DEFAULT' ) .$path .'/'. $image;
				if (file_exists($filename)) {
				    $images = $image;
				} else {
				    $images = 'no-image-175x175.jpg';
				}
			}
			$ext = pathinfo($images, PATHINFO_EXTENSION);
			$allowed =  array('gif','png' ,'jpg');
			if(!in_array($ext,$allowed) ) {
			    $images = 'no-image-175x175.jpg';
			    $images = Config::get('app.url') . 'image/phpthumb/' . $images . '?p=' . $path;
			} else {
				$images = str_replace('/', '|', $images);
				$images = Config::get('app.url') . 'image/phpthumb/' . $images . '?p=' . $path;
			}
		}
		return $images;
	}
}
