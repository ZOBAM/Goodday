@if(count($variable_arr['transactions'])>0)
<div class="row">
    <div class="col-sm-8 offset-sm-2 text-center">
        <h2>{{$variable_arr['heading']}}<sup>({{$variable_arr['transactions']->total()}})</sup></h2>
    </div>
</div>
<table class="table table-responsive">
    <tr>
        <th>S/N</th>
        <th>T/Reference</th>
        <th> Type </th>
        <th> Comment </th>
        <th> Amt(N)</th>
        <th>Date</th>
    </tr>
    @foreach($variable_arr['transactions'] as $transaction)
    <tr>
        <td>{{$loop->iteration + ($variable_arr['transactions']->currentPage() - 1) * $variable_arr['transactions']->perPage() }}</td>
        <td>{{$transaction->ref_id}}</td>
        <td>{{$transaction->type}}</td>
        <td>{{$transaction->comment}}</td>
        <td>{{$transaction->amount}}</td>
        <td>{{$transaction->created_at}}</td>
    </tr>
    @endforeach
</table>
{{ $variable_arr['transactions']->links() }}
@else
There is currently no Transactions for today to display.
@endif
@section('footerLinks')
<script>

</script>
@endsection
