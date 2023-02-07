@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <!-- /.card -->
                <!-- Form Element sizes -->
                <!-- /.card -->
                <!-- /.card -->
                <!-- Input addon -->
                <!-- /.card -->
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ ucfirst($cms_fields[0]->page) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div @if ($cms_fields[0]->type == 'fullpage') class="col-md-12" @else class="col-md-8" @endif>
                        <form action="{{ route($last[1] . '.cmss.storecustom', $cms_fields[0]->page) }}" method="POST"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                @foreach ($cms_fields as $item)
                                    @if ($item->type == 'text')
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-2 col-form-label">{{ $item->label }}</label>
                                            <div class="col-sm-6">
                                                <input required type="{{ $item->type }}" value="{{ $item->content }}"
                                                    name="{{ $item->slug }}" class="form-control">

                                            </div>

                                        </div>
                                    @elseif($item->type == 'file')
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-2 col-form-label">{{ $item->label }}</label>
                                            <div class="col-sm-6">
                                                <input type="{{ $item->type }}" name="{{ $item->slug }}"
                                                    class="form-control" accept="audio/*,video/*,image/*">
                                                {{-- <label for="">{{$item->content}}</label> --}}
                                                <img src="{{ $item->content }}" class="img-fluid" alt="">

                                            </div>

                                        </div>
                                    @elseif($item->type == 'textarea')
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-2 col-form-label">{{ $item->label }}</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="{{ $item->slug }}" id="" cols="30" rows="8">{{ $item->content }}</textarea>
                                            </div>

                                        </div>
                                    @elseif($item->type == 'fullpage')
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-2 col-form-label">{{ $item->label }}</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="{{ $item->slug }}" id="tinymce" cols="30" rows="8">{{ $item->content }}</textarea>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer">
                                <button type="submit" class="btn btn-default float-right">Cancel</button>
                            </div>
                            <!-- /.card-footer --> --}}
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div>
    {{-- <script src="https://cdn.tiny.cloud/1/e4iv3pfk2vgmbmx7qwgyxbfwxybwa6dcr1a4x4ic7kg7rera/tinymce/6/tinymce.min.js"> --}}
    {{-- </script> --}}
    <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#tinymce',
            height: 500,
            theme: 'modern',
            plugins: 'advcode code print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            templates: [{
                    title: 'Test template 1',
                    content: 'Test 1'
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2'
                }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
    <style>
        .mce-notification {
            display: none !important;
        }
    </style>
@endsection
