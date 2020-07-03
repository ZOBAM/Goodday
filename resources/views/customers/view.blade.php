@isset($variable_arr['customers'])
<h3 class="card-title text-center">List of Customers</h3>
    <table class="table table-responsive table-striped table-hover">
        <tr>
            <th>S/N</th>
            <th>Full Name</th>
            <th>Account No.</th>
            <th>Phone No.</th>
            <th>Email</th>
            <th>Balance</th>
            <th>Date Created</th>
        </tr>
    @foreach($variable_arr['customers'] as $customer)
    <tr id="{{$customer->id}}" class="t-row">
        <td>{{$loop->iteration}}</td>
        <td>{{$customer->full_name}}</td>
        <td>{{$customer->account_number}}</td>
        <td>{{$customer->phone_number}}</td>
        <td>{{$customer->email}}</td>
        <td>{{$customer->balance}}</td>
        <td>{{$customer->created_at}}</td>
    </tr>
    @endforeach
    </table>
@endisset
@isset($variable_arr['customer'])
    <div id="customer-details">
        <div style="max-width: 100px; margin: auto;text-align: center;">
            <img src="{{asset('/images/customers/'.$variable_arr['customer']->passport)}}" width="80px" alt="" >
        </div>
        <h5 class="card-title text-center">
            Balance: ₦{{$variable_arr['customer']->balance}}
        </h5>
        <?php
        /*@if($variable_arr['new_customer'])
            This is a new customer
        @endif*/
        ?>
        <div class="table-responsive">
            <table class="table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Customer's Details</th>
                    </tr>
                </thead>
                <tr>
                    <td>Name:</td><td>{{$variable_arr['customer']->full_name}}</td>
                </tr>
                <tr>
                    <td>Account Number: </td><td>{{$variable_arr['customer']->account_number}}</td>
                </tr>
                <tr>
                    <td>Gender: </td><td>{{$variable_arr['customer']->gender}}</td>
                </tr>
                <tr>
                    <td>Phone No.: </td><td>{{$variable_arr['customer']->phone_number}}</td>
                </tr>
                <tr>
                    <td>Email Address: </td><td>{{$variable_arr['customer']->email}}</td>
                </tr>
                <tr>
                    <td>State: </td><td>{{$variable_arr['customer']->state}}</td>
                </tr>
                <tr>
                    <td>LGA: </td><td>{{$variable_arr['customer']->lga}}</td>
                </tr>
                </tr>
                <tr>
                    <td>Community: </td><td>{{$variable_arr['customer']->community}}</td>
                </tr>
                </tr>
                <tr>
                    <td>Full Address: </td><td>{{$variable_arr['customer']->full_address}}</td>
                </tr>
                </tr>
                <tr>
                    <td>Next of Kin: </td><td>{{$variable_arr['customer']->next_of_kin}}</td>
                </tr>
                <tr>
                    <td>Poverty Index: </td><td>{{$variable_arr['customer']->poverty_index}}</td>
                </tr>
                <tr>
                    <td>Date Created: </td><td>{{$variable_arr['customer']->created_at}}</td>
                </tr>
            </table>
        </div>
    </div>
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
