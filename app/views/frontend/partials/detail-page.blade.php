@extends('frontend.layout')
@section('title'){{$video->title}}@endsection
<?php
$getconFig = new MVideo();
$getPL = json_decode ( $video->playlist );
$currentUrl = Request::path ();
$num = Input::get ( 'num' ) ? Input::get ( 'num' ) : 1;
$getList = $getconFig->getPlaylist($getPL,$num, $currentUrl, $video->image);

function rm($article, $char) {
	$article = preg_replace ( "/<img[^>]+\>/i", "(image)", $article );
	$article = strip_tags($article);
	$article = preg_replace ( "/(\r?\n){2,}/", "\n\n", $article );
	if (strlen ( $article ) > $char) {
		return substr ( $article, 0, $char ) . '...';
	} else
		return $article;
}
$desc = rm($video->description,300);
?>
@section('description'){{($desc ? $desc : $video->title)}}@endsection
@section('detailcontent')
	<meta name="title" content="@yield('title')"/>
	<meta content="@yield('title')" property='og:site_name'/>
		
	<meta property="og:site_name" content="@yield('title')"/>
    <meta property="og:url" content="{{Config::get('app.url')}}{{Request::path ()}}"/>
	<meta property="og:title" content="@yield('description')"/>
	<meta property="og:image" content="{{@$video->image}}"/>
	<meta property="og:description" content="@yield('description')"/>
	<meta property="og:video:url" content="{{Config::get('app.url')}}{{Request::path ()}}"/>
	<meta property="og:video:secure_url" content="{{Config::get('app.url')}}{{Request::path ()}}">
	<meta property="og:video:type" content="text/html"/>
    
	<meta name="twitter:url" content="{{Config::get('app.url')}}{{Request::path ()}}"/>
	<meta name="twitter:title" content="@yield('title')"/>
	<meta name="twitter:description" content="@yield('description')"/>
	<meta name="twitter:image" content="{{@$video->image}}"/>
	<meta content="{{@$video->image}}" itemprop='image'/>
	<link href="{{@$video->image}}" rel='image_src'/>
	@if($video->tag)
		@foreach($video->tag as $videoTag)
		<meta property="og:video:tag" content="{{$videoTag->name}}"/>
		@endforeach
	@endif
@endsection

@section('content')
<div class="player-wrapper">
	<div class="row">
		<div class="col-lg-8 on-player">
			<div class="player-body" id="player-body">
				@if($getList['video'])
				<iframe id="iframeset" width="100%" height="425"
					src="{{$getList['video']}}"
					frameborder="0" allowfullscreen=""></iframe>
				@endif
			</div>
		</div>
		<div class="col-lg-4">
			<div class="player-list" id="player-list">
				<!-- start list -->
				<div class="video_playlist">
					@if($getList)
					{{$getList['playlist']}}
					@endif
				</div>
				<!-- end start list -->
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-8">
			<h2 class="vido-title">{{$video->title}}</h2>
		</div>
		<div class="col-lg-4"><div class="counter pull-right">{{$video->views}}</div></div>
	</div>
	<div id="ad_1" class="contentAd"></div>
	@include('frontend.partials.tvlink')
	<!-- share -->
	<div class="row shared">
		<div class="col-lg-12"><div style="border-top: 1px solid #e2e2e2;padding:0;margin: 0 0 10px;"></div></div>
		<div class="col-lg-8">
			<span class="addthis_sharing_toolbox pull-left"></span>
			<span id="category"></span>
			<div class="clear"></div>
			<div id="follower"></div>
			<div class="clear"></div>
			<div style="border-top: 1px solid #e2e2e2;padding:0;margin: 10px 0 10px;"></div>
			<div id="comment-facebook">
				<div class="fb-comments" data-href="'+link+'" data-width="290px"></div>
			</div>
			
		</div>
		<div class="col-lg-4">
			<ul class="pm-ul-top-videos" id="pm-ul-related-videos"><div class="loadPlaylist"></div></ul>
		</div>
	</div>
	<!-- end share -->
</div>

<script>
var copyright = 0;
@if($video->copyright == 1)
	copyright = 1;
@endif
<?php
$num = Input::get ( 'num' ) ? Input::get ( 'num' ) : 1;
?>
	var url = '{{Config::get('app.url')}}singlepagejson?c={{urlencode($video->category)}}';
	jQuery(document).ready(function(){
		jQuery('body').delegate("#byPage li","click",function(e){
			$("#blockui").show();
		});

		
		jQuery( window ).load(function() {
			$.ajax({
				url: url,
				type: "GET",
				dataType: "json",
				beforeSend: function(){
					//$("#blockui").show();
				},
				complete: function(){
					//$("#blockui").hide();
				},
				success: function(data){
					if(data) {
						//$("#iframeset").attr('src',data.video);
						$("#category").html(data.category);
						//$(".video_playlist").html(data.playlist);
						$("#pm-ul-related-videos").html(createHtmlTop(data.related));
						//$("#pm-ul-top-videos").html(data.topVideo);
						$('#comment-facebook').html('<div class="fb-comments" data-href="{{Config::get('app.url')}}{{Request::path ()}}" data-width="100%"></div>');
						$(".video_playlist").append('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53afce5354abe9ad" async="async"><\/script>');
						$("#follower").append('<iframe class="pull-left" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fmerlroeung&amp;&amp;width=300&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;appId=307381852713810" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:62px;" allowtransparency="true"><\/iframe>');
						$("#follower").append('<iframe class="pull-left" src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/khmersongco&width&height=62&colorscheme=light&show_faces=false&header=false&stream=false&show_border=true&appId=257793881054360" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:62px;" allowtransparency="true"><\/iframe>');
						$("#follower").append('<script id="facebook-jssdk" src="//connect.facebook.net/en_US/sdk.jss#xfbml=1&appId=1456273291274751&version=v2.0&status=0"><\/script>');
						$("#follower").append('<iframe class="pull-left" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="width: 183px; margin: 0px; visibility: visible; height: 62px;padding:5px;border:1px solid #eee" tabindex="0" vspace="0" width="100%" id="I5_1441107134420" name="I5_1441107134420" src="https://www.youtube.com/subscribe_embed?usegapi=1&amp;channel=sreymoabtb&amp;layout=full&amp;count=default&amp;origin=https%3A%2F%2Fgoogle-developers.appspot.com&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.en.ew96GqKYpwE.O%2Fm%3D__features__%2Fam%3DAQ%2Frt%3Dj%2Fd%3D1%2Ft%3Dzcms%2Frs%3DAGLTcCMZMDhwOajlbll0mYcoX5GBt7lOuQ#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh&amp;id=I5_1441107134420&amp;parent=https%3A%2F%2Fgoogle-developers.appspot.com&amp;pfname=&amp;rpctoken=12067852" data-gapiattached="true"></iframe>');
						var p = $( "#playing" );
						var position = p.position();
				        $( "#playlistbar" ).scrollTop( position.top - 30 );
				        loadTopVideo();
				        FB.XFBML.parse();
					}
					//$("#getajax").html(data.result);
					//$("#byPage").html(data.page);
				},
				error: function(){} 	        
		   });
		});

		 $("#showlist").click(function(){
             $("#loadmore").toggleClass("showlist");
       });
	});
	function writeFun () {
		document.write('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53afce5354abe9ad" async="async"><\/script>');
	}
</script>
@endsection @section('client_location') dddddddddd @endsection

