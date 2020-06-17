<h5 class="card-title text-center">Zobam Acount Details</h5>
<!-- If a customer object was returned from server, display the edith form -->
@if($variable_arr['customer'])
@php
    $customer = $variable_arr['customer']
@endphp
    <h2>Updating {{$customer->surname.' '.$customer->first_name}} ({{$customer->account_number}})</h2>
    <table class="table">
    <tr>
        <td>{{$customer->first_name}}</td><td>{{$customer->surname}}</td><td>{{$customer->account_number}}</td><td>{{$customer->phone_number}}</td><td>{{$customer->email}}</td>
    </tr>
    </table>

    <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = '/customers/{{$customer->id}}'>
        {{ csrf_field() }}
        <div class="row">
            <div class = "col-sm-4 offset-sm-4">
                <div style="width: 100px; height: 100px; background-color: cornflowerblue; margin: auto;">
                    <img src="{{asset('/images/male_avatar.png')}}" alt="" id="place_holder" style="max-width: 100px;max-height: 100px;">
                </div>
                <input type="file" class="form-control-file" id="customer_passport" name="customer_passport" hidden>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="title">First Name*:</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{ $errors->any()? old('first_name') : $customer->first_name }}" required autofocus>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="surname">Surname*:</label>
                    <input type="text" class="form-control @error('surname') is-invalid @enderror" placeholder="Surname" id="surname" name="surname" value="{{ $errors->any()? old('surname') : $customer->surname }}" required>
                    @error('surname')
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
                    <label for="other_name">Other Name:</label>
                    <input type="text" class="form-control @error('other_name') is-invalid @enderror" placeholder="Other Name" id="other_name" name="other_name" value="{{ $errors->any()? old('other_name') : $customer->other_name }}" required>
                    @error('other_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="phone_number">Phone No.*:</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Surname" id="phone_number" name="phone_number" value="{{ $errors->any()? old('phone_number') : $customer->phone_number }}" required>
                    @error('phone_number')
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
                    <label for="next_of_kin">Next of Kin*:</label>
                    <input type="text" class="form-control @error('next_of_kin') is-invalid @enderror" placeholder="Next of Kin" id="next_of_kin" name="next_of_kin" value="{{ $errors->any()? old('next_of_kin') : $customer->next_of_kin }}" required>
                    @error('next_of_kin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="nok_relationship">Relationship*:</label>
                    <select class="form-control @error('nok_relationship') is-invalid @enderror" id="nok_relationship" name="nok_relationship" required>
                        <option value="father">Father</option>
                        <option value="husband">Husband</option>
                    </select>
                    @error('nok_relationship')
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
                    <label for="state">State*:</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" placeholder="State" id="state" name="state" value="{{ old('state') }}" required>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="lga">LGA*:</label>
                    <select class="form-control @error('lga') is-invalid @enderror" id="lga" name="lga" required>
                        <option value="father">Father</option>
                        <option value="husband">Husband</option>
                    </select>
                    @error('lga')
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
                    <label for="community">Community*:</label>
                    <input type="text" class="form-control @error('community') is-invalid @enderror" placeholder="Community" id="community" name="community" value="{{ $errors->any()? old('community') : $customer->community }}" required>
                    @error('community')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="full_address">Full Address*:</label>
                    <input type="text" class="form-control @error('full_address') is-invalid @enderror" placeholder="Full Address" id="full_address" name="full_address" value="{{ $errors->any()? old('full_address') : $customer->full_address }}" required>
                    @error('full_address')
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
                    <label for="email">Email (optional):</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" id="email" name="email" value="{{ $errors->any()? old('email') : $customer->email }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="poverty_index">Poverty Index:</label>
                    <input type="text" class="form-control @error('poverty_index') is-invalid @enderror" placeholder="Poverty Index" id="poverty_index" name="poverty_index" value="{{ $errors->any()? old('poverty_index') : $customer->poverty_index }}">
                    @error('poverty_index')
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
                    <label for="gender">Gender*:</label>
                    <select class="form-control @error('gender') is-invalid @enderror" required id="gender" name="gender">
                    <option value="">--Select Category--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    </select>
                    @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-*-*">
                <button type="submit" class="btn btn-primary" id="submit-ad">Update Account</button>
            </div>
        </div>
    </form>
@else
    <!-- The customer object is not yet set and therefore display the form for getting customer ID -->
    <form id="account_id">
        <div class="form-group">
            <label for="account_number">Enter Customer Account No:{{Session()->get('current_customer')->surname}}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">GD</span>
                </div>
                <input type="text" class="form-control" name="account_number" id="account_number" autofocus>
            </div>
            <span id="status" class="d-none">checking ...</span>
        </div>
            <button class="form-control btn-primary">Get Details</button>
    </form>
@endif
@section('footerLinks')
<script>
    //
    $('#account_number').keyup(function(){
        //GD00001531
        let status = $('#status');
        status.removeClass('d-none');
        let accNum = $(this).val();
        if(accNum.length != 8){
            status.text('Invalid Account Number');
        }
        else{
            status.addClass('d-none');
        }
        //alert('Editing info')
    })
</script>
@endsection
