{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
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
                                <div class="mb-5 d-flex">
                                    <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28"><span>{{__('message.Dashboard')}}</span></h1>
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
                                </div>
                                <div class="main-signup-header">
                                    <h2 class="text-primary">{{__('message.Get Started')}}</h2>
                                    <h5 class="font-weight-normal mb-4">{{__('message.It\'s free to signup and only takes a minute.')}}</h5>
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{__('message.firstlastenglish')}}</label>
                                            <input class="form-control" placeholder="{{__('message.enteryourfirstnameandlastname')}}" type="text" name="name" :value="old('name')" required autofocus >
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('message.firstlastarabe')}}</label>
                                            <input class="form-control" placeholder="{{__('message.enteryourfirstnameandlastname')}}" type="text" name="namear" :value="old('namear')" required autofocus >
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('message.Email')}}</label>
                                            <input class="form-control" type="email" name="email" :value="old('email')" required placeholder="{{__('message.enteryouremail')}}" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('message.Password')}}</label>
                                            <input type="password" name="password" required autocomplete="new-password" class="form-control" placeholder="{{__('message.enteryoupassword')}}"/>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('message.Confirm Password')}}</label>
                                            <input type="password" name="password_confirmation" required class="form-control" placeholder="{{__('message.enteryoupassword')}}"/>
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>
                                        <button class="btn btn-main-primary btn-block">{{__('message.Create Account')}}</button>
                                    </form>
                                    <div class="row row-xs">
                                        <div class="col-sm-6">
                                            <a href="{{ route('github.login') }}"><button class="btn btn-block"><i class="fab fa-github"></i>{{__('message.signupwithgithub')}}</button></a>
                                        </div>
                                    </div>
                                    <div class="main-signup-footer mt-5">
                                        <p>{{__('message.Already have an account?')}} <a href="{{ url('/' . $page='login') }}">{{__('message.Sign In')}}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
</div>
@endsection
@section('js')
@endsection
