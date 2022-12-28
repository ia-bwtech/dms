@extends('layouts.dashboard.app')

@section('content')
    <div class="main py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">Featured (Only payment verified handicappers)</h2>

            {{-- <p class="text-info mb-0">Sample table page</p> --}}

            <form method="POST" action="{{ route('featured.update') }}">
                @csrf
                <select name="featured" id="" class="form-control w-25">
                    @foreach ($paymentVerifiedCappers as $item)
                        <option {{ $item->is_featured == 1 ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>

        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive mt-5">
            <h2 class="mb-4 h5">Handicappers</h2>

            {{-- <p class="text-info mb-0">Sample table page</p> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Name') }}</th>
                        <th class="border-gray-200">{{ __('Email') }}</th>
                        <th class="border-gray-200">Payment Cut Percentage</th>
                        <th class="border-gray-200">Wins</th>
                        <th class="border-gray-200">Losses</th>
                        <th class="border-gray-200">Win/Loss Percentage</th>
                        <th class="border-gray-200">Units</th>
                        <th class="border-gray-200">ROI</th>
                        {{-- <th class="border-gray-200">Verified</th> --}}
                        <th class="border-gray-200">Date of Joining</th>
                        <th class="border-gray-200">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><span class="fw-normal"><a class="btn btn-primary" href="{{ route('handicappers.profile', $item->id) }}">{{ $item->name }}</a></span></td>
                            <td><span class="fw-normal">{{ $item->email }}</span></td>
                            <td><span class="fw-normal">{{ $item->payment_cut_percentage }}%</span></td>
                            <td><span class="fw-normal">{{ $item->wins }}</span></td>
                            <td><span class="fw-normal">{{ $item->losses }}</span></td>
                            <td><span class="fw-normal">{{ $item->win_loss_percentage }}%</span></td>
                            <td><span class="fw-normal">{{ $item->units }}</span></td>
                            <td><span class="fw-normal">{{ $item->roi }}</span></td>
                            <td><span class="fw-normal">{{ $item->created_at->format('d-M-Y') }}</span></td>

                            {{-- <td><span class="fw-normal">{{ $item->is_verified == 1 ? 'Yes' : 'No' }}</span></td> --}}
                            <td><a class="btn btn-primary ml-2" href="{{ route('admin.user.edit', $item->id) }}"><i class="fas fa-edit"></i></a></td>
                            {{-- @if($item->is_verified == 1)
                            <td><span class="fw-normal"><button class="btn btn-primary" disabled>Already Verified</button></span><a class="btn btn-primary ml-2" href="{{ route('admin.user.edit', $item->id) }}"><i class="fas fa-edit"></i></a></td>
                            @else
                            <td><span class="fw-normal"><a class="btn btn-primary" disabled href="{{ route('admin.user.verify', $item->id) }}">Verify</a></span></td>
                            @endif --}}
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
