@if(session()->has('info'))
    @include('layouts.notification')
@endif
@isset($variable_arr['customers'])
<h3 class="card-title text-center">List of Customers</h3>
    <div class = "table-responsive ">
    <table class="table table-striped table-hover">
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
    {{ $variable_arr['customers']->links() }}
    </div>
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
                @if($variable_arr['customer']->email)
                <tr>
                    <td>Email Address: </td><td>{{$variable_arr['customer']->email}}</td>
                </tr>
                @endif
                @if($variable_arr['customer']->state)
                <tr>
                    <td>State: </td><td>{{$variable_arr['customer']->state}}</td>
                </tr>
                <tr>
                    <td>LGA: </td><td>{{$variable_arr['customer']->lga}}</td>
                </tr>
                <tr>
                    <td>Community: </td><td>{{$variable_arr['customer']->community}}</td>
                </tr>
                @endif
                @if($variable_arr['customer']->full_address)
                <tr>
                    <td>Full Address: </td><td>{{$variable_arr['customer']->full_address}}</td>
                </tr>
                @endif
                @if($variable_arr['customer']->next_of_kin)
                <tr>
                    <td>Next of Kin: </td><td>{{$variable_arr['customer']->next_of_kin}}</td>
                </tr>
                @endif
                @if($variable_arr['customer']->next_of_kin)
                <tr>
                    <td>Poverty Index: </td><td>{{$variable_arr['customer']->poverty_index}}</td>
                </tr>
                @endif
                <tr>
                    <td>Date Created: </td><td>{{$variable_arr['customer']->created_at}}</td>
                </tr>
                @if($variable_arr['customer']->guarantor)
                <tr style="background-color: cornflowerblue; color: white;">
                    <td colspan="2" class="text-center" style="color: inherit">Guarantor's Details</td>
                </tr>
                <tr>
                    <td>Full Name: </td><td>{{$variable_arr['customer']->guarantor->gfull_name}}</td>
                </tr>
                <tr>
                    <td>Phone No.: </td><td>{{$variable_arr['customer']->guarantor->gphone_number}}</td>
                </tr>
                <tr>
                    <td>Res. Address: </td><td>{{$variable_arr['customer']->guarantor->gresident_address}}</td>
                </tr>
                <tr>
                    <td>Work Address: </td><td>{{$variable_arr['customer']->guarantor->gwork_address}}</td>
                </tr>
                <tr>
                    <td>Relationship: </td><td>{{$variable_arr['customer']->guarantor->grelationship}}</td>
                </tr>
                <tr>
                    <td>Occupation: </td><td>{{$variable_arr['customer']->guarantor->goccupation}}</td>
                </tr>
                @endif
            </table>
        </div>
        <div class="add-to-group-wrapper">
            @if($variable_arr['customer']->group)
            Add {{$variable_arr['customer']->full_name}} to a group.
            <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/groups/{{$variable_arr['customer']->id}}/add">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control @error('group') is-invalid @enderror" id="group" name="group" required>
                                <option value="">--select group--</option>
                                @foreach($variable_arr['customer']->group as $group)
                                <option value="{{$group->id}}">{{$group->name}} ({{$group->population}} members)</option>
                                @endforeach
                            </select>
                            @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="row justify-content-center">
                            <div class="col-*-*">
                                <button type="submit" class="btn btn-primary" id="submit-ad">Add To Group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
        @if($variable_arr['is_admin'])
        <form method="POST" action="/customers/{{$variable_arr['customer']->id}}/delete" >
            {{csrf_field()}}
            <div class="row" style="max-width: 550px; margin: auto">
                <button class="col-sm-12 btn btn-outline-danger" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that you want to PERMANENTLY delete this customer account? Click OK to proceed or CANCEL to return back")'>Delete Customer's Account <i class="fa fa-trash float-right"></i></button>
            </div>
        </form>
        @endif
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
