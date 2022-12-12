@extends('layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/img/media/login.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 d-flex"> <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28"><span> {{__('message.Dashboard')}} </span></h1></div>
                                            <div class="mb-4 text-sm text-gray-600">
                                                {{ __('message.Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                                            </div>
                                            @if (session('status') == 'verification-link-sent')
                                                <div class="mb-4 font-medium text-sm text-green-600">
                                                    {{ __('message.A new verification link has been sent to the email address you provided during registration.') }}
                                                </div>
                                            @endif
                                            <div class="mb-2 items-center justify-between">
                                                <form method="POST" action="{{ route('verification.send') }}">
                                                    @csrf
                                                    <div>
                                                        <x-primary-button>
                                                            {{ __('message.Resend Verification Email') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">
                                                        {{ __('message.Log Out') }}
                                                    </button>
                                                </form>
                                            </div>
									    </div>
								    </div>
							    </div>
						    </div><!-- End -->
					    </div>
				    </div><!-- End -->
			    </div>
            </div>
        </div>
@endsection
@section('js')
@endsection
