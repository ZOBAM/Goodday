@if($variable_arr['session_isset'])
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center">
            <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
            {{Session()->get('current_customer')->full_name}}
        </div>
    </div>
    @if(session()->has('info'))
        @include('layouts.notification')
    @elseif($variable_arr['withdrawable_amount'] <= 0)
    <div class="col-sm-12 alert alert-primary" role="alert">
        <p><strong>Low Balance:</strong> There is no  Withdrawable Amount in this customer's account.</p>
    </div>
    @else
    <h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
    <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/savings/{{Session()->get('current_customer')->id}}/disburse">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="amount_withdrawn">Withdraw Amount (₦)*:</label>
                    <input type="number" class="form-control @error('amount_withdrawn') is-invalid @enderror" placeholder="Withdraw Amount (₦)" name="amount_withdrawn" value="{{ old('amount_withdrawn') }}" min=50 step="50" autofocus>
                    @error('amount_withdrawn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="unit_amount">Total Withdrawable Balance(₦)*:</label>
                    <input type="hidden"name="withdrawable_amount" value="{{ $variable_arr['withdrawable_amount'] }}">
                    <input type="text" class="form-control @error('unit_amount') is-invalid @enderror" placeholder="Unit Amount(₦)" value="₦{{$variable_arr['withdrawable_amount']}}" disabled>
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
                <p><strong>Withdraw Amount</strong>  is for withdrawal less than the Total Withdrawable Amount. Ignore it for the system to withdraw the whole of Total Withdrawable Amount.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-*-*">
                <button type="submit" class="btn btn-primary" id="submit-ad">Withdraw</button>
            </div>
        </div>
    </form>
    @endif
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
@endif
@section('footerLinks')
<script src="{{asset('/js/customer.js')}}" defer></script>
@endsection
