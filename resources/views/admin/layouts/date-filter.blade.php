@if (isset($smallview))
    <div class="filters" @if (!isset($show)) style="display: none;" @endif>
        <div class="col-md-6">


            <div class="float-left mx-3 my-3">
                <label>Date Start:</label>
                <input type="date" name="date_start" id="date_start" class="form-control"
                    onchange="filter('{{ $route }}')">
            </div>
            <div class="float-left mx-3 my-3">
                <label>Date End:</label>
                <input type="date" name="date_end" id="date_end" class="form-control"
                    onchange="filter('{{ $route }}')">
            </div>
            @if ($role == 1)
                <div class="float-left mx-3 my-3">
                    <label>Role:</label>
                    <select class="form-control filter-control filter-select" id="role_id" name="role_id"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('role_id') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Handicapper</option>
                        <option value="0">Bettor</option>

                    </select>
                </div>
                <div class="float-left mx-3 my-3">
                    <label>Stripe Connected:</label>
                    <select class="form-control filter-control filter-select" id="role_id" name="stripe_connected"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('stripe_connected') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>

                    </select>
                </div>
                <div class="float-left mx-3 my-3">
                    <label>No Bets:</label>
                    <select class="form-control filter-control filter-select" id="nobets" name="nobets"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('nobets') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>

                    </select>
                </div>
            @endif


        </div>



        {{-- <div class="col-md-0 mx-3 my-3">
            <button class="btn btn-primary">Submit</button>
            <a href="{{ route('packages.index') }}"><button type="button"
                    class="btn btn-danger">Cancel</button></a>

        </div> --}}
    </div>
@else
    <div class="filters row" @if (!isset($show)) style="display: none;" @endif>
        <div class="col-md-12">


            <div class="float-left mx-3 my-3">
                <label>Date Start:</label>
                <input type="date" name="date_start" id="date_start" class="form-control"
                    onchange="filter('{{ $route }}')">
            </div>
            <div class="float-left mx-3 my-3">
                <label>Date End:</label>
                <input type="date" name="date_end" id="date_end" class="form-control"
                    onchange="filter('{{ $route }}')">
            </div>
            @if ($role == 1)
                <div class="float-left mx-3 my-3">
                    <label>Role:</label>
                    <select class="form-control filter-control filter-select" id="role_id" name="role_id"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('role_id') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Handicapper</option>
                        <option value="0">Bettor</option>

                    </select>
                </div>
                <div class="float-left mx-3 my-3">
                    <label>Stripe Connected:</label>
                    <select class="form-control filter-control filter-select" id="stripe_connected"
                        name="stripe_connected" onchange="filter('{{ $route }}')">
                        <option @if (request()->get('stripe_connected') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>

                    </select>
                </div>
                <div class="float-left mx-3 my-3">
                    <label>No Bets:</label>
                    <select class="form-control filter-control filter-select" id="nobets" name="nobets"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('nobets') == null) selected @endif value="">Select
                        </option>
                        <option value="30">30 days</option>
                        <option value="60">60 days</option>
                        <option value="120">120 days</option>


                    </select>
                </div>

                <div class="float-left mx-3 my-3">
                    <label>Referral Code:</label>
                    <select class="form-control filter-control filter-select" id="referral_code" name="referral_code"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('referral_code') == null) selected @endif value="">Select
                        </option>
                        @foreach ($referral_codes as $referral_code)
                            <option value="{{ $referral_code->name }}">{{ $referral_code->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if (isset($verified))
                <div class="float-left mx-3 my-3">
                    <label>Verified:</label>
                    <select class="form-control filter-control filter-select" id="is_verified" name="is_verified"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('is_verified') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Verified</option>
                        <option value="0">Unverified</option>

                    </select>
                </div>
            @endif

            @if (isset($is_won))
                <div class="float-left mx-3 my-3">
                    <label>Won:</label>
                    <select class="form-control filter-control filter-select" id="is_won" name="is_won"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('is_won') == null) selected @endif value="">Select
                        </option>
                        <option value="1">Won</option>
                        <option value="0">Lost</option>
                        <option value="2">Refunded</option>


                    </select>
                </div>
            @endif

            @if (isset($status))
                <div class="float-left mx-3 my-3">
                    <label>Graded:</label>
                    <select class="form-control filter-control filter-select" id="status" name="status"
                        onchange="filter('{{ $route }}')">
                        <option @if (request()->get('status') == null) selected @endif value="">Select
                        </option>
                        <option value="1">No</option>
                        <option value="0">Yes</option>


                    </select>
                </div>
            @endif


        </div>



        {{-- <div class="col-md-0 mx-3 my-3">
            <button class="btn btn-primary">Submit</button>
            <a href="{{ route('packages.index') }}"><button type="button"
                    class="btn btn-danger">Cancel</button></a>

        </div> --}}
    </div>
@endif
