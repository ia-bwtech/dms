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
                        <h3 class="card-title">Add Complain</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-8 ">
                        <form action="{{ route($last[1] . '.complains.update', $complain->id) }}" method="POST"
                            class="form-horizontal" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Subject</label>
                                    <div class="col-sm-6">
                                        <input value="{{ $complain->subject }}" required type="text" name="subject"
                                            class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Complain</label>
                                    <div class="col-sm-6">
                                        <textarea required class="form-control" name="complain" id="" cols="30" rows="8">{{ $complain->complain }}</textarea>
                                    </div>

                                </div>
                                @if (auth()->user()->is_admin == 1)
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-6">
                                            <select required class="form-control" name="status" id="status">
                                                <option value="">Select</option>
                                                <option @if ($complain->status == 0) selected @endif value="0">
                                                    Received</option>
                                                <option @if ($complain->status == 1) selected @endif value="1">In
                                                    Progress</option>
                                                <option @if ($complain->status == 2) selected @endif value="2">
                                                    Resolved</option>


                                            </select>
                                        </div>

                                    </div>
                                @endif
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
