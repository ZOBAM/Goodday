<div class="card">
  <div class="card-header">
    View Customer's Info
  </div>
  <div class="card-body">
    <h5 class="card-title text-center">Zobam Acount Details</h5>
    @isset($variable_arr['customers'])
        <h2>listing customers</h2>
        <table class="table">
        @foreach($variable_arr['customers'] as $customer)
        <tr>
            <td>{{$customer->first_name}}</td><td>{{$customer->surname}}</td><td>{{$customer->account_number}}</td><td>{{$customer->phone_number}}</td><td>{{$customer->email}}</td>
        </tr>
        @endforeach
        </table>
    @endisset
    @isset($variable_arr['customer'])
        @if($variable_arr['new_customer'])
            This is a new customer
        @endif
        listing the customer
    @endisset
  </div>
</div>
@section('footerLinks')
<script></script>
@endsection
