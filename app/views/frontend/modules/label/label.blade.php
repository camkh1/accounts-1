@extends('frontend.layout')
@section('title'){{@$data->name}}@endsection
@section('description'){{@$data->name}}@endsection
@section('content')
<script type="text/javascript">
	var pageType = 'label';
</script>
<div class="element-videos">
	<div class="post-style" style="display: none">
		<div class="btn-group btn-group-sort opac5">
			<button class="btn btn-small" id="list">
				<i class="icon-th"></i>
			</button>
			<button class="btn btn-small" id="grid">
				<i class="icon-th-list"></i>
			</button>
		</div>
	</div>
	<h2>{{@$data->name}}</h2>
	<ul class="pm-ul-browse-videos thumbnails" id="getajax">	
		<div class="loadPlaylist"></div>	
	</ul>
	<div class="clear"></div>
	@include('frontend.partials.tvlink')
	<div id="byPage"></div>
</div>
<script>
<?php 
$num = Input::get ( 'page' ) ? Input::get ( 'page' ) : 0;
$segment = Request::segment ( 3 );
if(!empty($segment)) {
	$cateSlug = $segment;
} else {
	$cateSlug = '';
}
?>
	var url = '{{Config::get('app.url')}}searchallajax?c={{$cateSlug}}&page={{$num}}';
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
					$("#blockui").show();
				},
				complete: function(){
					$("#blockui").hide();
				},
				success: function(data){
					$("#getajax").html(data.result);
					$("#byPage").html(data.page);
					loadTopVideo();
				},
				error: function(){} 	        
		   });
		});
	});
</script>
@endsection @section('client_location') dddddddddd @endsection

