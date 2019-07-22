@extends('frontend.layout')
@section('title'){{$data->title}}@endsection
@section('description'){{$data->title}}@endsection
@section('content')
	@include('frontend.partials.tvlink')
	
	<div class="clear"></div>	
	<div class="row">
		<div class="col-md-12">
			<h2>{{$data->title}}</h2>
			<div class="content">
				{{$data->content}}
			</div>
		</div>
	</div>
@endsection 

