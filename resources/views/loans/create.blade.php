@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-4 offset-sm-4 text-center">
        <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
        {{Session()->get('current_customer')->surname}}
    </div>
</div>

<h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
<form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/loans/{{Session()->get('current_customer')->id}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="amount">Loan Amount(N)*:</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount(N)" name="amount" value="{{ old('amount') }}" min="1000" max="200000" step="1000" required autofocus>
                @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="loan_type">Loan Type*:</label>
                <select class="form-control @error('loan_type') is-invalid @enderror" id="loan_type" name="loan_type" value="{{ old('loan_type') }}" required>
                    <option value="personal">Personal Loan</option>
                    <option value="group">Group Loan</option>
                </select>
                @error('loan_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="duration">Duration of Loan:</label>
                <select class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" required>
                    <option value="1week">One Week</option>
                    <option value="2weeks">Two Weeks</option>
                    <option value="3weeks">Three Weeks</option>
                    <option value="1month">One Month</option>
                    <option value="2months">Two Months</option>
                    <option value="3months">Three Months</option>
                </select>
                @error('duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="application_date">Application Date:</label>
                <input type="date" class="form-control @error('application_date') is-invalid @enderror" id="application_date" name="application_date" value="{{ old('application_date') }}">
                @error('application_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 alert alert-primary" role="alert">
            <p><strong>Application Date</strong>  is for recording a Loan Application that happened on a date different from Today. Ignore it for the system to use today's date.</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="repay_interval">Repay Interval:</label>
                <select class="form-control @error('repay_interval') is-invalid @enderror" id="repay_interval" name="repay_interval" value="{{ old('repay_interval') }}" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
                @error('repay_interval')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="first_repay_date">First Repay Date:</label>
                <input type="date" class="form-control @error('first_repay_date') is-invalid @enderror" id="first_repay_date" name="first_repay_date" value="{{ old('first_repay_date') }}" required>
                @error('first_repay_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-check">
                <label class="form-check-label">
                <input type="checkbox" name="paid_insurance" class="form-check-input" value=1>Has paid 2% (<span class="loan-fee">N0</span>) for Insurance.
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                <input type="checkbox" name="paid_admin" class="form-check-input" value=1>Has paid 2% (<span class="loan-fee">N0</span>) for Admin.
                </label>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-*-*">
            <button type="submit" class="btn btn-primary" id="submit-loan" disabled = true>Submit Loan Application</button>
        </div>
    </div>
</form>
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
@endif
@section('footerLinks')
<script src="{{asset('/js/customer.js')}}" async></script>
<script async>
$("input[required],select[required],textarea[required]").removeAttr('required');
//calculate the fees when loan amount is changed
$('input[name = "amount"]').change(function(){
    let amount = $(this).val();
    let adminFee = amount * (2/100);
    $('.loan-fee').text('N'+adminFee);
    //alert("Loan amount changed");
})
//disable submit button if fees are not paid
$('.form-check-input').change(function(){
    if($('input[name = "paid_admin"]').prop("checked") == false || $('input[name = "paid_insurance"]').prop("checked") == false){
        //alert("Checkbox is not checked." );
        $('#submit-loan').attr('disabled',true);
    }
    else{
        $('#submit-loan').attr('disabled',false);
    }
})

</script>
@endsection
