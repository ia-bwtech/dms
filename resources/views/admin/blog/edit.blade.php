@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid ">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 ">
                <!-- general form elements -->
                <!-- /.card -->
                <!-- Form Element sizes -->
                <!-- /.card -->
                <!-- /.card -->
                <!-- Input addon -->
                <!-- /.card -->
                <!-- Horizontal Form -->
                <div class="card card-info black">
                    <div class="card-header">
                        <h3 class="card-title">Add blog</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-12">
                        <form action="{{ route($last[1] . '.blogs.update', $blog->id) }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Blog Categories</label>
                                    <div class="col-sm-12">
                                        <select required class="form-control" name="category_id" id="category_id">
                                            @foreach ($blogcategories as $item)
                                                <option @if ($item->id == $blog->category_id) selected @endif
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-12">
                                        <input value="{{ $blog->title }}" required type="text" name="title"
                                            class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Banner</label>
                                    <div class="col-sm-12">
                                        <input type="file" name="banner" class="form-control">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Banner Description</label>
                                    <div class="col-sm-12">
                                        <textarea required class="form-control" name="banner_description" id="" cols="30" rows="3">{{ $blog->banner_description }}</textarea>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Excerpt Text</label>
                                    <div class="col-sm-12">
                                        <textarea required class="form-control" name="short_text" id="" cols="30" rows="3">{{$blog->short_text}}</textarea>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Meta Title</label>
                                    <div class="col-sm-12">
                                        <input required type="text" name="meta_title" class="form-control" value="{{$blog->meta_title}}">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Meta Description</label>
                                    <div class="col-sm-12">
                                        <textarea required class="form-control" name="meta_description" id="" cols="30" rows="3">{{$blog->meta_description}}</textarea>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Blog</label>
                                    <div class="col-sm-12">
                                        <textarea id="tinymce" required class="form-control" name="blog" id="" cols="30" rows="8">{{ $blog->blog }}</textarea>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Published</label>
                                    <div class="col-sm-12">
                                        <select required class="form-control" name="published" id="published">
                                            <option value="">Select</option>
                                            <option @if ($blog->published == 0) selected @endif value="0">Not Yet
                                            </option>
                                            <option @if ($blog->published == 1) selected @endif value="1">Yes
                                            </option>


                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
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
    <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js">
    </script>

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
