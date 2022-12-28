@extends('layouts.dashboard.app')

@section('content')
    <div class="main py-4">
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="card card-body border-0 shadow table-wrapper table-responsive mt-5">
            <h2 class="mb-4 h5">Subscribers</h2>

            {{-- <p class="text-info mb-0">Sample table page</p> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Name') }}</th>
                        <th class="border-gray-200">{{ __('Email') }}</th>
                        <th class="border-gray-200">Package</th>
                        <th class="border-gray-200">Package Price</th>
                        <th class="border-gray-200">Package Description</th>
                        <th class="border-gray-200">Package Duration</th>
                        <th class="border-gray-200">Subscription status</th>
                        {{-- <th class="border-gray-200">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><span class="fw-normal">{{ $item->user->name }}</span></td>
                            <td><span class="fw-normal">{{ $item->user->email }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->name }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->price }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->description }}</span></td>
                            <td><span class="fw-normal">{{ $item->package->duration }}</span></td>
                            <td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-success @elseif($item->status == 0) btn-warning @endif" disabled>{{ $item->status == 1 ? 'Active' : 'Expired' }}</button></span></td>
                            {{-- <td><span class="fw-normal">{{ $item->roi }}</span></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>
@endsection