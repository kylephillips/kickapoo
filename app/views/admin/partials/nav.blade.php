@if(Session::has('flashmessage'))
<div class="alert alert-info flash-message">
	{{Session::get('flashmessage')}}
</div>
@endif

<nav class="navbar navbar-inverse">

	@if(Request::is('admin/*'))
	<a class="logo" href="{{URL::route('home')}}">
		<img src="{{URL::asset('assets/images/Kickapoo-logo-rev.svg')}}" alt="Kickapoo Logo" />
	</a>
	@else
	<a class="logo" href="{{URL::route('admin_index')}}">
		<img src="{{URL::asset('assets/images/Kickapoo-logo-rev.svg')}}" alt="Kickapoo Logo" />
	</a>
	@endif

	<a href="#" class="admin-nav-toggle">Admin Menu</a>
	
	<ul class="nav">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-admin-pushpin"></i> Social Posts<span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{URL::route('admin.post.index')}}">Social Feed ({{$pendingcount}})</a></li>
				<li><a href="{{URL::route('post_trash')}}">Trash ({{$trashcount}})</a></li>
				<li><a href="{{URL::route('admin.ban.index')}}">Banned Users</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-admin-happy"></i> Products <span class="caret"></span></a>
			<ul class="dropdown-menu">
				@foreach($products as $product)
				<li><a href="{{URL::route('edit_flavor', ['id'=>$product->id])}}">{{$product->title}}</a></li>
				@endforeach
				<li class="light"><a href="{{URL::route('edit_products')}}">All Products</a></li>
				<li class="light"><a href="{{URL::route('admin.size.index')}}">Product Types</a></li>
				<li class="light"><a href="{{URL::route('create_flavor')}}">Add a Product</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-admin-file"></i> Pages <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				@foreach($allpages as $page)
				<li><a href="{{URL::route('edit_page', ['page'=>$page->slug])}}">{{$page->title}}</a></li>
				@endforeach
				<li class="light"><a href="{{URL::route('page_index')}}">All Pages</a></li>
				<li class="light"><a href="{{URL::route('create_page')}}">New Page</a></li>
			</ul>
		</li>
		<li><a href="{{URL::route('form_entries')}}"><i class="icon-admin-pencil"></i> Forms</a></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="icon-admin-user"></i> {{Auth::user()->first_name}} {{Auth::user()->last_name}} <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right" role="menu">
				<li><a href="{{URL::route('admin.user.edit', ['id'=>Auth::user()->id])}}">Update Profile</a></li>
				@if(Auth::user()->group_id == 1)
					<li><a href="{{URL::route('admin.user.index')}}">Users</a></li>
					<li><a href="{{URL::route('settings_form')}}">Site Settings</a></li>
				@endif
				<li class="light"><a href="{{URL::route('logout')}}">Log Out</a></li>
			</ul>
		</li>
	</ul>
</nav>
<div class="navclear"></div>