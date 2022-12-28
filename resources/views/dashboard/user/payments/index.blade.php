@extends('layouts.dashboard.app')
{{-- @dd($__data) --}}
@section('content')
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">Payments</h2>
                    <form>
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                @if (@isset($account))
                                    @if($account->details_submitted == 1)
                                        <p>Your Stripe is already connected.</p>
                                        <p>Account Type: {{ $account->type }}</p>
                                        <p>Account ID: {{ $account->id }}</p>
                                    @else
                                        <p>Click below to connect your Stripe accounts to start receiving payments</p>
                                        <a href="/stripe/connect" class="btn btn-gray-800 mt-2 animate-up-2">{{ __('Get Started') }}</a>
                                    @endif
                                @endif
                                @if(auth()->user()->stripe_id == null)
                                    <p>Click below to connect your Stripe accounts to start receiving payments</p>
                                    <a href="/stripe/connect" class="btn btn-gray-800 mt-2 animate-up-2">{{ __('Get Started') }}</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($message = Session::get('success'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                text: '{{ $message }}',
            })
        </script>
    @endif
@endsection

<style>
.btn-new-pakg {
    float: right !important;
}

.btn-new-pakg button.btn.btn-primary.w-25 {
    float: right;
    width: 15%;
}


.card.card-body.border-0.shadow.table-wrapper.table-responsive.mt-5 p {
    text-align: right;
}
 </style>   