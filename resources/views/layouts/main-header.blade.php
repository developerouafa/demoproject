<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
						<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
							<input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
						</div>
					</div>
					<div class="main-header-right">
                        <ul class="nav">
							<li class="">
								<div class="dropdown  nav-itemd-none d-md-flex">
									<a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
										<span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/unnamed.png')}}" alt="img"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item d-flex ">
                                                    <div class="d-flex">
                                                        <span class="mt-2">{{ $properties['native'] }}</span>
                                                    </div>
                                                </a>
                                        @endforeach
									</div>
								</div>
							</li>
						</ul>
						{{-- <ul class="nav">
							<li class="">
								<div class="dropdown  nav-itemd-none d-md-flex">
									<a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
										<span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/us_flag.jpg')}}" alt="img"></span>
										<div class="my-auto">
											<strong class="mr-2 ml-2 my-auto">English</strong>
										</div>
									</a>
									<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
										<a href="#" class="dropdown-item d-flex ">
											<span class="avatar  ml-3 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/french_flag.jpg')}}" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">French</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar  ml-3 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/germany_flag.jpg')}}" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Germany</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar ml-3 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/italy_flag.jpg')}}" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Italy</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar ml-3 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/russia_flag.jpg')}}" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Russia</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar  ml-3 align-self-center bg-transparent"><img src="{{URL::asset('assets/img/flags/spain_flag.jpg')}}" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">spain</span>
											</div>
										</a>
									</div>
								</div>
							</li>
						</ul> --}}
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>
                            <div class="dropdown nav-item main-header-message ">
                                @php
                                    $user_id = Auth::user()->id;
                                    // view the cart items
                                        $carts = \Cart::session($user_id)->getContent();
                                        $cartTotalQuantity = \Cart::session($user_id)->getTotalQuantity();
                                        $subTotal = \Cart::session($user_id)->getSubTotal();
                                        $total = \Cart::session($user_id)->getTotal();
                                        $count = $carts->count();
                                @endphp
                                <a class="new nav-link" href="#"><i class="mdi mdi-cart-outline text-black product-icon"></i>
                                    <span class="pulse-danger"></span></a>
                                <div class="dropdown-menu">
                                    <div class="menu-header-content bg-primary text-right">
                                        <div class="d-flex">
                                            <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">{{__('message.cart')}}</h6>
                                        </div>
                                        <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">{{__('messagevalidation.users.youhave')}} <b style="color:yellow">{{$count}}</b>  {{__('message.productincart')}}</p>
                                        <a class="btn btn-sm btn-danger" href="{{route('page_cart_deleteall')}}">{{__('message.clearcart')}}</a>
                                    </div>
                                    <div class="main-message-list chat-scroll">
                                        @forelse ($carts as $cart)
                                            <a href="{{ route('page_details', $cart->associatedModel->id)}}" class="p-3 d-flex">
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <h5 class="mb-1 name"> {{__('messagevalidation.users.product')}} :{{$cart->associatedModel->title}}</h5>
                                                    </div>    
                                                    <p class="mb-0 name"> {{__('messagevalidation.users.description')}} :{{$cart->associatedModel->description}} </p>
                                                    <div class="d-flex">
                                                        <p class="mb-0 desc"> {{__('messagevalidation.users.price')}} : <b>{{$cart->associatedModel->price}}</b> </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <p style="margin-left: 25px;margin-right: 25px;"> {{__('message.Quantity')}} : <b style="color: red"> {{$cart->quantity}} </b></p>
                                            <div class="d-flex">
                                                <form action="{{route('page_cart_update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                                    {{ method_field('patch') }}
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{$cart->id}}">
                                                    <div class="d-flex">
                                                        <input placeholder="+{{__('message.Quantity')}}" class="form-control" name="quantity" id="quantity" type="number">
                                                        <button type="submit" class="btn btn-primary"> {{__('message.updatetitle')}} </button>
                                                        <a class="remove-from-cart" href="{{route('page_cart_delete', $cart->id)}}"><i class="fa fa-trash"></i></a> 
                                                    </div>
                                                </form>
                                            </div>
                                        @empty
                                            {{__('message.cartisempty')}}
                                        @endforelse
                                    </div>
                                    <div class="text-center dropdown-footer">
                                        <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                                            {{__('messagevalidation.users.viewall')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
                                {{-- Product & product --}}
                                <div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-right">
										<div class="d-flex">
											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">{{__('messagevalidation.users.notifications')}}</h6>
                                                <span class="badge badge-pill badge-warning mr-auto my-auto float-left">
                                                   <a href="{{route('Notification.Read')}}" > {{__('messagevalidation.users.markallread')}} </a>
                                                </span>
										</div>
										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                            <h6 style="color: yellow" id="notifications_count">
                                                {{__('messagevalidation.users.youhave')}} ({{auth()->user()->unreadNotifications->count()}}) {{__('messagevalidation.users.unreadntf')}}
                                            </h6>
                                        </p>
									</div>
									<div class="main-notification-list Notification-scroll" id="unreadNotifications">
                                        @forelse (auth()->user()->unreadNotifications as $notification)
                                            <a class="d-flex p-3 border-bottom" href="{{ route('page_detailsposts', $notification->data['idd'])}}">
                                                <div class="mr-3">
                                                    <h5 class="notification-label mb-1">{{$notification->data['user_create']}}</h5>
                                                    <div class="notification-subtext">{{$notification->created_at}}</div>
                                                </div>
                                                <div class="mr-auto">
                                                    <i class="las la-angle-left text-left text-muted"></i>
                                                </div>
                                            </a>
                                        @empty
                                            {{__('message.thereareno')}}
                                        @endforelse
									</div>
									<div class="dropdown-footer">
                                        {{-- <div class="dropdown right-toggle"> --}}
                                            <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                                                {{__('messagevalidation.users.viewall')}}
                                            </a>
                                        {{-- </div> --}}
									</div>
								</div>
							</div>
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
                                    <?php
                                        use App\Models\User;
                                        $imageuser = User::query()->select('id')->where('id', '=', Auth::user()->id)->with('image')->get();
                                    ?>
                                    @foreach ($imageuser as $img)
                                        @if (empty($img->image->image))
                                            <a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a>
                                        @else
                                            <a class="profile-user d-flex" href=""><img src="{{URL::asset('storage/'.$img->image->image)}}"></a>
                                        @endif
                                    @endforeach

								{{-- <a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a> --}}
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
                                            @foreach ($imageuser as $img)
                                                @if (empty($img->image->image))
                                                    <div class="main-img-user"><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}" class=""></div>
                                                @else
                                                    <div class="main-img-user"><img alt="" src="{{URL::asset('storage/'.$img->image->image)}}" class=""></div>
                                                @endif
                                            @endforeach
											<div class="mr-3 my-auto">
												<h6>{{Auth::user()->name}}</h6><span>Premium Member</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bx bx-user-circle"></i> {{__('message.Profile')}} </a>
									{{-- <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a> --}}
									{{-- <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a> --}}
									<a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
									<a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>
									<a class="dropdown-item" href="{{ route('auth.destroy') }}"><i class="bx bx-log-out"></i> {{__('message.signout')}}</a>
								</div>
							</div>
							<div class="dropdown main-header-message right-toggle">
								<a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
