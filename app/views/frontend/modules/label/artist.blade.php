@extends('frontend.layout')
@section('title')@if(!empty($detail->name_lml)){{$detail->name_lml}} - {{$detail->name_utf}}@endif @endsection
@section('description'){{$detail->name_lml}} - {{$detail->name_utf}}@endsection
@section('content')
<script type="text/javascript">
	var pageType = 'label';
</script>
<div class="element-videos">
	<div class="bg-tr marginbottom">
		<div class="post-style">
			<div class="btn-group btn-group-sort opac5">
				<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
			      <a class="btn btn-primary" href="{{Config::get('app.url')}}play/{{$detail->slug}}" role="button">Play all</a>
			    </div>
			</div>
		</div>
		<h2>@if(!empty($detail->name_lml)){{$detail->name_lml}}@endif </h2>
		<ul class="pm-ul-browse-videos" id="tracklist">	
			{{$data}}
			<div class="clear"></div>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="bg-tr wrap-pagination">
		{{$paginate->links()}}
	</div>
	@include('frontend.partials.tvlink')
</div>
@endsection @section('client_location') dddddddddd @endsection

