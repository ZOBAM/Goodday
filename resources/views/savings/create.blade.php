@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-4 offset-sm-4 text-center">
        <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
        {{Session()->get('current_customer')->surname}}
    </div>
</div>

<h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
<form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/savings/{{Session()->get('current_customer')->id}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="unit_amount">Unit Amount(N)*:</label>
                <input type="text" class="form-control @error('unit_amount') is-invalid @enderror" placeholder="Unit Amount(N)" name="unit_amount" value="{{ old('unit_amount') }}" required autofocus>
                @error('unit_amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="saving_interval">Saving Interval*:</label>
                <select class="form-control @error('saving_interval') is-invalid @enderror" placeholder="Saving Interval" id="saving_interval" name="saving_interval" value="{{ old('saving_interval') }}" required>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                @error('saving_interval')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="saving_cycle">Saving Cycle:</label>
                <input type="text" class="form-control @error('other_name') is-invalid @enderror" placeholder="Saving Cycle" id="saving_cycle" name="saving_cycle" value="{{ old('saving_cycle') }}" >
                @error('saving_cycle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Surname" id="start_date" name="start_date" value="{{ old('start_date') }}">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 alert alert-primary" role="alert">
            <p><strong>Start Date</strong>  is for recording a saving that started on a date different from Today. Ignore it for the system to use today's date.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-*-*">
            <button type="submit" class="btn btn-primary" id="submit-ad">Create Saving</button>
        </div>
    </div>
</form>
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
@endif
@section('footerLinks')
<script src="{{asset('/js/customer.js')}}" defer></script>
@endsection
