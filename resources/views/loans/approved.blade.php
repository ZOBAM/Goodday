@if(session()->has('info'))
        @include('layouts.notification')
@endif
<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Loans That Have Approval</h2>
    </div>
</div>
@if(count($variable_arr['pending_loans'])>0)
<div class = 'table-responsive'>
    <table class="table">
        <tr>
            <th>S/N</th>
            <th>Customer Name</th>
            <th>Loan Amount (N)</th>
            <th>Repay Amount (N)</th>
            <th>Outstanding (N)</th>
            <th></th>
        </tr>
        @foreach($variable_arr['pending_loans'] as $loan)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$loan->customer->full_name}}</td>
            <td>{{$loan->amount}}</td>
            <td>{{$loan->repay_amount}}</td>
            <td>{{$loan->outstanding_amount}}</td>
            <td>
                @if($variable_arr['is_admin'] && !$loan->loan_cleared && $loan->repay_amount == $loan->outstanding_amount)
                <form method="POST" action="/loans/{{$loan->id}}/delete" >
                    {{csrf_field()}}
                    <div class="row" style="max-width: 550px; margin: auto">
                        <button class="col-sm-12 btn btn-outline-danger" onclick = 'return confirm("{{ Auth::user()->first_name }}, by proceeding you Confirm that you want to PERMANENTLY delete this Loan Application? Click OK to proceed or CANCEL to return back")' title = "Delete This Loan" style = "white-space: nowrap;">Delete <i class="fa fa-trash float-right"></i></button>
                    </div>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{ $variable_arr['pending_loans']->links() }}
</div>
@else
There is currently no Approved Loans to display.
@endif
@section('footerLinks')
<script>

</script>
@endsection
