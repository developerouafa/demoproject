@extends('layouts.master')
@section('title')
{{__('messagevalidation.users.products')}}
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-children mb-0 my-auto">{{__('messagevalidation.users.products')}}</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

				<!-- row -->
    <div class="row">

        {{-- <div class="row row-sm"> --}}
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-outline-primary btn-block" href="{{route('product.createprod')}}">{{__('messagevalidation.users.addproducts')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('messagevalidation.users.title')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.description')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.price')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.category')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.children')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.image')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.color')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.size')}}</th>
                                        <th scope="col">{{__('messagevalidation.users.status')}}</th>
                                        {{-- <th scope="col">{{__('messagevalidation.users.promotion')}}</th> --}}
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $x)
                                        @if ($x->category->status == 0)
                                            <tr>
                                                <td>{{$x->id}}</td>
                                                <td>{{$x->title}}</td>
                                                <td>{{$x->description}}</td>
                                                <td>{{$x->price}}</td>
                                                <td>{{$x->category->title}}</td>
                                                <td>{{$x->subcategories->title}}</td>
                                                <td><a href="{{ url('images/images') }}/{{ $x->id }}">View Images</a></td>
                                                <td><a href="{{ url('product_color/product_color') }}/{{ $x->id }}">View Color</a></td>
                                                <td><a href="{{ url('sizes/sizes') }}/{{ $x->id }}">View Size</a></td>
                                                <td>
                                                    @if ($x->status == 0)
                                                        <a href="{{route('products.editstatusdéactive', $x->id)}}">{{__('messagevalidation.users.disabled')}}</a>
                                                    @endif
                                                    @if ($x->status == 1)
                                                        <a href="{{route('products.editstatusactive', $x->id)}}">{{__('messagevalidation.users.active')}}</a>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    @forelse ($x->promotion as $promo)
                                                        @if ($promo->expired == 0)
                                                            <a href="{{ url('promotions/promotions') }}/{{ $x->id }}">* There is an upgrade for the Product: <b>{{$x->title}}</b> </a>
                                                            @if ($promo->end_time == date('Y-m-d'))
                                                                <a href="{{ url('promotions/promotions') }}/{{ $x->id }}">* promotion expired </a>
                                                            @endif
                                                        @else
                                                            <a href="{{ url('promotions/promotions') }}/{{ $x->id }}">* Cancel the promotion: <b>{{$x->title}}</b> </a>
                                                        @endif
                                                    @empty
                                                        <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-price="{{ $x->price }}" data-toggle="modal"
                                                        href="#modaldemopromotion">Add Promotion</a>
                                                    @endforelse ()
                                                </td> --}}
                                                <td>
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                            data-description="{{ $x->description }}" data-price="{{ $x->price }}" data-category_id="{{ $x->category->title }}" data-children_id="{{ $x->subcategories->title }}" data-toggle="modal"
                                                            href="#exampleModal2" title="Update">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                </td>
                                                <td>
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                                            <i class="las la-trash"></i>
                                                        </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}


        <!-- Basic modal -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Add Product</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                        <div class="modal-body">
                            <form action="{{route('product.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                    <div class="form-group">
                                        <input placeholder="Enter Title" type="text" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                                        <br>
                                        <input placeholder="Enter Description" type="text" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                        <br>
                                        <input placeholder="Enter Price" type="text" value="{{old('price')}}" class="form-control @error('price') is-invalid @enderror" id="price" name="price">
                                        <br>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Categories</label>
                                            <select name="Category" class="form-control SlectBox" onclick="console.log($(this).val())"
                                                onchange="console.log('change is firing')">
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach ($categories as $category)
                                                    @if ($category->status == 0)
                                                        <option value="{{ $category->id }}"> {{ $category->title }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col">
                                            <label for="inputName1" class="control-label">Children</label>
                                            <select id="children" name="children" class="form-control">
                                            </select>
                                        </div>
                                        <br>
                                        <input type="file" name="image[]" class="form-control" accept="image/*" multiple>
                                        <br>
                                            <select name="color_id" value="{{old('color')}}" class="form-control SlectBox" class="@error('color') is-invalid @enderror">
                                                <option value="" selected disabled>Colors</option>
                                                    {{-- @forelse ($colors as $color)
                                                            <option value="{{ $color->id }}"> {{ $color->title }} </option>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No Colors yet!</td>
                                                        </tr>
                                                    @endforelse --}}
                                            </select>
                                        <br>
                                        <input placeholder="Enter Width" type="number" value="{{old('width')}}" class="form-control @error('width') is-invalid @enderror" id="width" name="width">
                                        <br>
                                        <input placeholder="Enter Height" type="number" value="{{old('height')}}" class="form-control @error('height') is-invalid @enderror" id="height" name="height">
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">{{__('message.save')}}</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('message.close')}}</button>
                                    </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->

                <!-- Basic modal -->
                <div class="modal" id="modaldemopromotion">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Add Promotion</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                                <div class="modal-body">
                                    {{-- <form action="{{route('promotions.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" id="id">
                                                <label for="price">Update Price Promotion</label>
                                                <input placeholder="Update Price Promotion" class="form-control" name="price" id="price" type="text">
                                                <br>
                                                <label for="price">Start_time</label>
                                                <input class="form-control fc-datepicker" name="start_time" placeholder="YYYY-MM-DD"
                                                type="date" value="{{ date('Y-m-d') }}" id="start_time" required>
                                                <br>
                                                <label for="price">End_time</label>
                                                <input class="form-control fc-datepicker" name="end_time" placeholder="YYYY-MM-DD"
                                                type="date" id="end_time" required>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn ripple btn-primary" type="submit">Save changes</button>
                                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                            </div>
                                    </form> --}}
                                </div>
                        </div>
                    </div>
                </div>
                <!-- End Basic modal -->

                <!-- edit -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('message.updatetitle')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('product.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                        {{ method_field('patch') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id">
                                            <input placeholder="{{__('messagevalidation.users.title')}}" class="form-control" name="title" id="title" type="text">
                                            <br>
                                            <input placeholder="{{__('messagevalidation.users.description')}}" type="text" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                            <br>
                                            <input placeholder="{{__('messagevalidation.users.price')}}" class="form-control" name="price" id="price" type="text">
                                            <br>
                                            <div class="col">
                                                <label for="inputName" class="control-label">{{__('messagevalidation.users.Categories')}}</label>
                                                <select name="Category" class="form-control SlectBox" onclick="console.log($(this).val())"
                                                    onchange="console.log('change is firing')">
                                                    <!--placeholder-->
                                                    <option value="" selected disabled>{{__('messagevalidation.users.selectcategory')}}</option>
                                                    @foreach ($categories as $category)
                                                        @if ($category->status == 0)
                                                            <option value="{{ $category->id }}"> {{ $category->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col">
                                                <label for="inputName1" class="control-label">{{__('messagevalidation.users.children')}}</label>
                                                <select id="children" name="children" class="form-control">
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">{{__('message.save')}}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- delete -->
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">{{__('message.deletee')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                        type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('product.delete')}}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <p>{{__('message.aresuredeleting')}}</p><br>
                                        <input type="hidden" name="id" id="id">
                                        <input class="form-control" name="title" id="title" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                        <button type="submit" class="btn btn-danger">{{__('message.deletee')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

    </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
    $(document).ready(function() {
        $('select[name="Category"]').on('change', function() {
            var CategoryId = $(this).val();
            if (CategoryId) {
                $.ajax({
                    url: "{{ URL::to('category') }}/" + CategoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="children"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="children"]').append('<option value="' +
                            value + '">' + key + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var title = button.data('title')
        var description = button.data('description')
        var category_id = button.data('category_id')
        var children_id = button.data('children_id')
        var price = button.data('price')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #title').val(title);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #category_id').val(category_id);
        modal.find('.modal-body #children_id').val(children_id);
        modal.find('.modal-body #price').val(price);
    })
</script>

<script>
    $('#modaldemopromotion').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var price = button.data('price')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #price').val(price);
    })
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var title = button.data('title')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #title').val(title);
    })
</script>
@endsection
