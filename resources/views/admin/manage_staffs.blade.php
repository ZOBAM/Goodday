@if(session()->has('info'))
    @include('layouts.notification')
@endif
@if(count($variable_arr['staffs'])>0)
<h3 class="card-title text-center">List of Staffs</h3>
    <table class="table table-responsive table-striped table-hover">
        <tr>
            <th>S/N</th>
            <th>Full Name</th>
            <th>ID No.</th>
            <th>Phone No.</th>
            <th>Role</th>
            <th colspan="2" class="text-center">Action</th>
            <th>Date Created</th>
        </tr>
    @foreach($variable_arr['staffs'] as $staff)
    <tr id="{{$staff->id}}" class="t-row">
        <td>{{$loop->iteration}}</td>
        <td>{{$staff->full_name}}</td>
        <td>{{$staff->id}}</td>
        <td>{{$staff->phone_number}}</td>
        <td>
            @if($staff->rank>1)
            Admin
            @else
            Staff
            @endif
        </td>
        <td>
            @if($staff->rank > 1)
            <form method="POST" action="/admin/{{$staff->id}}/remove-admin">
                {{csrf_field()}}
                <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that {{$staff->full_name}} should be removed from admins? Click OK to proceed or CANCEL to return back")' style="white-space: nowrap;">Remove Admin</button>
            </form>
            @else
            <form method="POST" action="/admin/{{$staff->id}}/make-admin">
                {{csrf_field()}}
                <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that {{$staff->full_name}} should be made an admin? Click OK to proceed or CANCEL to return back")' style="white-space: nowrap;">Make Admin</button>
            </form>
            @endif
        </td>
        <td>
            @if($staff->rank > 0)
            <form method="POST" action="/admin/{{$staff->id}}/remove-staff">
                {{csrf_field()}}
                <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that {{$staff->full_name}} should be removed from admins? Click OK to proceed or CANCEL to return back")'>Deactivate</button>
            </form>
            @else
            <form method="POST" action="/admin/{{$staff->id}}/make-admin">
                {{csrf_field()}}
                <button class="btn-primary" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that {{$staff->full_name}} should be made an admin? Click OK to proceed or CANCEL to return back")'>Activate</button>
            </form>
            @endif
        </td>
        <td>{{$staff->created_at}}</td>
    </tr>
    @endforeach
    </table>
@else
    There is no Staff to manage at the moment.
@endif
