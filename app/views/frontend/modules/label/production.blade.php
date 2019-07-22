@extends('frontend.layout')
@section('title')@if(!empty($detail->name_lml)){{$detail->name_lml}} - {{$detail->name_utf}}@endif @endsection
@section('description'){{$detail->name_lml}} - {{$detail->name_utf}}@endsection
@section('content')
<script type="text/javascript">
	var pageType = 'label';
</script>
<div class="element-videos">
	<div class="post-style">
		<div class="btn-group btn-group-sort opac5">
			<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
		      <a class="btn btn-primary" href="{{Config::get('app.url')}}play/{{$detail->slug}}" role="button">Play all</a>
		    </div>
		</div>
	</div>
	<h2>@if(!empty($detail->name_lml)){{$detail->name_lml}}@endif </h2>
	<ul class="pm-ul-browse-videos thumbnails" id="getajax">	
		@if(!empty($data))
			@foreach($data as $production)
				<li>
					<?php
						$link = Config::get('app.url').'search/label/production/' .$production['link'];
					?>
					<div class="pm-li-video">
						<div class="new_video">
						<span class="pm-video-thumb pm-thumb-145 pm-thumb border-radius2">
							<span class="pm-video-li-thumb-info"></span>
							<a href="{{$link}}" class="pm-thumb-fix pm-thumb-145" title="{{$production['title_unicode']}}">
								<span class="pm-thumb-fix-clip">
									<img src="{{$production['image']}}" 
										width="145">
										<span class="vertical-align"></span>
								</span>
							</a>
						</span>
						</div>
						<h3 dir="ltr">
							<a href="{{$link}}" class="pm-title-link" title="{{$production['title_unicode']}}">{{$production['title_en']}}</a>
						</h3>
						<div class="pm-video-attr">
							<span class="pm-video-attr-numbers">
								<small>0 Views</small>
							</span>
						</div>
					</div>
				</li>
			@endforeach
		@endif
	</ul>
	<div class="clear"></div>
	<div class="bg-tr wrap-pagination">
		{{$paginate->links()}}
	</div>
	@include('frontend.partials.tvlink')
	
</div>
@endsection @section('client_location') dddddddddd @endsection

