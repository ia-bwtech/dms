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
                        <h3 class="card-title">Add package</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-8 ">
                        <form action="{{ route($last[1] . '.packages.store') }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <label for="">
                                </label>
                                @if (auth()->user()->is_admin == 1)
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>
                                        <div class="col-sm-6">
                                            <select required class="form-control" name="user_id" id="user_id">
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                @else
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endif
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-6">
                                        <input required type="text" name="name" class="form-control">
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-6">
                                        <input required type="number" name="price" class="form-control">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Duration</label>
                                    <div class="col-sm-6">
                                        <select required class="form-control" name="duration" id="duration">
                                            <option value="">Select</option>
                                            <option value="daily">daily</option>
                                            <option value="weekly">weekly</option>
                                            <option value="monthly">monthly</option>
                                            <option value="custom">Custom</option>


                                        </select>
                                    </div>

                                </div>
                                <div id="dateShow">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="country">From Date</label>
                                        <div class="col-sm-6">
                                            <input min="@php echo date('Y-m-d') @endphp" type="date"
                                            name="from_date" id="" class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="country">To Date</label>
                                        <div class="col-sm-6">
                                            <input min="@php echo date('Y-m-d') @endphp" type="date"
                                            name="to_date" id="" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Visible  </label>
                                    <div class="col-sm-6">
                                        <select required class="form-control" name="status" id="status">
                                            <option value="">Select</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>


                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                        <textarea required class="form-control" name="description" id="" cols="30" rows="8"></textarea>
                                    </div>

                                </div>

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


@endsection
