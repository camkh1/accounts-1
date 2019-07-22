@include('frontend.partials.header')
<div class="wrapper-blog">
	<div id="content-con">
		<div class="maincontent">
			<div id="primary">
				@include('frontend.partials.float-playlist')
				@yield('content')
			</div>
			<!-- primary -->
		</div>
		<!-- maincontent -->
	</div>
	@include('frontend.partials.left-sidebar')
	@include('frontend.partials.right-sidebar')
	<!-- content-con -->
	<div class="clear"></div>
</div>
<!-- wrapper-blog -->

<div class='modal fade' id='songdetail-modal' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button aria-label='Close' class='close' data-dismiss='modal' type='button'><span aria-hidden='true'>&#215;</span></button>
				<h4 class='modal-title' id='myLargeModalLabel'>Large modal</h4>
			</div>
			<div class='modal-body'>
				<div id='mysongdetail'>
					<div id='mysongImage'></div>
				</div>
				<div class='row'><div class='col-lg-6'><div id='sharehere'></div></div><div class='col-lg-6'><div class='pull-right' id='likehere'></div></div></div>
			</div>
			<div class='modal-footer'>
				<button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
			</div>
		</div>
	</div>
</div>
@include('frontend.partials.footer')
