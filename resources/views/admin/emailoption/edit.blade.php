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
                        <h3 class="card-title">Add emailoptions</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-12">

                        <form action="{{ route($last[1] . '.emailoptions.update', $emailoption->id) }}" method="POST"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Your Subscriber bets Notification</label>
                                    <div class="col-sm-6">

                                        <select required class="form-control" name="subscribed_bet_placed" id="subscribed_bet_placed">
                                            <option value="">Select</option>
                                            <option @if ($emailoption->subscribed_bet_placed == 1) selected @endif value="1">Yes
                                            </option>
                                            <option @if ($emailoption->subscribed_bet_placed == 0) selected @endif value="0">
                                                No
                                            </option>


                                        </select>
                                    </div>



                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Bet Lost Notification</label>
                                    <div class="col-sm-6">

                                        <select required class="form-control" name="bet_lost" id="bet_lost">
                                            <option value="">Select</option>
                                            <option @if ($emailoption->bet_lost == 1) selected @endif value="1">Yes
                                            </option>
                                            <option @if ($emailoption->bet_lost == 0) selected @endif value="0">
                                                No
                                            </option>


                                        </select>
                                    </div>



                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Bet Placed Notification</label>
                                    <div class="col-sm-6">

                                        <select required class="form-control" name="bet_placed" id="bet_placed">
                                            <option value="">Select</option>
                                            <option @if ($emailoption->bet_placed == 1) selected @endif value="1">Yes
                                            </option>
                                            <option @if ($emailoption->bet_placed == 0) selected @endif value="0">
                                                No
                                            </option>


                                        </select>
                                    </div>



                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Bet Won Notification</label>
                                    <div class="col-sm-6">

                                        <select required class="form-control" name="bet_won" id="bet_won">
                                            <option value="">Select</option>
                                            <option @if ($emailoption->bet_won == 1) selected @endif value="1">Yes
                                            </option>
                                            <option @if ($emailoption->bet_won == 0) selected @endif value="0">
                                                No
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
@endsection
