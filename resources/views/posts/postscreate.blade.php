@extends('layouts.master')
@section('title')
    {{__('messagevalidation.users.createposts')}}
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
                <h4 class="content-children mb-0 my-auto">{{__('messagevalidation.users.createposts')}}</h4>
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
            <!-- Basic modal -->
                <div class="modal-body">
                    <form action="{{route('posts.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input placeholder="{{__('messagevalidation.users.titleen')}}" type="text" value="{{old('title_en')}}" class="form-control @error('title_en') is-invalid @enderror" id="title" name="title_en">
                                    </div>
                                    <div class="col-lg-6">
                                        <input placeholder="{{__('messagevalidation.users.titlear')}}" type="text" value="{{old('title_ar')}}" class="form-control @error('title_ar') is-invalid @enderror" id="title_ar" name="title_ar">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <input placeholder="{{__('messagevalidation.users.body')}}" type="text" value="{{old('body_en')}}" class="form-control @error('body_en') is-invalid @enderror" id="body" name="body_en">
                                    </div>
                                    <div class="col-lg-4">
                                        <input placeholder="{{__('messagevalidation.users.bodyar')}}" type="text" value="{{old('body_ar')}}" class="form-control @error('body_ar') is-invalid @enderror" id="body_ar" name="body_ar">
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="tag_id[]" multiple value="{{old('tag_id')}}" class="form-control SlectBox" class="@error('tag_id') is-invalid @enderror" multiselect-search="true" multiselect-select-all="true">
                                            @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">
                                                        {{ $tag->title }}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="inputName" class="control-label">{{__('messagevalidation.users.Categories')}}</label>
                                        <select name="Category" class="form-control SlectBox" onclick="console.log($(this).val())"
                                            onchange="console.log('change is firing')">
                                            <option value="" selected disabled>{{__('messagevalidation.users.selectcategory')}}</option>
                                            @foreach ($categories as $category)
                                                @if ($category->status == 0)
                                                    <option value="{{ $category->id }}"> {{ $category->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputName1" class="control-label">{{__('messagevalidation.users.children')}}</label>
                                        <select id="children" name="children" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" id="image" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"/>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">{{__('message.save')}}</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('message.close')}}</button>
                            </div>
                    </form>
                </div>
            <!-- End Basic modal -->
        </div>
    <!-- row closed -->

			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <script>
        var style = document.createElement('style');
        style.setAttribute("id","multiselect_dropdown_styles");
        style.innerHTML = `
        .multiselect-dropdown{
        display: inline-block;
        padding: 2px 5px 0px 5px;
        border-radius: 4px;
        border: solid 1px #ced4da;
        background-color: white;
        position: relative;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        }
        .multiselect-dropdown span.optext, .multiselect-dropdown span.placeholder{
        margin-right:0.5em;
        margin-bottom:2px;
        padding:1px 0;
        border-radius: 4px;
        display:inline-block;
        }
        .multiselect-dropdown span.optext{
        background-color:lightgray;
        padding:1px 0.75em;
        }
        .multiselect-dropdown span.optext .optdel {
        float: right;
        margin: 0 -6px 1px 5px;
        font-size: 0.7em;
        margin-top: 2px;
        cursor: pointer;
        color: #666;
        }
        .multiselect-dropdown span.optext .optdel:hover { color: #c66;}
        .multiselect-dropdown span.placeholder{
        color:#ced4da;
        }
        .multiselect-dropdown-list-wrapper{
        box-shadow: gray 0 3px 8px;
        z-index: 100;
        padding:2px;
        border-radius: 4px;
        border: solid 1px #ced4da;
        display: none;
        margin: -1px;
        position: absolute;
        top:0;
        left: 0;
        right: 0;
        background: white;
        }
        .multiselect-dropdown-list-wrapper .multiselect-dropdown-search{
        margin-bottom:5px;
        }
        .multiselect-dropdown-list{
        padding:2px;
        height: 15rem;
        overflow-y:auto;
        overflow-x: hidden;
        }
        .multiselect-dropdown-list::-webkit-scrollbar {
        width: 6px;
        }
        .multiselect-dropdown-list::-webkit-scrollbar-thumb {
        background-color: #bec4ca;
        border-radius:3px;
        }

        .multiselect-dropdown-list div{
        padding: 5px;
        }
        .multiselect-dropdown-list input{
        height: 1.15em;
        width: 1.15em;
        margin-right: 0.35em;
        }
        .multiselect-dropdown-list div.checked{
        }
        .multiselect-dropdown-list div:hover{
        background-color: #ced4da;
        }
        .multiselect-dropdown span.maxselected {width:100%;}
        .multiselect-dropdown-all-selector {border-bottom:solid 1px #999;}
        `;
        document.head.appendChild(style);

        function MultiselectDropdown(options){
        var config={
            search:true,
            height:'15rem',
            placeholder:'select',
            txtSelected:'selected',
            txtAll:'All',
            txtRemove: 'Remove',
            txtSearch:'search',
            ...options
        };
        function newEl(tag,attrs){
            var e=document.createElement(tag);
            if(attrs!==undefined) Object.keys(attrs).forEach(k=>{
            if(k==='class') { Array.isArray(attrs[k]) ? attrs[k].forEach(o=>o!==''?e.classList.add(o):0) : (attrs[k]!==''?e.classList.add(attrs[k]):0)}
            else if(k==='style'){
                Object.keys(attrs[k]).forEach(ks=>{
                e.style[ks]=attrs[k][ks];
                });
            }
            else if(k==='text'){attrs[k]===''?e.innerHTML='&nbsp;':e.innerText=attrs[k]}
            else e[k]=attrs[k];
            });
            return e;
        }


        document.querySelectorAll("select[multiple]").forEach((el,k)=>{

            var div=newEl('div',{class:'multiselect-dropdown',style:{width:config.style?.width??el.clientWidth+'px',padding:config.style?.padding??''}});
            el.style.display='none';
            el.parentNode.insertBefore(div,el.nextSibling);
            var listWrap=newEl('div',{class:'multiselect-dropdown-list-wrapper'});
            var list=newEl('div',{class:'multiselect-dropdown-list',style:{height:config.height}});
            var search=newEl('input',{class:['multiselect-dropdown-search'].concat([config.searchInput?.class??'form-control']),style:{width:'100%',display:el.attributes['multiselect-search']?.value==='true'?'block':'none'},placeholder:config.txtSearch});
            listWrap.appendChild(search);
            div.appendChild(listWrap);
            listWrap.appendChild(list);

            el.loadOptions=()=>{
            list.innerHTML='';

            if(el.attributes['multiselect-select-all']?.value=='true'){
                var op=newEl('div',{class:'multiselect-dropdown-all-selector'})
                var ic=newEl('input',{type:'checkbox'});
                op.appendChild(ic);
                op.appendChild(newEl('label',{text:config.txtAll}));

                op.addEventListener('click',()=>{
                op.classList.toggle('checked');
                op.querySelector("input").checked=!op.querySelector("input").checked;

                var ch=op.querySelector("input").checked;
                list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")
                    .forEach(i=>{if(i.style.display!=='none'){i.querySelector("input").checked=ch; i.optEl.selected=ch}});

                el.dispatchEvent(new Event('change'));
                });
                ic.addEventListener('click',(ev)=>{
                ic.checked=!ic.checked;
                });

                list.appendChild(op);
            }

            Array.from(el.options).map(o=>{
                var op=newEl('div',{class:o.selected?'checked':'',optEl:o})
                var ic=newEl('input',{type:'checkbox',checked:o.selected});
                op.appendChild(ic);
                op.appendChild(newEl('label',{text:o.text}));

                op.addEventListener('click',()=>{
                op.classList.toggle('checked');
                op.querySelector("input").checked=!op.querySelector("input").checked;
                op.optEl.selected=!!!op.optEl.selected;
                el.dispatchEvent(new Event('change'));
                });
                ic.addEventListener('click',(ev)=>{
                ic.checked=!ic.checked;
                });
                o.listitemEl=op;
                list.appendChild(op);
            });
            div.listEl=listWrap;

            div.refresh=()=>{
                div.querySelectorAll('span.optext, span.placeholder').forEach(t=>div.removeChild(t));
                var sels=Array.from(el.selectedOptions);
                if(sels.length>(el.attributes['multiselect-max-items']?.value??5)){
                div.appendChild(newEl('span',{class:['optext','maxselected'],text:sels.length+' '+config.txtSelected}));
                }
                else{
                sels.map(x=>{
                    var c=newEl('span',{class:'optext',text:x.text, srcOption: x});
                    if((el.attributes['multiselect-hide-x']?.value !== 'true'))
                    c.appendChild(newEl('span',{class:'optdel',text:'🗙',title:config.txtRemove, onclick:(ev)=>{c.srcOption.listitemEl.dispatchEvent(new Event('click'));div.refresh();ev.stopPropagation();}}));

                    div.appendChild(c);
                });
                }
                if(0==el.selectedOptions.length) div.appendChild(newEl('span',{class:'placeholder',text:el.attributes['placeholder']?.value??config.placeholder}));
            };
            div.refresh();
            }
            el.loadOptions();

            search.addEventListener('input',()=>{
            list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(d=>{
                var txt=d.querySelector("label").innerText.toUpperCase();
                d.style.display=txt.includes(search.value.toUpperCase())?'block':'none';
            });
            });

            div.addEventListener('click',()=>{
            div.listEl.style.display='block';
            search.focus();
            search.select();
            });

            document.addEventListener('click', function(event) {
            if (!div.contains(event.target)) {
                listWrap.style.display='none';
                div.refresh();
            }
            });
        });
        }

        window.addEventListener('load',()=>{
        MultiselectDropdown(window.MultiselectDropdownOptions);
        });
    </script>

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
@endsection

