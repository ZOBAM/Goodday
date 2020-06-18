@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-4 offset-sm-4 text-center">
        <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
        {{Session()->get('current_customer')->surname}}
    </div>
</div>

<h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
<form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/savings/{{ $variable_arr['saving']->id }}/collection">
    {{ csrf_field() }}
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="amount_saved">Amount Saved (N)*:</label>
                <input type="number" class="form-control @error('amount_saved') is-invalid @enderror" placeholder="Amount Saved (N)" name="amount_saved" value="{{ old('amount_saved') }}" min=50 step="50" required autofocus>
                @error('amount_saved')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="unit_amount">Unit Amount(N)*:</label>
                <input type="text" class="form-control @error('unit_amount') is-invalid @enderror" placeholder="Unit Amount(N)" name="unit_amount" value="N{{ $variable_arr['saving']->unit_amount }}" disabled>
                @error('unit_amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 alert alert-primary" role="alert">
            <p><strong>Start Date</strong>  is for recording a saving that started on a date different from Today. Ignore it for the system to use today's date.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-*-*">
            <button type="submit" class="btn btn-primary" id="submit-ad">Add Collection</button>
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
