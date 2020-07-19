@extends('backend/layout') @section('title') Users @endsection
@section('breadcrumb')
	<ul class="breadcrumb">
		<li><a href="{{URL::to('admin/dashboard')}}">Dashboard</a></li>
		<li>Users</li>
	</ul>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-sx-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix"><a
				href="{{URL::to('admin/licence/add')}}"> <i
				class="icon-plus btn btn-xs btn-info rounded-buttons">&nbsp;Add</i> </a>
			<h3 class="panel-title">System Users</h3>
			</div>
			<div class="panel-body">@if(Session::has('SECCESS_MESSAGE'))
			<div class="alert alert-block alert-success fade in">
			<button data-dismiss="alert" class="close" type="button"
				data-original-title="">x</button>
			<p>{{Session::get('SECCESS_MESSAGE')}}</p>
			</div>
			@endif
			@if(Session::has('ERROR_MODIFY_MESSAGE'))
				<div class="alert alert-block alert-danger fade in">
				<button data-dismiss="alert" class="close" type="button"
					data-original-title="">x</button>
				<p>{{Session::get('ERROR_MODIFY_MESSAGE')}}</p>
				</div>
			@endif
			<br />
		<div class="table-responsive">
		<table class="table table-bordered no-margin">
			<thead>
				<tr>
					<th><input type="checkbox" class="uniform" name="allbox"
						id="checkAll" /></th>
					<th>ID</th>
					<th>Name</th>
					<th>Money ID</th>
					<th class="hidden-xs">Start date</th>
					<th class="hidden-xs">End date</th>
					<th>Price</th>
					<th style="width:80px" class="hidden-xs">Type</th>
					<th style="width:80px">Status</th>
					<th>Action</th>
				</tr>
			</thead>
	<tbody id="result_filter_user">
		<?php $i=1;?>
		@foreach($list as $licence)
		<tr>
			<td class="checkbox-column"><input type="checkbox" id="itemid"
									name="itemid[]" class="uniform"
									value="{{$licence->l_id}}" /></td>
			<td>{{$licence->l_id}}</td>
			<td>{{$licence->l_name}}</b><br/>{{$licence->l_tel}}</td>
			<td>{{$licence->l_money_id}} - {{$licence->l_transfer_by}}<br/>{{date('d-m-Y',$licence->l_start_date)}}</td>
			<td class="hidden-xs">{{date('d-m-Y',$licence->l_start_date)}}</td>
			<td class="hidden-xs">{{date('d-m-Y',$licence->l_end_date)}}</td>
			<td>{{$licence->l_price}}</td>
			<td class="hidden-xs">{{$licence->l_type}}</td>
			<td>
				@if(time()>=$licence->l_end_date)
					<span class="label label-danger"> Expired </span>
				@else
					@if ($licence->l_status == 1)
						<span class="label label-success"> Active </span>
					@elseif ($licence->l_status == 2)
						<span class="label label-warning"> Pending </span>
					@endif
				@endif
			</td>
			<td style="width: 80px;">
				<div class="btn-group">
					<button class="btn btn-sm dropdown-toggle"
						data-toggle="dropdown">
						<i class="icol-cog"></i> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a
				href='{{URL::to("admin/licence")}}/approve?id={{$licence->l_id}}'>
							<i class="icon-pencil"></i> Approve</a></li>
						<li>
							<a
				href='{{URL::to("admin/licence")}}/add?id={{$licence->l_id}}'>
							<i class="icon-pencil"></i> Edit</a></li>
						<li><a data-modal="true"
							data-text="Do you want to delete this?"
							data-type="confirm" data-class="error" data-layout="top"
							data-action="admin/licence/delete?id={{$licence->l_id}}"
							class="btn-notification"><i class="icon-remove"></i> Remove</a>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<?php $i++;?>
		@endforeach
	</tbody>
</table>
</div>
ddd</div>
</div>
		</div>
		</div>
	{{HTML::script('backend/js/filter.js')}}
 @endsection
