@if($variable_arr['session_isset'])
<section class="text-center" style="border-bottom: 3px groove rgba(128, 128, 128, 0.644); padding-bottom: .5rem">
    <div style="text-align: left;">
        <h1 style="text-align: left; color: rgb(7, 94, 180); font-weight: bolder">
            <img src="{{asset('/images/gdaylogo-wtbg.png')}}" width = '90px' alt="goodday logo" style="margin:0px 0px -1.5rem 3rem"> <br>
            GOOD DAY
        </h1>
        <span style="display: block; margin-top:-.5rem">9th Mile, Ngwo, Enugu State, Nigeria</span>
        <span style="display: block">
            09062707500, 08165336990
        </span>
    </div>
    <h2 style="font-size: .9rem; font-weight: bold; margin: 1.5rem 0px -.5rem 0px; background-color: rgb(203, 204, 207); color: rgb(18, 38, 126); padding: .5rem">
        Customer Account Statement
    </h2>
</section>
<section style="display: flex; margin-top:2rem">
    <div style="width: 50%">
        <span style="font-weight: bold">{{Session()->get('current_customer')->full_name}} </span><br>
        {{Session()->get('current_customer')->phone_number}}<br>
        {{Session()->get('current_customer')->account_number}}
    </div>
    <div style="text-align: right; width: 50%">
        <div style="font-weight: bold">Statement Period</div>
        <div>
            {{date('d/M/Y', strtotime($variable_arr['statement']['start_date']))}} to 
            {{date('d/M/Y', strtotime($variable_arr['statement']['end_date']))}}
        </div>
    </div>
</section>
<section>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr style="width: 100%; height: 2rem; background-color: rgb(6, 6, 90); color: white">
                    <th>Date</th>
                    <th>Description</th>
                    <th>Withdrawal</th>
                    <th>Deposite</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($variable_arr['statement']['transactions'] as $item)
                    <tr>
                        <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                        @if($item->amount>0)
                        <td>Savings Collection</td>
                        <td></td>
                        <td>{{$item->amount}}</td>
                        @else
                        <td>Withdrawal</td>
                        <td>{{abs($item->amount) }}</td>
                        <td></td>
                        @endif
                        <td>{{$item->current_balance}}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td></td>
                    <td>TOTAL</td>
                    <td>{{$variable_arr['statement']['withdrawal_total']}}</td>
                    <td>{{$variable_arr['statement']['deposit_total']}}</td>
                    <td></td>
                </tr>
                <tr style="font-weight: bolder; text-transform: uppercase">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Ending Balance</td>
                    <td>{{$variable_arr['statement']['transactions_total']}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<section>
    <button v-if="!showDateForm" @click="showDateForm = true" class="btn btn-outline-primary">Choose other ranges</button>
    <button v-if="showDateForm" @click="showDateForm = false" class="btn btn-outline-danger"> X </button>
    <form action="" v-if="showDateForm" style="margin-top: 1rem">
        <div>
            <label for="from" style="width: 4rem; background-color: #4d0241; color: white; text-align: right; padding:4px">From: </label>
            <input type="date" :min="min" name="start_date" id="" :max="max" v-model="startDate"
            style="outline: none; border: none; border-bottom: 2px solid rgb(61, 61, 66)">
        </div>
        <div>
            <label for="to" style="width: 4rem; background-color: #4d0241; color: white; text-align: right; padding:4px">To: </label>
            <input type="date" :min="min" :max="max" name="end_date" id="" v-model="endDate"
            style="outline: none; border: none; border-bottom: 2px solid rgb(61, 61, 66)">
        </div>
        <button class="btn btn-primary"  :disabled="inputInvalid">Get Account Statement</button>
    </form>
</section>
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    @include('layouts.set_customer_session')
@endif
{{-- {{$variable_arr['statement']['transactions_total']}} --}}
@section('general-script')
<script>
var app = new Vue({
  el: '#app',
  data: {
    showDateForm : false,
    min: '2020-04-01',
    startDate: null,
    endDate: null,
  },
  methods:{
  },
  computed:{
      max(){
            //let today = new Date().getUTCFullYear;
            return new Date().toISOString().split("T")[0]
      },
      inputInvalid(){
          return this.endDate == null || this.startDate == null? true : false;
      }
    
  },
  mounted() {
      ///alert(12)
  }
})
</script>
@endsection