@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Loans Awaiting Approval</h2>
    </div>
</div>
@endif
@if(count($variable_arr['pending_loans'])>0)
<table class="table">
    <tr>
        <th>S/N</th>
        <th>Customer Name</th>
        <th>Loan Amount (N)</th>
        <th>Repay Amount (N)</th>
        <th>Outstanding (N)</th>
        <th>Action</th>
    </tr>
    @foreach($variable_arr['pending_loans'] as $loan)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$loan->customer->full_name}}</td>
        <td>{{$loan->amount}}</td>
        <td>{{$loan->repay_amount}}</td>
        <td>{{$loan->outstanding_amount}}</td>
        <td><a href="/loans/pending?approve_loan={{$loan->customer_id}}"><button class="btn-primary">Approve</button></a></td>
    </tr>
    @endforeach
</table>
{{ $variable_arr['pending_loans']->links() }}
@else
There is currently no Pending Loans to display.
@endif
@section('footerLinks')
<script>

</script>
@endsection
