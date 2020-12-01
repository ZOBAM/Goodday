
@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Creating a New Loan Application</h2>
    </div>
</div>
    @if(session()->has('info'))
        @include('layouts.notification')
    @elseif(Session()->get('current_customer')->has_loan)
        <div class="alert alert-primary" role="alert">
            <p>One customer cannot have two running loans at the same time.</p>
            <p>Clear outstanding repayment of current loan before  applying for another one</p>
        </div>
    @elseif(Session()->get('current_customer')->balance_amount < 3000)
        <div class="alert alert-primary" role="alert">
            <p><strong>Insufficient Balance (₦{{Session()->get('current_customer')->balance_amount}}): </strong>This customer does not have the minimum saving of ₦3,000 required for loan application.</p>
        </div>
    @else
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
                    <label for="amount">Loan Amount(₦)*:</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount(₦)" name="amount" value="{{ old('amount') }}" min="1000" max="{{Session()->get('current_customer')->max_loan_amount}}" step="1000" required autofocus v-model='loanAmount' v-on:change="getLoanFee">
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
                    <label for="duration">Duration of Loan*:</label>
                    <select class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" required v-model = "duration">
                        <option value="30">One Month</option>
                        <option value="60">Two Months</option>
                        <option value="90">Three Months</option>
                        <option value="120">Four Months</option>
                        <option value="150">Five Months</option>
                        <option value="180">Six Months</option>
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
            <div class="col-sm-12 alert alert-info" role="alert">
                <p><strong>Application Date</strong>  is for recording a Loan Application that happened on a date different from Today. Ignore it for the system to use today's date.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="repay_interval">Repay Interval*:</label>
                    <select class="form-control @error('repay_interval') is-invalid @enderror" id="repay_interval" name="repay_interval" value="{{ old('repay_interval') }}" required>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" v-if = "duration>21">Monthly</option>
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
                    <label for="first_repay_date">First Repay Date*:</label>
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
                    <input type="checkbox" name="paid_insurance" class="form-check-input" v-model="paidFee"  value=1>Has paid 2% (₦@{{loanFee}}) for Insurance.
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="checkbox" name="paid_admin" class="form-check-input" v-model="paidFee"  :value="loanFee">Has paid 2% (₦@{{loanFee}}) for Admin.
                    </label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-*-*">
                <button type="submit" class="btn btn-primary" id="submit-loan" :disabled = "paidFee.length<2">Submit Loan Application</button>
            </div>
        </div>
    </form>
    @endif
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
@endif
@section('footerLinks')
@endsection
@section('general-script')
<script>
var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!',
    loanAmount: 1000,
    loanFee : 20,
    showSubmit : true,
    paidFee : [],
    duration : 30
  },
  methods:{
      getLoanFee : function(){
          this.loanFee = this.loanAmount * 2/100;
      }
  }
})
$("input[required],select[required],textarea[required]").removeAttr('required');
//calculate the fees when loan amount is changed
/* $('input[name = "amount"]').change(function(){
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
 */
</script>
@endsection
