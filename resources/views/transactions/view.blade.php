@if(count($variable_arr['transactions'])>0)
<div class="row">
    <div class="col-sm-12 text-center">
        <h2>{{$variable_arr['heading']}}<sup>({{$variable_arr['transactions']->total()}})</sup></h2>
    </div>
    <div class="col-sm-12">
        <form id="account_id">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3">
                            <select class="custom-select" name="staff_id" id="staff_id" autofocus>
                                <option value="">Select Staff</option>
                                <option value="1">Mathew Hamsa</option>
                            </select>
                        </div>
                    </div>
        </form>
    </div>
</div>
<table class="table table-responsive table-striped table-hover">
    <thead style="background-color: rgb(73, 67, 165);color: cornsilk;">
        <tr>
            <th>S/N</th>
            <th>T/Reference</th>
            <th> Type </th>
            <th> Comment </th>
            <th> Amt(N)</th>
            <th>Date</th>
        </tr>
    </thead>
    @foreach($variable_arr['transactions'] as $transaction)
    <tr>
        <td>{{$loop->iteration + ($variable_arr['transactions']->currentPage() - 1) * $variable_arr['transactions']->perPage() }}</td>
        <td>{{$transaction->ref_id}}</td>
        <td>{{$transaction->type}}</td>
        <td>{{$transaction->comment}}</td>
        <td>{{$transaction->amount}}</td>
        <td>{{date('F d, Y, h:ia',strtotime($transaction->created_at) )}}</td>
    </tr>
    @endforeach
</table>
<div>
    <p>Transactions Summary: The total amount for this {{$action}} is:
        <span style = "color:dark-blue;font-weight:bolder">
            N<span class="moneyNum">{{$variable_arr['transactions_total']}}</span>
        </span>
    </p>
</div>
{{ $variable_arr['transactions']->links() }}
@else
There is currently no Transactions for today to display.
@endif
@section('footerLinks')
<script>
    $('#staff_id').change(function(){
        location = location.href+'?staff_id='+$(this).val();
        //alert($(this).val());
        //alert(location.href);
    })
var th = ['','thousand','million', 'billion','trillion'];
var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine'];
 var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen'];
 var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function toWords(s) {
    s = s.toString();
    s = s.replace(/[\, ]/g,'');
    if (s != parseFloat(s)) return 'not a number';
    var x = s.indexOf('.');
    if (x == -1)
        x = s.length;
    if (x > 15)
        return 'too big';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i=0;   i < x;  i++) {
        if ((x-i)%3==2) {
            if (n[i] == '1') {
                str += tn[Number(n[i+1])] + ' ';
                i++;
                sk=1;
            } else if (n[i]!=0) {
                str += /* 'and '  +*/ tw[n[i]-2] + ' ';
                sk=1;
            }
        } else if (n[i]!=0) { // 0235
            str += dg[n[i]] +' ';
            if ((x-i)%3==0) str += 'hundred ';
            sk=1;
        }
        if ((x-i)%3==1) {
            if (sk)
                str += th[(x-i-1)/3] + ' ';
            sk=0;
        }
    }

    if (x != s.length) {
        var y = s.length;
        str += 'point ';
        for (var i=x+1; i<y; i++)
            str += dg[n[i]] +' ';
    }
    return str.replace(/\s+/g,' ');
}
$('.moneyNum').each(function(){
    $(this).text($(this).text()+' ('+toWords($(this).text())+' naira)');
    //alert(toWords($(this).text()));
    //alert("{{$variable_arr['transactions_total']}}") +" naira");
})
</script>
@endsection
