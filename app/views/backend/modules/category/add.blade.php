@extends('backend/layout') @section('title') Create @endsection
@section('breadcrumb')
	<ul class="breadcrumb">
		<li><a href="{{URL::to('admin/dashboard')}}">Dashboard</a></li>
		<li><a href="{{URL::to('admin/categories')}}">Categories</a></li>
		<li>Create</li>
	</ul>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading clearfix"><i class="icon-calendar"></i>
					<h3 class="panel-title">Create</h3>
				</div>
				<div class="panel-body">
					{{Form::open(array('url'=>'admin/create-category'))}}
					<div class="form-group">
						<label>En Title<span class="class-required">*</span>
					</label>
						{{ Form::text('name_lml',null, array('class' =>
						'form-control','placeholder'=>'Enter En Title','required'=>'required'))}} <span
							class="class-error">{{$errors->first('name_lml')}}</span>
					</div>

					<div class="form-group">
						<label>Unicode Title<span class="class-required">*</span>
					</label>
						{{ Form::text('name_utf',null, array('class' =>
						'form-control','placeholder'=>'Enter Unicode Title','required'=>'required'))}} <span
							class="class-error">{{$errors->first('name_utf')}}</span>
					</div>
					

					<div class="form-group">
						<label>Slug<span class="class-required">*</span>
					</label>
						{{ Form::text('slug',null, array('class' =>
						'form-control','placeholder'=>'Enter slug'))}} <span
							class="class-error">{{$errors->first('slug')}}</span>
					</div>

					<div class="form-group">
						<label>Image
					</label>
						{{ Form::text('image',null, array('class' =>
						'form-control','placeholder'=>'Enter Title'))}} <span
							class="class-error">{{$errors->first('image')}}</span>
					</div>

					<div class="form-group"><label>Parent<span class="class-required">*</span></label>
						<select name="parent_id" class="form-control">
							<option value="0">Select Parent</option>
							<?php foreach($categories as $cl) { ?>
							<option value="<?php echo $cl["id"] ?>"><?php echo $cl["name_lml"]; ?></option>
							<?php } ?>
						</select>
					</div>
					{{Form::submit('Create', array('class' => 'btn
					btn-success','name'=>'btnSubmit'))}} {{Form::close()}}
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
	.in-limon {font-family: Limon S1;font-size: 36px;height: 55px}
	</style>
@endsection
