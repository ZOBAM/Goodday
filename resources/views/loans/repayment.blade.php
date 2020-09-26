@if(session()->has('info'))
    @include('layouts.notification')
@endif
@if($variable_arr['session_isset'])
    <div class="row">
        <div class="col-sm-6 offset-sm-3 text-center">
            <h2>Loans Repayment</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center">
            <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
            {{Session()->get('current_customer')->surname}}
        </div>
    </div>
            @if($variable_arr['has_loan'])
        <h5 class="card-title text-center">Below are Outstanding Loan Repayments </h5>
       <!--  <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/loans/{{Session()->get('current_customer')->id}}/repay">
            {{ csrf_field() }}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="amount_repaid">Amount(N)*:</label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount(N)" name="amount_repaid" value="{{ old('amount_repaid') }}" min="1000" max="200000" step="1000" required autofocus v-model='loanAmount' v-on:change="getLoanFee">
                        @error('amount_repaid')
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
                        <label for="application_date">Payment Date:</label>
                        <input type="date" class="form-control @error('application_date') is-invalid @enderror" id="application_date" name="application_date" value="{{ old('application_date') }}">
                        @error('application_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 alert alert-primary" role="alert">
                    <p><strong>Payment Date</strong>  is for recording a Loan Application that happened on a date different from Today. Ignore it for the system to use today's date.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-*-*">
                    <button type="submit" class="btn btn-primary" id="submit-loan" :disabled = "paidFee.length<2">Submit Payment</button>
                </div>
            </div>
        </form> -->
        <div class="table-responsive" style="width: 100%;">
            <table class = "table-sm" style="margin: auto;">
                <tr>
                    <th>S/N</th>
                    <th>Amount (N)</th>
                    <th> Due Date </th>
                    <th> Action </th>
                    <th> Status </th>
                </tr>
                @foreach($variable_arr['current_due_dates'] as $due_repay)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$due_repay->amount_repaid}}</td>
                        <td>{{date("d F, Y",strtotime($due_repay->due_date))}}</td>
                        <td>
                            @if($due_repay->repaid) -----
                            @else
                            <form method="POST" action="/loans/{{$due_repay->id}}/repay">
                                {{csrf_field()}}
                                <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that you have received a loan repayment of N{{$due_repay->amount_repaid}}? Click OK to proceed or CANCEL to return back")'>Repay</button>
                            </form>
                            @endif
                        </td>
                        <td>
                            @if($due_repay->repaid)
                            Repaid
                            @else
                            Outstanding
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{$variable_arr['current_due_dates']->links()}}
        <hr>
        <form method="POST" action="/loans/{{$variable_arr['current_customer_loan']->id}}/repay_all" style="display: inline-block;">
            {{csrf_field()}}
            <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that you have received all outstanding loan repayment? Click OK to proceed or CANCEL to return back")'>Repay All Once</button>
        </form>
        <button  v-on:click = "partPayment = !partPayment">Part Repayment</button>
        <!-- form for part repayment below -->
        <div v-if = "partPayment" style="margin-top: 1em;">
            <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/loans/{{$variable_arr['unpaid_due_dates']->id}}/part_repayment">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="amount_repaid">Amount Paid (N)*:</label>
                            <input type="number" class="form-control @error('amount_repaid') is-invalid @enderror" placeholder="Amount Repaid (N)" name="amount_repaid" value="{{ old('amount_repaid') }}" min=100 step="50" autofocus required>
                            @error('amount_saved')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="unit_amount">Expected Repay Amount(N)*:</label>
                            <input type="hidden"  name="unit_amount" value="" >
                            <input type="text" class="form-control @error('unit_amount') is-invalid @enderror" placeholder="Unit Amount(N)" name="unit_amount" value="N{{$variable_arr['unpaid_due_dates']->amount_repaid}}" disabled>
                            @error('unit_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-sm-12 alert alert-primary" role="alert">
                        <p><strong>Amount Save</strong>  is for recording a saving that is different from the Unit Amount. Ignore it for the system to use Unit Amount of N as saved amount.</p>
                    </div>
                </div> -->
                <div class="row justify-content-center">
                    <div class="col-*-*">
                        <button type="submit" class="btn btn-primary" id="submit-ad">Repay Loan</button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="alert alert-primary" role = "alert">Current Customer does not have an active loan to repay.</div>
    @endif
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
    @if(count($variable_arr['repay_loans'])>0)
<<<<<<< HEAD
    <table class="table">
        <tr>
            <th>S/N</th>
            <th>Customer Name</th>
            <th>Loan Amount (N)</th>
            <th>Repay Amount (N)</th>
            <th>Outstanding (N)</th>
        </tr>
        @foreach($variable_arr['repay_loans'] as $loan)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>
                <a href="/loans/repayment?account_number={{substr($loan->customer->account_number,2,8)}}">{{$loan->customer->full_name}}</a>
            </td>
            <td>{{$loan->amount}}</td>
            <td>{{$loan->repay_amount}}</td>
            <td>{{$loan->outstanding_amount}}</td>
        </tr>
        @endforeach
    </table>
=======
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>S/N</th>
                <th>Customer Name</th>
                <th>Loan Amount (N)</th>
                <th>Repay Amount (N)</th>
                <th>Outstanding (N)</th>
            </tr>
            @foreach($variable_arr['repay_loans'] as $loan)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    <a href="/loans/repayment?account_number={{substr($loan->customer->account_number,2,8)}}">{{$loan->customer->full_name}}</a>
                </td>
                <td>{{$loan->amount}}</td>
                <td>{{$loan->repay_amount}}</td>
                <td><span title="Repay Count: {{$loan->repay_count}}">{{$loan->outstanding_amount}}</span></td>
                <td>
                    @if($variable_arr['is_admin'] && !$loan->loan_cleared && $loan->repay_amount == $loan->outstanding_amount)
                    <form method="POST" action="/loans/{{$loan->id}}/delete" >
                        {{csrf_field()}}
                        <div class="row" style="max-width: 550px; margin: auto">
                            <button class="col-sm-12 btn btn-outline-danger" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that you want to PERMANENTLY delete this Loan Application? Click OK to proceed or CANCEL to return back")' title = "Delete This Loan" style = "white-space: nowrap;">Delete <i class="fa fa-trash float-right"></i></button>
                        </div>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
>>>>>>> 5d62599831b63e1e26b93580a0b74b730eabd778
    {{ $variable_arr['repay_loans']->links() }}
    @else
    There is currently no Loans due for repayment to display.
    @endif
@endif
@section('footerLinks')
<script src="{{asset('/js/customer.js')}}" ></script>
<script>
    var app = new Vue({
    el: '#app',
    data: {
        partPayment: false,
    },
    methods:{
    }
    })
</script>
@endsection
