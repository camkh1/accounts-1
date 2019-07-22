@extends('frontend.layout')
@section('title')@if(!empty($detail->name_lml)){{$detail->name_lml}} - {{$detail->name_utf}}@endif @endsection
@section('description'){{$detail->name_lml}} - {{$detail->name_utf}}@endsection
@section('content')
<script type="text/javascript">
	var pageType = 'label';
</script>
<div class="element-videos">
	<!-- header -->
	<div class="panel panel-colorful msHeader searchLabel" style="margin:0">
		<div class="media-left">
			<div class="largthumb">
				<div class="thumb-big">
				<span class="play-button" onclick="getTrack('{{$detail->slug}}&page=<?php echo (Input::get('page')? Input::get('page'): '1');?>',null,1);">
				<span class="icon"></span>
				</span>
				<span class="play-button-pause" style="display:none"><span class="icon"></span></span>
				<div class="imageByLabel" id="imageByLabel">
				<img alt="Sample Image" class="img-by-label" src="@if(!empty($detail->image)){{$detail->image}}@endif&h=175&w=175" width="175" height="175"/>
				</div>
				</div>
			</div>
		</div>
		<div class="media-body pad-lft" style="overflow: visible">
			<p class="text-2x mar-no text-thin" id="TitleByLabel">@if(!empty($detail->name_lml)){{$detail->name_lml}}@endif</p>
			<p class="text-muted mar-no">@if(!empty($detail->name_lml)){{$detail->name_lml}}@endif</p>
			<p class="text-muted mar-no">
			<span class="badge badge badge-info totalSongs" id="totalSongs">{{$paginate->getTotal()}} Tracks</span>
			</p>
			<p class="text-muted mar-no" id="topExtraMenu">
				<button id="dLabel" type="button" class="btn btn-rounded btn-danger">See all in @if(!empty($detail->name_lml)){{$detail->name_lml}}@endif</button>
			</p>
			<div class="clear"></div>
			<p class="text-muted mar-no btnHeader">
				<button onclick="loadding();addCurrentList();" id="addCurrentList" data-add="1" class="btn btn-default btn-icon btn-circle"><span class="icosg-plus1"></span></button>
				<button onclick="songdetail(&quot;http://www.topkhmersong.com/search/label/P%20--%20Sunday?&amp;max-results=50&amp;PageNo=1&quot;,&quot;P -- Sunday&quot;,&quot;http://1.bp.blogspot.com/-SpkUlcF6PIo/VZqj_kMeJ3I/AAAAAAAAKbU/XedB1Gfc5yw/s150-c/sunday.jpg&quot;);" class="btn btn-default btn-icon btn-circle"><span class="icosg-share2"></span></button>
				<button onclick="songcomment(&quot;http://www.topkhmersong.com/search/label/P%20--%20Sunday?&amp;max-results=50&amp;PageNo=1&quot;);" class="btn btn-default btn-icon btn-circle"><span class="icosg-comments"></span></button>
				<button class="btn btn-default btn-icon btn-circle"><span class="icosg-heart1"></span></button>
			</p>
		</div>
	</div>
	<!-- end header -->

	<div id="SongWrapper">
	<ul id="SongList">
		@if(!empty($data))
		@foreach($data as $track)
		<li 
			class="song  post_id_{{$track['id']}}" 
			id="post_id_{{$track['id']}}" 
			data-link="{{$track['link']}}" 
			data-title="{{$track['title_unicode']}}" 
			data-mp3="{{Config::get('app.dataUrl')}}upload/mp3/{{$track['mp3']}}" 
			data-image="{{$track['image']}}">
			<button 
				href="javascript:;" 
				class="btn btn-xs btn-default btn-icon btn-circle iconaddsong" 
				id="addthisSong">
				<span class="icosg-plus1"></span>
			</button>
			<div class="thumbs">
				<span class="play-button">
					<span class="icon"></span>
				</span>
				<img src="{{$track['image']}}">
			</div>
			<div class="title">
				<a 
					class="track" 
					data-src="{{Config::get('app.dataUrl')}}upload/mp3/{{$track['mp3']}}" 
					href="#">
					{{$track['title_limon']}}
				</a>
			</div>
			<div 
				class="track-detail" 
				id="detail_id_{{$track['id']}}">
				<div class="inner">
					<a 
					class="song-del" 
					onclick="songdel(&quot;{{$track['id']}}&quot;)" 
					href="javascript:;">
						<i class="fa fa-times"></i>
					</a>
					<div class="btn-group pull-left">
						<button class="btn btn-xs btn-active-pink dropdown-toggle dropdown-toggle-icon" 
							data-toggle="dropdown" 
							type="button" 
							aria-expanded="false" 
							style="padding:0">
							<i class="fa fa-tags"></i>
						</button>
						<a 
							class="song-comment" 
							onclick="songcomment(&quot;http://www.topkhmersong.com/2015/08/09-yub-nis-pek-oy-slab-van-phaly.html&quot;)" 
							href="javascript:;">
							<span class="icosg-comments"></span>
						</a>
						<a 
							class="getlink" 
							href="http://www.topkhmersong.com/2015/08/09-yub-nis-pek-oy-slab-van-phaly.html" 
							target="_top">
							<span class="icosg-share2"></span>
						</a>
						<a 
							onclick="songdetail(&quot;http://www.topkhmersong.com/2015/08/09-yub-nis-pek-oy-slab-van-phaly.html&quot;,&quot;09.យប់នេះផឹកអោយស្លាប់ វ៉ាន់ ផល្លី  Yub Nis pek Oy Slab (Van Phaly)&quot;,&quot;http://1.bp.blogspot.com/-MhtM8KC6FUY/VcHuPNj0AvI/AAAAAAAACsc/92a_MQX4m8s/s72-c/Vann%2BPhaly.png&quot;)" 
							class="song-details" 
							href="javascript:;" 
							datalink="http://www.topkhmersong.com/2015/08/09-yub-nis-pek-oy-slab-van-phaly.html" 
							datatitle="09.យប់នេះផឹកអោយស្លាប់ វ៉ាន់ ផល្លី  Yub Nis pek Oy Slab (Van Phaly)" 
							dataimg="http://1.bp.blogspot.com/-MhtM8KC6FUY/VcHuPNj0AvI/AAAAAAAACsc/92a_MQX4m8s/s72-c/Vann%2BPhaly.png">
							<i class="fa fa-cog"></i>
						</a>
					</div>
				</div>
			</div>
		</li>
		@endforeach
		@endif
	</ul>
	</div>
	<div class="clear"></div>
	<div class="bg-tr wrap-pagination">
		{{$paginate->links()}}
	</div>
	@include('frontend.partials.tvlink')
</div>
@endsection @section('client_location') dddddddddd @endsection

