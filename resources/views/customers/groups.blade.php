
@if(session()->has('info'))
    @include('layouts.notification')
@else
    <h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
    <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = '/customers'>
        {{ csrf_field() }}
        <div class="row">
            <div class = "col-sm-4 offset-sm-4">
                <div style="width: 100px; height: 100px; background-color: white; margin: auto;">
                    <img src="{{asset('/images/male_avatar.png')}}" alt="" id="place_holder" style="max-width: 100px;max-height: 100px;">
                </div>
                <input type="file" class="form-control-file" id="customer_passport" name="customer_passport" hidden>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="name">Group Name*:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Group Name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="address">Group Location/Address*:</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Group Address" id="address" name="address" value="{{ old('address') }}" required>
                    @error('address')
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
                    <label for="staff_in_charge">Staff in Charge:</label>
                    <select class="form-control @error('staff_in_charge') is-invalid @enderror" id="staff_in_charge" name="staff_in_charge" required>
                        <option value="">--select staff--</option>
                        @foreach($variable_arr['staffs'] as $staff)
                        <option value="{{$staff->id}}">{{$staff->full_name}}</option>
                        @endforeach
                    </select>
                    @error('staff_in_charge')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="meeting_days">Meeting Day:</label>
                    <select class="form-control @error('meeting_days') is-invalid @enderror" id="meeting_days" name="meeting_days" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                    @error('meeting_days')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <input type="button" value="Add More Details" v-on:click = "moreDetails = !moreDetails">
        <div v-if = "moreDetails">
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
                            <option value="father">Father</option>
                            <option value="mother">Mother</option>
                            <option value="wife">Wife</option>
                            <option value="husband">Husband</option>
                            <option value="brother">Brother</option>
                            <option value="sister">Sister</option>
                            <option value="friend">Friend</option>
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
                <button type="submit" class="btn btn-primary" id="submit-ad">Create Account</button>
            </div>
        </div>
    </form>
    @section('footerLinks')
    <script src="{{asset('/js/customer.js')}}" defer></script>
    <script>
        var app = new Vue({
        el: '#app',
        data: {
            addGuarantor: false,
            moreDetails : false,
        },
        methods:{
        }
        })
    </script>
    @endsection
@endif
