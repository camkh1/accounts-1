@include('backend.partials.header')
<!-- Top bar start -->
@include('backend.partials.top_menu')

<div id="container" class="fixed-header">
	@include('backend.partials.left_sidebar')
	<div id="content">
		<div class="container">
				@include('backend.partials.breadcrumb')
			<!-- Content Start -->
			<div class="page-header">
				<div class="page-title">
					<h3>@yield('title')</h3>
				</div>
			</div>
			@yield('content')
			<!-- Content End -->
		</div>
	</div>
</div>
@include('backend.partials.footer')

