@extends('layouts.master')
@section('title')
    {{__('messagevalidation.users.Categories')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">

    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">

    <!--Internal  Quill css -->
    <link href="{{URL::asset('assets/plugins/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/quill/quill.bubble.css')}}" rel="stylesheet">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('messagevalidation.users.Categories')}}</h4>
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

				<!-- row -->
				<div class="row">

                    {{-- Index --}}
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{__('messagevalidation.users.addcatgeory')}}</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('message.title')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.status')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.image')}}</th>
                                                    {{-- <th class="border-bottom-0">Children</th> --}}
                                                    <th class="border-bottom-0"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categoriesindex as $x)
                                                    <tr>
                                                        <td>{{$x->id}}</td>
                                                        <td>{{$x->title}}</td>
                                                        <td>
                                                            @if ($x->status == 0)
                                                                <a href="{{route('categories.editstatusdéactive', $x->id)}}">{{__('messagevalidation.users.disabled')}}</a>
                                                            @endif
                                                            @if ($x->status == 1)
                                                                <a href="{{route('categories.editstatusactive', $x->id)}}">{{__('messagevalidation.users.active')}}</a>
                                                            @endif
                                                        </td>
                                                        <td><img src="{{asset('storage/'.$x->image)}}" alt="" style="height: 50px; width:50px;"></td>
                                                        <td>
                                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                    data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                                    data-image="{{ $x->image }}" data-toggle="modal"
                                                                    href="#exampleModal2" title="Update">
                                                                    <i class="las la-pen"></i></a>
                                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                    data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                                    data-toggle="modal" href="#modaldemo9" title="Delete">
                                                                    <i class="las la-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Create -->
                        <div class="modal" id="modaldemo8">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{__('messagevalidation.users.addcatgeory')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                        <div class="modal-body">
                                            <form action="{{route('categories.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                                @csrf
                                                    <div class="form-group">
                                                        <input placeholder="{{__('messagevalidation.users.titleen')}}" type="text" value="{{old('title_en')}}" class="form-control @error('title_en') is-invalid @enderror" id="title_en" name="title_en">
                                                        <br>
                                                        <input placeholder="{{__('messagevalidation.users.titlear')}}" type="text" value="{{old('title_ar')}}" class="form-control @error('title_ar') is-invalid @enderror" id="title_ar" name="title_ar">
                                                        <br>
                                                        <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" id="image" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"/>
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
                                        <form action="{{route('categories.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="hidden" name="id" id="id">
                                                <input placeholder="{{__('messagevalidation.users.title')}}" class="form-control" name="title_{{app()->getLocale()}}" id="title" type="text">
                                            </div>
                                            <div class="form-group">
                                                <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" id="image" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"/>
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
                                    <form action="{{route('categories.delete')}}" method="post">
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
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #description').val(description);
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

    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
    <!--Internal quill js -->
    <script src="{{URL::asset('assets/plugins/quill/quill.min.js')}}"></script>
@endsection
