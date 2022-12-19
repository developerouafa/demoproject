@extends('layouts.master')
@section('title')
{{__('messagevalidation.users.children')}}
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
							<h4 class="content-children mb-0 my-auto">{{__('messagevalidation.users.children')}}</h4>
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
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{__('messagevalidation.users.addchildren')}}</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.children')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.category')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.image')}}</th>
                                                    <th class="border-bottom-0"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($childrens as $x)
                                                    @if ($x->status == 0)
                                                        <tr>
                                                            <td>{{$x->id}}</td>
                                                            <td>{{$x->title}}</td>
                                                            <td>{{$x->category->title}}</td>
                                                            <td><img src="{{asset('storage/'.$x->image)}}" alt="" style="height: 50px; width:50px;"></td>
                                                            <td>
                                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                    data-id="{{ $x->id }}" data-children="{{ $x->title }}"
                                                                    data-category_id="{{ $x->parent_id }}" data-toggle="modal"
                                                                    href="#exampleModal2" children="Update">
                                                                    <i class="las la-pen"></i></a>
                                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                    data-id="{{ $x->id }}" data-children="{{ $x->title }}"
                                                                    data-toggle="modal" href="#modaldemo9" children="Delete">
                                                                    <i class="las la-trash"></i></a>
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
                                    <h6 class="modal-children">{{__('messagevalidation.users.addchildren')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                    <div class="modal-body">
                                        <form action="{{route('childcat.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                                <div class="form-group">
                                                    {{-- <input placeholder="{{__('messagevalidation.users.children')}}" type="text" value="{{old('children')}}" class="form-control @error('children') is-invalid @enderror" id="children" name="children">
                                                    <br> --}}

                                                    <input placeholder="{{__('messagevalidation.users.childrenen')}}" type="text" value="{{old('childrenen')}}" class="form-control @error('childrenen') is-invalid @enderror" id="childrenen" name="title_en">
                                                    <br>
                                                    <input placeholder="{{__('messagevalidation.users.childrenar')}}" type="text" value="{{old('childrenar')}}" class="form-control @error('childrenar') is-invalid @enderror" id="childrenar" name="title_ar">
                                                    <br>

                                                    <select name="category_id" value="{{old('category_id')}}" class="form-control SlectBox" class="@error('category_id') is-invalid @enderror">
                                                        <option value="" selected disabled>{{__('messagevalidation.users.Categories')}}</option>
                                                            @forelse ($categories as $categoryone)
                                                                @if ($categoryone->status == 0)
                                                                    <option value="{{ $categoryone->id }}"> {{ $categoryone->title }} </option>
                                                                @endif
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">{{__('messagevalidation.users.nocategoryyet')}}</td>
                                                                </tr>
                                                            @endforelse
                                                    </select>
                                                    <br>
                                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png">
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

                    <!-- edit -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-children" id="exampleModalLabel">{{__('message.updatetitle')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('childcat.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                        {{ method_field('patch') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id">
                                            <input placeholder="{{__('messagevalidation.users.children')}}" class="form-control" name="children" id="children" type="text">
                                        </div>
                                        <div class="form-group">
                                            <select name="category_id" class="form-control SlectBox" id="category_id">
                                                <option value="" selected disabled>{{__('messagevalidation.users.Categories')}}</option>
                                                    @forelse ($categories as $category)
                                                        @if ($category->status == 0)
                                                            <option value="{{ $category->id }}"> {{ $category->title }} </option>
                                                        @endif
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">{{__('messagevalidation.users.nocategoryyet')}}</td>
                                                        </tr>
                                                    @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" id="image" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png">
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
                                    <h6 class="modal-children">{{__('message.deletee')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                        type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('childcat.delete')}}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <p>{{__('message.aresuredeleting')}}</p><br>
                                        <input type="hidden" name="id" id="id">
                                        <input class="form-control" name="children" id="children" type="text" readonly>
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
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var children = button.data('children')
            var category_id = button.data('category_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #children').val(children);
            modal.find('.modal-body #category_id').val(category_id);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var children = button.data('children')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #children').val(children);
        })
    </script>
@endsection
