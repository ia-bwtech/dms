@if(isset($smallview))
<div class="filters" @if(!isset($show)) style="display: none;" @endif>
    <div class="col-md-6">


        <div class="float-left mx-3 my-3">
            <label>Date Start:</label>
            <input type="date" name="date_start" id="date_start" class="form-control" onchange="filter('{{$route}}')">
        </div>
        <div class="float-left mx-3 my-3">
            <label>Date End:</label>
            <input type="date" name="date_end" id="date_end" class="form-control"  onchange="filter('{{$route}}')">
        </div>
        @if ($role == 1)
            <div class="float-left mx-3 my-3">
                <label>Role:</label>
                <select style="width: 120%" class="form-control filter-control filter-select" id="role_id"
                    name="role_id" onchange="filter('{{$route}}')">
                    <option @if (request()->get('role_id') == null) selected @endif value="">Select
                    </option>
                    <option value="1">Handicapper</option>
                    <option value="0">Bettor</option>

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
<div class="filters row" @if(!isset($show)) style="display: none;" @endif>
    <div class="col-md-12">


        <div class="float-left mx-3 my-3">
            <label>Date Start:</label>
            <input type="date" name="date_start" id="date_start" class="form-control" onchange="filter('{{$route}}')">
        </div>
        <div class="float-left mx-3 my-3">
            <label>Date End:</label>
            <input type="date" name="date_end" id="date_end" class="form-control"  onchange="filter('{{$route}}')">
        </div>
        @if ($role == 1)
            <div class="float-left mx-3 my-3">
                <label>Role:</label>
                <select style="width: 120%" class="form-control filter-control filter-select" id="role_id"
                    name="role_id" onchange="filter('{{$route}}')">
                    <option @if (request()->get('role_id') == null) selected @endif value="">Select
                    </option>
                    <option value="1">Handicapper</option>
                    <option value="0">Bettor</option>

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
