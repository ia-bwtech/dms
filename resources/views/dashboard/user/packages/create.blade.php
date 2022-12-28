@extends('layouts.dashboard.app')
@section('content')

<div class="row">
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">     
                <form action="{{ route('package.store') }}" method="POST">
                    @csrf
                    <h1>New Package</h1>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label for="email">Package Title</label>
                                <input value="{{ old('name') }}" name="name" required type="text" class="form-control" id="name" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label for="email">Package Description</label>
                                <textarea value="{{ old('description') }}" required name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label for="email">Package Price</label>
                                <input value="{{ old('price') }}" required name="price" type="number" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label class="my-1 me-2" for="country">Package Type</label>
                                <select value="{{ old('duration') }}" required name="duration" class="form-select" id="duration" aria-label="Default select example">
                                    {{-- <option selected>Open this select menu</option> --}}
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="dateShow">
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="my-1 me-2" for="country">From Date</label>
                                    <input min="@php echo date('Y-m-d') @endphp" type="date" name="from_date" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="my-1 me-2" for="country">To Date</label>
                                    <input min="@php echo date('Y-m-d') @endphp" type="date" name="to_date" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                {{-- <input type="number" class="form-control" id="email" aria-describedby="emailHelp"> --}}
                                {{-- <a href="" class="btn btn-primary">Submit</a> --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</div>

<script>
    $(document).ready(
    function(){
        $("#dateShow").hide();
        $("#duration").click(function () {
            if($('#duration').find(":selected").text() == 'Custom') {
                $("#dateShow").toggle();
            }
        });

    });
</script>

@endsection