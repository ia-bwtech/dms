@extends('admin.layouts.app')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="filtersdiv">

                <style>
                    .filter-control {
                        display: inline;
                    }

                    .filters .select2-container--default .select2-selection--single {
                        /* width: 220px; */
                    }

                </style>

                @include('admin.layouts.date-filter',['role'=>0,'route'=>'packagesajax'])
            </div>

            <div class="row mb-2">
                <div class=" heading col-sm-6">
                    <h1>Packages</h1>
                </div>
                {{-- <button class="btn1 info filterbtn">Filter</button> --}}
                <div class="col-sm-2">
                    <span data-toggle="tooltip" title="Filter" class="filterbtn"><i id="icon"
                            class='fas fa-angle-down icon'></i></span>
                </div>
                <div class=" offset-sm-2  col-sm-2">
                    <h1 class="float-sm-right"><span id="total"
                            class="badge badge-pill total">{{ $packages->total() }}</span></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <style>
        .btn1 {
            border: 2px solid black;
            background-color: white;
            color: black;
            padding: 8px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 25px;
        }

        .info {
            border-color: #1F6182;
            color: #1F6182;
        }

        .info:hover {
            background: #1F6182;
            color: white;
        }

    </style>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card searcharea">
                    <div class="align-right">
                    </div>
                    <div class="card-header">
                        <br>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <form style="display: flex;" action="{{ route('admins.packages.index') }}">
                                    <div class="input-group border rounded-pill m-1 ">
                                        <input name="keyword" id="keyword" type="search" placeholder="Search"
                                            aria-describedby="button-addon3" class="form-control bg-none border-0">
                                        <div class="input-group-append border-0">
                                            <button type="button" id="button-addon3" type="button"
                                                class="btn btn-link text-blue"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>

                                {{-- <a href="{{ route('products.import') }}"><button type="button"
                                        class="btn btn-danger rounded-pill specialbutton m-1">Import products</button></a> --}}
                                <a href="{{ route('admins.packages.create') }}"><button type="button"
                                        class="btn btn-primary rounded-pill rounded-bill m-1">Add Package</button></a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Owner</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @include('admin.package.packagetable')
                            </tbody>
                        </table>
                        <div id="wow" class="align-right paginationstyle">
                            {{ $packages->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->


                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>

    <script>
        var icon = document.getElementById("icon");
        var toggleiconnumb = 0;
        $('.filterbtn').on('click', function() {
            toggleicon();
            tooglefilter();
        })

        function toggleicon() {
            if (toggleiconnumb == 1) {
                icon.className = "fas fa-angle-down icon";
                toggleiconnumb = 0;
            } else {
                icon.className = "fas fa-angle-up icon";
                toggleiconnumb = 1;
            }
        }

        function tooglefilter() {
            $('.filters').toggle(300);
        }
    </script>







@endsection
