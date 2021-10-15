<!-- If a customer object was returned from server, display the edith form -->
@if($variable_arr['session_isset'])
@php
    $customer = Session()->get('current_customer')
@endphp
    @if(session()->has('info'))
        @include('layouts.notification')
    @else
        <h5 class="card-title text-center">Updating {{$customer->surname.' '.$customer->first_name}} <br>({{$customer->account_number}})</h5>
        <!-- <h2>Updating {{$customer->surname.' '.$customer->first_name}} ({{$customer->account_number}})</h2> -->

        <form method="POST" @submit='update'  enctype="multipart/form-data" id='post-ad-form' action = '/customers/{{$customer->id}}'>
            {{ csrf_field() }}
            <div class="row" style="margin-bottom: 1rem">
                <div class = "col-sm-4 offset-sm-4">
                    <div style="width: 100px; height: 100px; background-color: white; margin: auto; cursor: pointer">
                        <img src="{{asset('/images/customers/'.$customer->passport)}}" alt="" id="place_holder" style="max-width: 100px;max-height: 100px;">
                    </div>
                        <span style="color: blue">Click on image to change profile picture.</span>
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
                        <input type="text" class="form-control @error('other_name') is-invalid @enderror" placeholder="Other Name" id="other_name" name="other_name" value="{{ $errors->any()? old('other_name') : $customer->other_name }}">
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
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone number" id="phone_number" name="phone_number" value="{{ $errors->any()? old('phone_number') : $customer->phone_number }}" required>
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="button" value="Add More Details" v-on:click = "moreDetails = !moreDetails">
            <div v-if = "moreDetails">
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
                            <input type="text" class="form-control @error('state') is-invalid @enderror" placeholder="State" id="state" name="state" value="{{ $errors->any()? old('state') : $customer->state }}" required>
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
                            <input type="text" class="form-control @error('lga') is-invalid @enderror" placeholder="LGA" id="lga" name="lga" value="{{ $errors->any()? old('lga') : $customer->lga }}" required>
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
            </div>
            <input type="button" value="Add Guarantor's Detail" v-on:click = "addGuarantor = !addGuarantor">
            <div v-if ="addGuarantor === true">
                <hr style="border: .5em solid #3490DC;width: 100%;margin:0em auto 0em -0.6em;color: #3490DC;">
                <h3>Guarantors' Details</h3>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="gfull_name">Full Name:</label>
                            <input type="gfull_name" class="form-control @error('gfull_name') is-invalid @enderror" placeholder="Full Name" id="gfull_name" name="gfull_name" value="{{ old('gfull_name') }}" required>
                            @error('gfull_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gphone_number">Phone Number:</label>
                            <input type="text" class="form-control @error('gphone_number') is-invalid @enderror" placeholder="Phone No." id="gphone_number" name="gphone_number" value="{{ old('gphone_number') }}" required>
                            @error('gphone_number')
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
                            <label for="grelationship">Relationship:</label>
                            <select class="form-control @error('grelationship') is-invalid @enderror" id="grelationship" name="grelationship" required>
                                <option value="">--Relationship--</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Daughter</option>
                                <option value="father">Father</option>
                                <option value="friend">Friend</option>
                                <option value="husband">Husband</option>
                                <option value="mother">Mother</option>
                                <option value="sister">Sister</option>
                                <option value="sister">Son</option>
                                <option value="wife">Wife</option>
                            </select>
                            @error('grelationship')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="goccupation">Occupation:</label>
                            <input type="text" class="form-control @error('goccupation') is-invalid @enderror" placeholder="Occupation" id="goccupation" name="goccupation" value="{{ old('goccupation') }}" required>
                            @error('goccupation')
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
                            <label for="gresident_address">Residential Address:</label>
                            <input type="text" class="form-control @error('gresident_address') is-invalid @enderror" placeholder="Residential Address" id="gresident_address" name="gresident_address" value="{{ old('gresident_address') }}" required>
                            @error('gresident_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gwork_address">Work/Business Address:</label>
                            <input type="text" class="form-control @error('gwork_address') is-invalid @enderror" placeholder="Work/Business Address" id="gwork_address" name="gwork_address" value="{{ old('gwork_address') }}" required>
                            @error('gwork_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-*-*">
                    <button type="submit" class="btn btn-primary" id="submit-ad">Update Account</button>
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
@section('general-script')
<script>
    var app = new Vue({
    el: '#app',
    data: {
        addGuarantor: false,
        moreDetails : false,
    },
    methods:{
        update(){
            localStorage.setItem('updated', 1);
        }
    },
    mounted(){
        let userID = "{{$customer->id??0}}";
        let updated = localStorage.getItem('updated');
        if(updated == 1){
            //alert("Updated");
            localStorage.setItem('updated', 0);
            setTimeout(()=>{
                location =' http://'+location.hostname+'/customers/view/'+userID;
            }, 2000)
        }
    }
    })
</script>
@endsection
