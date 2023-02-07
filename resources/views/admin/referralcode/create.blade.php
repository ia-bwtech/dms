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
                    <div class="col-md-8 ">
                        <form action="{{ route($last[1] . '.referralcodes.store') }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input required type="text" name="name" class="form-control">
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Agent Name</label>
                                    <div class="col-sm-6">
                                        <input required type="text" name="agent_name" class="form-control">
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
@endsection
