<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
                <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28"><span> {{__('message.Dashboard')}} </span></h1>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
                            <?php
                                use App\Models\User;
                                $imageuser = User::query()->select('id')->where('id', '=', Auth::user()->id)->with('image')->get();
                            ?>
                            @foreach ($imageuser as $img)
                                @if (empty($img->image->image))
                                    <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
                                @else
                                    <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('storage/'.$img->image->image)}}"><span class="avatar-status profile-status bg-green"></span>
                                @endif
                            @endforeach

						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth::user()->name}}</h4>
							<span class="mb-0 text-muted">Premium Member</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
                    {{-- @can('المستخدمين') --}}
                    <li class="side-item side-item-category">{{__('message.Dashboard')}}</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                            <span class="side-menu__label">{{__('message.users')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            {{-- @can('قائمة المستخدمين') --}}
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'users')) }}">{{__('message.userlist')}}</a></li>
                            {{-- @endcan --}}

                            {{-- @can('صلاحيات المستخدمين') --}}
                                <li><a class="slide-item" href="{{ url('/' . ($page = 'roles')) }}">{{__('message.userpermissions')}}</a></li>
                            {{-- @endcan --}}
                        </ul>
                    </li>
                    {{-- @endcan --}}

                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <span class="side-menu__label">{{__('message.Dashboard')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('category_index') }}">{{__('messagevalidation.users.Categories')}}</a></li>
							<li><a class="slide-item" href="{{ route('childcat_index') }}">{{__('messagevalidation.users.children')}}</a></li>
							<li><a class="slide-item" href="{{ route('tags_index') }}">{{__('message.tags')}}</a></li>
                            <li><a class="slide-item" href="{{ route('posts_index') }}">{{__('messagevalidation.users.posts')}}</a></li>
                            <li><a class="slide-item" href="{{ route('product_index') }}">{{__('messagevalidation.users.products')}}</a></li>
						</ul>
					</li>

					<li class="side-item side-item-category">Main</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ url('/' . $page='index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">Index</span><span class="badge badge-success side-badge">1</span></a>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg><span class="side-menu__label">Forms</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ url('/' . $page='products') }}">Products</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='product-details') }}">Product-Details</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='product-cart') }}">Cart</a></li>

                            <li><a class="slide-item" href="{{ url('/' . $page='contacts') }}">Contacts</a></li>

                            <li><a class="slide-item" href="{{ url('/' . $page='pagination') }}">Pagination</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='popover') }}">Popover</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='progress') }}">Progress</a></li>

							<li><a class="slide-item" href="{{ url('/' . $page='accordion') }}">Accordion</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='carousel') }}">Carousel</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='modals') }}">Modals</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='sweet-alert') }}">Sweet Alert</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='rating') }}">Ratings</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='counters') }}">Counters</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='userlist') }}">Userlist</a></li>

							<li><a class="slide-item" href="{{ url('/' . $page='mail') }}">Mail</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='mail-compose') }}">Mail Compose</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='mail-read') }}">Read-mail</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='mail-settings') }}">mail-settings</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='chat') }}">Chat</a></li>

							<li><a class="slide-item" href="{{ url('/' . $page='form-elements') }}">Form Elements</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='form-advanced') }}">Advanced Forms</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='form-layouts') }}">Form Layouts</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='form-validation') }}">Form Validation</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='form-wizards') }}">Form Wizards</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='form-editor') }}">WYSIWYG Editor</a></li>

							<li><a class="slide-item" href="{{ url('/' . $page='table-basic') }}">Basic Tables</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='table-data') }}">Data Tables</a></li>

                            <li><a class="slide-item" href="{{ url('/' . $page='map-leaflet') }}">Mapel Maps</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='map-vector') }}">Vector Maps</a></li>

							<li><a class="slide-item" href="{{ url('/' . $page='profile') }}">Profile</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='editprofile') }}">Edit-Profile</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='invoice') }}">Invoice</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='pricing') }}">Pricing</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='gallery') }}">Gallery</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='todotask') }}">Todotask</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='faq') }}">Faqs</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='empty') }}">Empty Page</a></li>

                            <li><a class="slide-item" href="{{ url('/' . $page='signin') }}">Sign In</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='signup') }}">Sign Up</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='forgot') }}">Forgot Password</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='reset') }}">Reset Password</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='lockscreen') }}">Lockscreen</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='underconstruction') }}">UnderConstruction</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='404') }}">404 Error</a></li>
							<li><a class="slide-item" href="{{ url('/' . $page='500') }}">500 Error</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" href="{{ url('/' . $page='widgets') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3"/><path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z"/></svg><span class="side-menu__label">Widgets</span><span class="badge badge-warning side-badge">Hot</span></a>
					</li>

				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
