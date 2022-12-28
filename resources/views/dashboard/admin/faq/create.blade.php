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
                <form action="{{ route('faq.store') }}" method="POST">
                    @csrf
                    <h1>New FAQ</h1>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label for="email">FAQ Name</label>
                                <input value="{{ old('name') }}" name="name" required type="text" class="form-control" id="name" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4">
                                <label for="email">FAQ Description</label>
                                <textarea value="{{ old('description') }}" required name="description" class="form-control" id="" cols="30" rows="5"></textarea>
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
</div>

@endsection