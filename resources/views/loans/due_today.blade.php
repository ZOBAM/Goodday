@if($variable_arr['session_isset'])
<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Loans Due For Repayment Today</h2>
    </div>
</div>
@endif
@if(count($variable_arr['loans_due_today'])>0)
<table class="table">
    <tr>
        <th>S/N</th>
        <th>Customer Name</th>
        <th>Loan Amount (N)</th>
        <th>Amount Due (N)</th>
        <th>Total Outstanding (N)</th>
    </tr>
    @foreach($variable_arr['loans_due_today'] as $loan)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$loan->loan->customer->full_name}}</td>
        <td>{{$loan->loan->amount}}</td>
        <td>
            {{$loan->amount_repaid}} <a href = "/loans/repayment/{{$loan->id}}">Repay</a>
        </td>
        <td>{{$loan->loan->outstanding_amount}}</td>
    </tr>
    @endforeach
</table>
{{ $variable_arr['loans_due_today']->links() }}
@else
There is currently no Loan that is due for repayment today.
@endif
@section('footerLinks')
<script>

</script>
@endsection
