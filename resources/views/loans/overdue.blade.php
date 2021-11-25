<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Overdue Loan Repayment</h2>
    </div>
</div>
@if(count($variable_arr['overdue_repayments'])>0)
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>S/N</th>
            <th>Customer Name</th>
            <th>Loan Amt (N)</th>
            <th>Amt Due (N)</th>
            <th>Total Outstanding (N)</th>
            <th>Due Date</th>
        </tr>
        @foreach($variable_arr['overdue_repayments'] as $loan)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$loan->loan->customer->full_name}}</td>
            <td>{{$loan->loan->amount}}</td>
            <td>
                {{$loan->amount_repaid}} <a href="/loans/repayment/{{$loan->id}}">Repay</a>
            </td>
            <td>{{$loan->loan->outstanding_amount}}</td>
            <td>{{date('D d/M/Y',strtotime($loan->due_date))}}</td>
        </tr>
        @endforeach
    </table>
    {{ $variable_arr['overdue_repayments']->links() }}
</div>
@else
There is currently no Loan that is due for repayment today.
@endif
@section('footerLinks')
<script>

</script>
@endsection