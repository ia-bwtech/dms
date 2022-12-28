@extends('layouts.dashboard.app')

@section('content')
    <div class="main py-4">
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-body border-0 shadow table-wrapper table-responsive mt-5">
            <h2 class="mb-4 h5">FAQs</h2>
            <h2><a href="{{ route('faq.create') }}" style="float:right;" class="btn btn-primary">New FAQ</a></h2>

            {{-- <p class="text-info mb-0">Sample table page</p> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">Name</th>
                        <th class="border-gray-200">Description</th>
                        <th class="border-gray-200">Created</th>
                        <th class="border-gray-200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><span class="fw-normal">{{ $item->name }}</span></td>
                            <td><span class="fw-normal">{{ $item->description }}</span></td>
                            <td><span class="fw-normal">{{ $item->created_at }}</span></td>
                            <td><a href="{{ route('faq.edit', $item->id) }}"><i class="fas fa-edit"></i></a> <a onclick="return confirm('Are you sure?');" href="{{ route('faq.delete', $item->id) }}"> <i class="fas fa-trash-alt ml-3"></i> </a></td>
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