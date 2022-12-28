@extends('layouts.dashboard.app')

@section('content')
    <div class="main py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">My Subscriptions</h2>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">Package Name</th>
                        <th class="border-gray-200">Capper</th>
                        <th class="border-gray-200">Description</th>
                        <th class="border-gray-200">Price</th>
                        <th class="border-gray-200">Duration</th>
                        <th class="border-gray-200">From</th>
                        <th class="border-gray-200">To</th>
                        <th class="border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $item)
                        <tr>
                            <td><span class="fw-normal">{{ $item->package->name ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->user->name ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->description ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->price ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->duration ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->from_date ?? '-' }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->to_date ?? '-' }}</span></td>
                            <td><span
                                    class="fw-normal @if ($item->status == 1) btn btn-success disabled @elseif($item->status == 0) btn btn-danger disabled @endif">{{ $item->status == 1 ? 'Active' : 'Expired' }}</span>
                            </td>
                        </tr>
                    @endforeach
                    {{-- <tr>
                        <td>Handicapper 1</td>
                        <td>handicapper@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Handicapper 2</td>
                        <td>handicapper@outlook.com</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
        @if (auth()->user()->is_handicapper == 1)
            <div class="card card-body border-0 shadow table-wrapper table-responsive mt-5">
                <h2 class="mb-4 h5">Packages</h2>
                @if (auth()->user()->stripe_connected == 1 || auth()->user()->paypal_connected == 1)
                    <h2><a href="{{ route('package.create') }}" style="float:right;" class="btn btn-primary">New Package</a>
                    </h2>
                @else
                    <div class="btn-new-pakg">
                        <button disabled class="btn btn-primary">New Package</button>
                    </div>
                    <p>No payment method setup. Please <a href="{{ route('user.payments') }}">click here</a> to setup
                        payments</p>
                @endif

                {{-- <p class="text-info mb-0">Sample table page</p> --}}

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="border-gray-200">Name</th>
                            <th class="border-gray-200">Price</th>
                            <th class="border-gray-200">Description</th>
                            <th class="border-gray-200">Duration</th>
                            <th class="border-gray-200">From</th>
                            <th class="border-gray-200">To</th>
                            <th class="border-gray-200">Created</th>
                            <th class="border-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td><span class="fw-normal">{{ $item->name }}</span></td>
                                <td><span class="fw-normal">{{ $item->price }}</span></td>
                                <td><span class="fw-normal">{{ $item->description }}</span></td>
                                <td><span class="fw-normal">{{ $item->duration }}</span></td>
                                <td><span class="fw-normal">{{ $item->from_date }}</span></td>
                                <td><span class="fw-normal">{{ $item->to_date }}</span></td>
                                <td><span class="fw-normal">{{ $item->created_at }}</span></td>
                                <td><a href="{{ route('package.edit', $item->id) }}"><i class="fas fa-edit"></i></a> <a
                                        onclick="return confirm('Are you sure?');"
                                        href="{{ route('package.delete', $item->id) }}"> <i
                                            class="fas fa-trash-alt ml-3"></i> </a></td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                        <td>Handicapper 1</td>
                        <td>handicapper@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Handicapper 2</td>
                        <td>handicapper@outlook.com</td>
                    </tr> --}}
                    </tbody>
                </table>
                <div
                    class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    {{-- {{ $users->links() }} --}}
                </div>
            </div>
        @endif
    </div>
@endsection
