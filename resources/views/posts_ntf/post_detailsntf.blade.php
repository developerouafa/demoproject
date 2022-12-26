@extends('layouts.master')
@section('title')
    {{__('messagevalidation.users.postdetails')}}
@endsection
@section('css')
    <!--Internal  Nice-select css  -->
        <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <!-- Internal Select2 css -->
        <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!---Internal  Owl Carousel css-->
        <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!---Internal  Multislider css-->
        <link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('messagevalidation.users.postdetails')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
                </div>
            </div>
            <div class="d-flex my-xl-auto right-content">
                <div class="pr-1 mb-3 mb-xl-0">
                    <button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
                </div>
                <div class="pr-1 mb-3 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
                </div>
                <div class="pr-1 mb-3 mb-xl-0">
                    <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
                </div>
                <div class="mb-3 mb-xl-0">
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary">14 Aug 2019</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
                            <a class="dropdown-item" href="#">2015</a>
                            <a class="dropdown-item" href="#">2016</a>
                            <a class="dropdown-item" href="#">2017</a>
                            <a class="dropdown-item" href="#">2018</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if (!empty($posts))
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body h-100">
                        <div class="row row-sm ">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="preview-pic tab-content">
                                        <div class="tab-pane active" id="pic-1">
                                            <img src="{{asset('storage/'.$posts->image)}}" alt="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                                <h4 class="product-title mb-1">{{$posts->title}}</h4><br>
                                <h6 class="price"> {{__('messagevalidation.users.Categories')}} : {{$posts->category->title}}
                                    <span class="ml-2"> {{__('messagevalidation.users.children')}} : {{$posts->subcategories->title}}</span>
                                </h6>
                                <p class="product-description"> <b>{{__('messagevalidation.users.description')}} : {{$posts->body}}</b> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body h-100">
                    <div class="row row-sm">
                        <div class="col-xl-5 col-lg-12 col-md-12">
                            <div class="card custom-card">
                                <div class="card-body ht-100p">
                                    <div id="basicSlider">
                                        <div class="MS-content">
                                            @foreach ($images as $x)
                                                <div class="item">
                                                    <img src="{{asset('product_images/'.$x->multimg)}}" alt="image" style="width: 150px; height:100px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                            <h4 class="product-title mb-1">{{$products->title}}</h4><br>
                            <h6 class="price"> {{__('messagevalidation.users.Categories')}} : {{$products->category->title}}
                                <span class="ml-2"> {{__('messagevalidation.users.children')}} : {{$products->subcategories->title}}</span>
                            </h6>
                            <h6 class="price"> {{__('messagevalidation.users.price')}} : <span class="h3 ml-2">{{$products->price}}</span></h6>
                            <b class="product-description"> {{__('messagevalidation.users.description')}} : {{$products->description}}</b>
                            <div class="sizes d-flex">  {{__('messagevalidation.users.colors')}} :
                                @foreach ($product_color as $x)
                                        <span class="size d-flex"  data-toggle="tooltip" title="small">
                                            <label class="rdiobox mb-0">
                                                <b><input type="color" value="{{$x->color}}" class="form-control" style="width: 70px;"></b>
                                            </label>
                                        </span>
                                @endforeach
                            </div>
                            <div class="sizes d-flex">  {{__('messagevalidation.users.size')}} :
                                @foreach ($sizes as $x)
                                        <span class="size d-flex"  data-toggle="tooltip" title="small">
                                            <label class="rdiobox mb-0">
                                                <b>{{__('messagevalidation.users.height')}} : {{$x->height}}</b>
                                                <b>{{__('messagevalidation.users.width')}} : {{$x->width}}</b>
                                            </label>
                                        </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2.min js -->
        <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/select2.js')}}"></script>
    <!-- Internal Nice-select js-->
        <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!--Internal  Datepicker js -->
        <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
        <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Owl Carousel js-->
        <script src="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.js')}}"></script>
    <!---Internal  Multislider js-->
        <script src="{{URL::asset('assets/plugins/multislider/multislider.js')}}"></script>
        <script src="{{URL::asset('assets/js/carousel.js')}}"></script>
@endsection
