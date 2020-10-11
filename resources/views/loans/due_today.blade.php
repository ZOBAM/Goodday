<div class="row">
    <div class="col-sm-6 offset-sm-3 text-center">
        <h2>Loans  Repayment</h2>
        <h3>Due For <span style="padding: 4px;background-color: rgb(8, 39, 80);color: rgb(247, 244, 240);">{{date('D d/M/Y',strtotime($variable_arr['due_date']))}}</span></h3>
    </div>
</div>
@if(count($variable_arr['loans_due_today'])>0)
<div class = "table-responsive">
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
</div>
<div class="row">
    <a href="/loans/due_today?due_day=yesterday&due_date={{$variable_arr['due_date']}}" class="col text-center">
        <button class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Due Yesterday
        </button>
    </a>
    <a href="/loans/due_today?due_day=tomorrow&due_date={{$variable_arr['due_date']}}" class="col text-center">    
        <button class="btn btn-primary">
            Due Tomorrow <i class="fa fa-arrow-right"></i>
        </button>
    </a>    
</div>
@else
There is currently no Loan that is due for repayment today.
@endif
@section('footerLinks')
<script>

</script>
@endsection
