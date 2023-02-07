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
                        <h3 class="card-title">Add User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-8 " >
                        <form action="{{ route($last[1].'.users.store') }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                {{-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="role_id" id="role_id">
                                            @foreach ($roles as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div> --}}
                                @foreach ($cms_fields as $item)

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{$item->slug}}</label>
                                    <div class="col-sm-6">
                                        <input required type="{{$item->type}}" name="{{$item->slug}}" class="form-control">
                                    </div>

                                </div>

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

    <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js"></script>

@endsection
