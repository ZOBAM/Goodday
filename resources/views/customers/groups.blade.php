
@if(session()->has('info'))
    @include('layouts.notification')
@else
    @if (session()->has('group'))
        <h2 class="text-center">Assign <strong>{{Session()->get('group')->name}}</strong> Group Leaders</h2>
        @if(Session()->get('group')->members)
            <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = "/groups/{{Session()->get('group')->id}}/create_leaders">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="leader_id">Group Leader*:</label>
                            <select class="form-control @error('leader_id') is-invalid @enderror" id="leader_id" name="leader_id" required>
                                <option value="">--select Leader--</option>
                                @foreach(Session()->get('group')->members as $member)
                                <option value="{{$member->id}}">{{$member->full_name}}</option>
                                @endforeach
                            </select>
                            @error('leader_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="secretary_id">Group Secretary*:</label>
                            <select class="form-control @error('secretary_id') is-invalid @enderror" id="secretary_id" name="secretary_id" required>
                                <option value="">--select Secretary--</option>
                                @foreach(Session()->get('group')->members as $member)
                                <option value="{{$member->id}}">{{$member->full_name}}</option>
                                @endforeach
                            </select>
                            @error('secretary_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-*-*">
                        <button type="submit" class="btn btn-primary" id="submit-ad">Assign Group Leaders</button>
                    </div>
                </div>
            </form>
        @else
            <div class="col-sm-12 alert alert-primary" role="alert">
                <p><strong>No Members:</strong>  There is no members in this group yet to Make Leaders.</p>
            </div>
        @endif
    <!-- DISPLAY THE DETAILS OF THE SELECTED GROUP -->
    @elseif(isset($variable_arr['group']))
        <h2 class="text-center">{{$variable_arr['group']->name}}</h2>
        @if($variable_arr['group']->population > 0)
            <div class="table-responsive" style="width: 100%; margin-top:1em">
                    <h2 style="text-align: center; padding: 0.5em;">Group Members<sup>{{$variable_arr['group']->population}}</sup></h2>
                    <table class = "table-sm" style="margin: auto;">
                        <tr class="text-center">
                            <th>S/N</th>
                            <th>Customer Name </th>
                            <th> Position </th>
                            <th> Date Added </th>
                            <th colspan="2"> Actions </th>
                        </tr>
                        @foreach($variable_arr['group']->customer as $member)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$member->full_name}}
                                </td>
                                <td>{{$member->position}}</td>
                                <td>{{date("d F, Y",strtotime($variable_arr['group']->created_at))}}</td>
                                <td>
                                    <form method="POST" action="/groups/{{$member->id}}/remove">
                                        {{csrf_field()}}
                                        <button class="btn-secondary" style="white-space: nowrap;">Remove <i class="fas fa-minus-circle"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
            </div>
            <div>
                Staff in Charge: <strong>{{$variable_arr['group']->staff_name}}</strong> | population: <strong>{{$variable_arr['group']->population}}</strong>
            </div>
        @else

            <div class="col-sm-12 alert alert-primary" role="alert">
                <p><strong>No Members:</strong>  No member yet in this group.</p>
            </div>
        @endif
    @else
        <!-- <span class="float-right">Close X</span> -->
        <h5 class="card-title text-center">Fields Mark With (*) Are Required</h5>
        <form method="POST"  enctype="multipart/form-data" id='post-ad-form' action = '/groups'>
            {{ csrf_field() }}
            <!-- <div class="row">
                <div class = "col-sm-4 offset-sm-4">
                    <div style="width: 100px; height: 100px; background-color: white; margin: auto;">
                        <img src="{{asset('/images/male_avatar.png')}}" alt="" id="place_holder" style="max-width: 100px;max-height: 100px;">
                    </div>
                    <input type="file" class="form-control-file" id="customer_passport" name="customer_passport" hidden>
                </div>
            </div> -->
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
                        <label for="staff_in_charge">Staff in Charge*:</label>
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
                        <label for="meeting_day">Meeting Day*:</label>
                        <select class="form-control @error('meeting_day') is-invalid @enderror" id="meeting_day" name="meeting_day" required>
                            <option value="">--choose meeting day--</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                        @error('meeting_day')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-*-*">
                    <button type="submit" class="btn btn-primary" id="submit-ad">Create Group</button>
                </div>
            </div>
        </form>
    @endif
@endif
    <div class="table-responsive" style="width: 100%; border-top: 2px solid grey; margin-top:1em">
        @if(count($variable_arr['groups'])>0)
            <h2 style="text-align: center; padding: 0.5em;">Customers' Groups</h2>
            <table class = "table-sm" style="margin: auto;">
                <tr class="text-center">
                    <th>S/N</th>
                    <th>Group Name </th>
                    <th> Population </th>
                    <th> Date Created </th>
                    <th colspan="2"> Actions </th>
                </tr>
                @foreach($variable_arr['groups'] as $group)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <a href="/customers/groups/{{$group->id}}">{{$group->name}}</a>
                        </td>
                        <td>{{$group->population}}</td>
                        <td>{{date("d F, Y",strtotime($group->created_at))}}</td>
                        <td>
                            <form method="POST" action="/groups/{{$group->id}}/create_leaders">
                                {{csrf_field()}}
                                <button class="btn-primary" style="white-space: nowrap;">Assign Posts</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="/groups/{{$group->id}}/delete">
                                {{csrf_field()}}
                                <button class="btn-danger" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that \"{{$group->name}}\" should be removed from Groups available? Click OK to proceed or CANCEL to return back")' style="white-space: nowrap;">Delete Group <i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="col-sm-12 alert alert-primary" role="alert">
                <p><strong>No Groups Yet:</strong>  There is currently no created groups.</p>
            </div>
        @endif
    </div>
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
