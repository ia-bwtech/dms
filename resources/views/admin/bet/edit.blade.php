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
                        <h3 class="card-title">Add bets</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-12">
                        @if ($bet->status==0)
                        <label for="" class="form-control text-center text-danger">Bet is already graded</label>
                        @endif
                            <form action="{{ route($last[1] . '.bets.update', $bet->id) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body">

                                    {{-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Roles</label>
                                    <div class="col-sm-6">
                                     <select required class="form-control" name="role_id" id="role_id">
                                        @foreach ($roles as $item)
                                        <option @if ($bet->role_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>

                                </div> --}}

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-6">
                                            <input value="{{ $bet->game_id }}" disabled required type="text"
                                                name="game_id" class="form-control">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">league</label>
                                        <div class="col-sm-6">
                                            <input type="text" disabled value="{{ $bet->league }}" required
                                                type="text" name="league" class="form-control">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">market name</label>
                                        <div class="col-sm-6">
                                            <input type="text" disabled value="{{ $bet->market_name }}"
                                                name="market_name" class="form-control">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">risk</label>
                                        <div class="col-sm-6">
                                            <input type="text" disabled value="{{ $bet->risk }}" name="risk"
                                                class="form-control">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">odds</label>
                                        <div class="col-sm-6">
                                            <input type="text" disabled value="{{ $bet->odds }}" name="odds"
                                                class="form-control">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Won</label>
                                        <div class="col-sm-6">

                                            <select @if ($bet->created_at->diffInHours(Carbon\Carbon::now()) < 3 || $bet->status==0) disabled @endif required
                                                class="form-control" name="is_won" id="is_won">
                                                <option value="">Select</option>
                                                <option @if ($bet->is_won == 1) selected @endif value="1">Won
                                                </option>
                                                <option @if ($bet->is_won == 0) selected @endif value="0">
                                                    Lost
                                                </option>
                                                <option @if ($bet->is_won == 2) selected @endif value="2">
                                                    Refunded</option>


                                            </select>
                                        </div>

                                        @if ($bet->created_at->diffInHours(Carbon\Carbon::now()) < 3 && $bet->status!=0)
                                        <label for="">You can edit this field 4 hours after the game has
                                            ended.</label>
                                        @endif

                                    </div>


                                    {{-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Profile Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                </div> --}}

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button @if ($bet->created_at->diffInHours(Carbon\Carbon::now()) < 3 || $bet->status==0) disabled @endif type="submit" class="btn btn-info">Submit</button>
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
