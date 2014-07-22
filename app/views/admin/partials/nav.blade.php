<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{URL::route('home')}}">
			<img src="{{URL::asset('assets/images/kickapoo-admin-logo.png')}}" alt="Kickapoo Logo" />
		</a>
	</div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li><a href="{{URL::route('admin.post.index')}}">Social Posts</a></li>
			<li><a href="#">Products</a></li>
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Homepage</a></li>
					<li><a href="#">History</a></li>
					<li><a href="#">Products</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</li>
			<li><a href="#">Forms</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					{{Auth::user()->first_name}} {{Auth::user()->last_name}} <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{URL::route('admin.user.edit', ['id'=>Auth::user()->id])}}">Update Profile</a></li>
					@if(Auth::user()->group_id == 1)
						<li><a href="/admin/user">Users</a></li>
						<li><a href="{{URL::route('admin.settings.index')}}">Site Settings</a></li>
					@endif
					<li class="divider"></li>
					<li><a href="/logout">Log Out</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- .navbar-collapse -->
	</div><!-- .container-fluid -->
</nav>