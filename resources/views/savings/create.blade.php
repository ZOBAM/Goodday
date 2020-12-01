@if($variable_arr['session_isset'])
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center">
            <img src="{{asset('/images/customers/'.Session()->get('current_customer')->passport_link)}}" alt="" style="max-width: 50px;"><br>
            {{Session()->get('current_customer')->full_name}}
        </div>
    </div>
    @if(session()->has('info'))
        @include('layouts.notification')
    @elseif($variable_arr['saving'])
    <div class="col-sm-12 alert alert-primary" role="alert">
        <p><strong>Saving Exist:</strong>  There is an ongoing Saving for this Customer. If you want to start a new Saving then close the Current Saving Cycle.</p>
    </div>
    @else
    <div class="row" style="margin: 1em 0em;">
        <div class = "col"><button v-bind:class="{ buttonClicked: !justSaving }" class = "col btn btn-outline-primary" @click = "justSaving = false"> Saving Cycle </button></div>
        <div class = "col"><button v-bind:class="{ buttonClicked: justSaving }" class = "col btn btn-outline-primary .button-clicked" @click = "justSaving = true"> Just Saving </button></div>

    </div>
    <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/savings/{{Session()->get('current_customer')->id}}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="unit_amount">Unit Amount(₦)*:</label>
                    <input type="number" class="form-control @error('unit_amount') is-invalid @enderror" placeholder="Unit Amount(₦)" :name="amountName" value="{{ old('unit_amount') }}" step="50" min="50" max="200000" required autofocus>
                    @error('unit_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col" v-if = "justSaving == false">
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
        <div v-if = "justSaving == false">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="saving_cycle">Saving Cycle:</label>
                        <input type="text" class="form-control @error('other_name') is-invalid @enderror" placeholder="Saving Cycle" id="saving_cycle" name="saving_cycle" value="{{$variable_arr['saving_cycle']}}" disabled = 'true'>
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
        </div>
        <div class="row justify-content-center">
            <div class="col-*-*">
                <button type="submit" class="btn btn-primary" id="submit-ad">Create Saving</button>
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
<script src="{{asset('/js/customer.js')}}" defer></script>
<script>
var app = new Vue({
  el: '#app',
  data: {
    justSaving : false,
    amountName : 'unit_amount'
  },
  methods:{
      setInputName : function(){
          if(justSaving){
              this.amountName = 'amount_saved'
          }
      }
  },
  watch : {
      justSaving : function(){
        if(this.justSaving){
              this.amountName = 'amount_saved'
          }
        else{
            this.amountName = 'unit_amount'
        }
      }
  }
})
</script>
@endsection
