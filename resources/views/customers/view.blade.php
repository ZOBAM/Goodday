@isset($variable_arr['customers'])
<h3 class="card-title text-center">List of Customers</h3>
    <table class="table table-responsive table-striped table-hover">
        <tr>
            <th>S/N</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>Account No.</th>
            <th>Phone No.</th>
            <th>Email</th>
        </tr>
    @foreach($variable_arr['customers'] as $customer)
    <tr id="{{$customer->id}}" class="t-row">
        <td>{{$loop->iteration}}</td>
        <td>{{$customer->first_name}}</td><td>{{$customer->surname}}</td><td>{{$customer->account_number}}</td><td>{{$customer->phone_number}}</td><td>{{$customer->email}}</td>
    </tr>
    @endforeach
    </table>
@endisset
@isset($variable_arr['customer'])
<h5 class="card-title text-center">
    {{$variable_arr['customer']->surname.' '.$variable_arr['customer']->first_name}} Details<br>
    {{$variable_arr['customer']->account_number}}
</h5>
    @if($variable_arr['new_customer'])
        This is a new customer
    @endif
    listing the customer
@endisset

@section('footerLinks')
<script>
    $('.t-row').click(function(){
        //alert('Clicked a t-row');
        let customerID = $(this).attr('id');
        location = '/customers/view/'+customerID;
    })
</script>
@endsection
