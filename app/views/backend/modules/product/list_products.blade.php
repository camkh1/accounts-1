@extends('backend/layout') 
@section('title') Free Products @endsection
@section('breadcrumb')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home">
            </i>
            <a href="{{URL::to('admin/dashboard')}}">Dashboard</a>
        </li>
        <li class="current">Songs</li>
    </ul>
    <ul class="crumb-buttons">
        <li>
            <a href="{{URL::to('admin/products/add')}}" title=""><i class="icon-plus"></i>Add new</a>
        </li>
    </ul>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-sx-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form
                    action="{{URL::to('admin/products/free')}}"
                    method="get"
                >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Title</label>
                            {{ Form::text(
                                'title',
                                Input::get('title'), 
                                array(
                                    'class' => 'form-control'
                                )
                            )}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Artist</label>
                            {{ Form::text(
                                'client_name',
                                Input::get('client_name'), 
                                array(
                                    'class' => 'form-control'
                                )
                            )}}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Product</label>
                            {{ Form::text(
                                'date_create',
                                Input::get('date_create'), 
                                array(
                                    'class' => 'form-control'
                                )
                            )}}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            {{Form::select(
                                'status', 
                                array(
                                    '' => 'Select',
                                    1 => 'Enable',
                                    2 => 'Disabled'
                                ),
                                Input::get('status'),
                                array('class' => 'form-control')
                            )}}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input
                            name="btn_filter"
                            style="width:100%; margin-top:24px;"
                            type="submit" 
                            class="btn btn-primary"
                            value="Filter" 
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-sx-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
            <h3 class="panel-title">Songs List</h3>
            </div>
            <div class="panel-body">
            @if(Session::has('SMG_SUCCESS'))
                <div class="alert alert-block alert-success fade in">
                    <button data-dismiss="alert" class="close" type="button"
                        data-original-title="">x</button>
                    <p>{{Session::get('SMG_SUCCESS')}}</p>
                </div>
            @endif
        <div class="table-responsive">
        <table class="table table-bordered no-margin">
            <thead>
                <tr>
                    <th width="2%">#</th>
                    <th width="100px">Picture</th>
                    <th>Title</th>
                    <th width="10%">Artist</th>
                    <th width="15%">Product & Vol</th>
                    <th width="100px">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key=>$product)
                    <tr>
                        <td>
                            <?php 
                                $content = json_decode($product->content);
                                // $artistImage = $content->artistImage;
                                // $lyric = !empty($content->lyrict) ? $content->lyrict : @$content->artistImage[0];
                                // $production = $content->production;
                                // $production = $content->production;

                            ?>
                            {{$key + 1 }}</td>
                        <td>
                            <div style="overflow: hidden;position: relative;width:100px;height: 100px;">
                                @if(!empty($content->artistImage))
                                    @foreach ($content->artistImage as $artImg)
                                            <a href="#" style="display: block;position: absolute;top: 0px;left: 0px;" class="first-img">
                                                {{HTML::image("upload/uploads/artist/$artImg",'Title',array('class'
                            => 'img-rounded','width'=>'60'))}}
                                            </a>
                                    @endforeach
                                    {{count($content->artistImage)}}
                                @endif
                            </div>
                        </td>
                        <td>{{$product->title_utf}}</td>
                        <td>
                            @if($content->artist)
                                <?php echo implode(', ', $content->artist);?>
                            @endif
                        </td>
                        <td>
                            @if($content->production)
                                Production: <b>{{$content->production}}</b>
                            @endif
                            @if($content->vol)
                                , Vol: <b>{{$content->vol}}</b>
                            @endif
                        </td>
                        <td>
                            @if($product->status === 1)
                                <span class="label label-success">Enable</span>
                            @else
                                <span class="label label-danger">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{URL::to('admin/products/status')}}/free/{{$product->id}}/2">Disabled</a> |
                            <a href="{{URL::to('admin/products/status')}}/free/{{$product->id}}/1">Enable</a> | 
                            <a 
                                href="{{URL::to('admin/products/delete')}}/free/{{$product->id}}"
                                onclick="return confirm('Are you sure you want to delete this item?');" 
                            >
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
{{$products->links()}}
</div>
</div>
</div>
</div>
 @endsection
