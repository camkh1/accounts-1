<header class="header navbar navbar-fixed-top" role="banner">
	<div class="container">
		<ul class="nav navbar-nav">
			<li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
		</ul>
		<a class="navbar-brand" href="{{URL::to('admin/dashboard')}}">
			{{HTML::image('backend/images/icons/home.png','Home')}} <strong>ME</strong>LON
		</a> <a href="#" class="toggle-sidebar bs-tooltip"
			data-placement="bottom" data-original-title="Toggle navigation"> <i
			class="icon-reorder"></i>
		</a>
		<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
			<li><a href="#"> Dashboard </a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown"> Dropdown <i class="icon-caret-down small"></i>
			</a>
				<ul class="dropdown-menu">
					<li><a target="_blank" class="view-site" href="{{URL::to('/')}}"> <i
							class="icon-leaf"></i> View Site
					</a></li>
					<li><a href="#"><i class="icon-calendar"></i> Example #2</a></li>
					<li class="divider"></li>
					<li><a href="#"><i class="icon-tasks"></i> Example #3</a></li>
				</ul></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown">General Setting <i
					class="icon-caret-down small"></i></a>
				<ul class="dropdown-menu">
					<li><a href="{{URL::to('admin/front-end-setting')}}">Front-end
							Setting</a></li>
					<li><a href="{{URL::to('admin/back-end-setting')}}">Back-end
							Setting</a></li>
				</ul>
			
			<li class="dropdown"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown">User Management <i
					class="icon-caret-down small"></i></a>
				<ul class="dropdown-menu">
					<li><a href="{{URL::to('admin/users')}}">System User</a></li>
					<li><a href="{{URL::to('admin/users/clients')}}">Client User</a></li>
					<li><a href="{{URL::to('admin/user-group')}}">User Group</a></li>
					<li><a href="{{URL::to('admin/client-user-type')}}">Client User
							Type</a></li>
					<li><a href="{{URL::to('admin/user-role-play')}}"> User Role Play</a></li>
				</ul></li>


			</li>
			<li class="dropdown user"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown"><i class="icon-male"></i> <span
					class="username"> @if(Session::has('SESSION_LOGIN_NAME'))
						{{Session::get('SESSION_LOGIN_NAME')}} @endif</span> <i
					class="icon-caret-down small"></i></a>
				<ul class="dropdown-menu">
					<li><a href="{{URL::to('admin/licence')}}"> Licence </a></li>
					<li class="divider"></li>
					<li><a href="{{URL::to('admin/profile')}}"> My Profile </a></li>
					<li><a href="{{URL::to('admin/change-password')}}"> Change Password
					</a></li>
					<li class="divider"></li>
					<li><a href="{{URL::to('admin/logout')}}"> Logout </a></li>
				</ul></li>
			<li class="dropdown"><a href="#"
				class="project-switcher-btn dropdown-toggle"> <i
					class="icon-folder-open"></i> <span>Projects</span>
			</a></li>
		</ul>
	</div>
	<div id="project-switcher" class="container project-switcher">
		<div id="scrollbar">
			<div class="handle"></div>
		</div>
		<div id="frame">
			<ul class="project-list">
				<li><a href="{{URL::to('admin/front-end-setting')}}"> <span class="image">
							{{HTML::image('backend/images/icons/setting-front.png','Front End
							Setting')}} </span> <span class="title">Front Setting</span>
				</a></li>
				<li><a href="{{URL::to('admin/back-end-setting')}}"> <span class="image">{{HTML::image('backend/images/icons/setting-back.png','Back End Setting')}}</span> 
				<span class="title">End Setting</span>
				</a></li>
				<li class="current"><a href="{{URL::to('admin/users')}}"> <span
						class="image">
							{{HTML::image('backend/images/icons/system-user.png','System User')}}
						</span> <span class="title">System User</span>
						<span class="badge">
						<?php 
							// $countSystemUser = DB::table('user')
							// 	->where('user_type', '!=', 4)
							// 	->count(); 
							// echo $countSystemUser;
						?>
						</span>
				</a></li>
				<li><a href="javascript:void(0);"> <span class="image">
						{{HTML::image('backend/images/icons/client-user.png','Client User')}}
							</span> 
							<span class="title">Client User
							</span>
							<span class="badge">
							<?php 
							// $countClientUser = DB::table('user')
							// 	->where('user_type', '=', 4)
							// 	->count(); 
							// echo $countClientUser;
						?>
							</span>
				</a></li>
				<li><a href="javascript:void(0);"> <span class="image">
					{{HTML::image('backend/images/icons/user-group.png','User Group')}}
				</span> <span class="title">User Group</span>
				<span class="badge">
							<?php 
							// $countUserGroup = DB::table('user_type')
							// 	->where('id', '!=', 4)
							// 	->count(); 
							// echo $countUserGroup;
						?>
							</span>
				</a></li>
				<li><a href="{{URL::to('admin/categories')}}"> <span class="image">
					{{HTML::image('backend/images/icons/category.png','Category')}}
							</span> <span class="title">Category</span>
					<span class="badge">
							<?php 
							// $countCategory = DB::table('m_category')
							// 	->count(); 
							// echo $countCategory;
						?>
							</span>		
				</a></li>
				<li><a href="{{URL::to('admin/products')}}"> <span class="image">
					{{HTML::image('backend/images/icons/product.png','Product')}}
				</span> <span class="title">Product</span>
				<span class="badge">
					<?php 
							// $countProduct = DB::table('post')
							// 	->count(); 
							// echo $countProduct;
						?>
							</span>	
				</a></li>
				<li><a href="{{URL::to('admin/advertisements')}}"> <span class="image">
					{{HTML::image('backend/images/icons/advertisment.png','Advertisement')}}
					</span> <span class="title">Advertisement</span>
					<span class="badge">
					<?php 
							// $countAdvertisment = DB::table('advertisement')
							// 	->count(); 
							// echo $countAdvertisment;
						?>
					</span>	
				</a></li>
				<li><a href="javascript:void(0);"> <span class="image">
				{{HTML::image('backend/images/icons/business-page.jpg','Business Page')}}</span> <span class="title">Bussiness Page</span>
				<span class="badge">
					1
					</span>
				</a></li>
				<li><a href="javascript:void(0);"> <span class="image">
					{{HTML::image('backend/images/icons/personal-page.png','Personal Page')}}
				</span> <span class="title">Personal Page</span>
				<span class="badge">
					3
					</span>
				</a></li>
				<li><a href="javascript:void(0);"> <span class="image">
				{{HTML::image('backend/images/icons/report.png','Report')}}
							</span> <span class="title">Report</span>
				</a></li>
			</ul>
		</div>
	</div>
</header>
<style>
.project-switcher li {
	position: relative;
}
.project-switcher a .badge {
    position: absolute;
    font-size: 10px;
    font-weight: 300;
    top: 5px;
    right: 34px;
    text-align: center;
    height: 14px;
    background-color: #be4141;
    background-color: rgba(219,45,42,0.8);
    padding: 2px 4px;
    text-shadow: none;
}
</style>