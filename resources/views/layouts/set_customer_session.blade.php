<form id="account_id">
    <div class="form-group">
        <label for="account_number">Enter Customer's Name or Phone or Acc. no.:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" name="account_number" id="account_number" autofocus>
        </div>
        <div id="suggestions" class="d-none" style="overflow: auto; max-height:30vh">Loading ...</div>
    </div>
    <!-- <button class="form-control btn-primary">Continue</button> -->
</form>
@section('footerLinks')
<script>
    function setCustomer() {
        //alert("setting customer");
        console.log(window.location);
    }
    window.addEventListener("DOMContentLoaded", () => {
        //alert("content loaded");
        let targetElem = document.getElementById('suggestions');
        let customerInfoElem = document.getElementById('account_number');

        customerInfoElem.addEventListener("keyup", () => {
            //alert("pressed");
            let customerInfo = customerInfoElem.value;
            setCustomer();
            if (customerInfo.trim() != '' && customerInfo.length > 1) {
                targetElem.classList.remove('d-none');
                let innerHtml = 'Loading . . .';
                fetch('/search?query=' + customerInfo).then(response => response.json()).then(data => {
                    // console.log(data);
                    //alert(customerInfoElem.value)
                    if (data.length > 0) {
                        innerHtml = '';
                        for (let i = 0; i < data.length; i++) {
                            if (data[i].id != 1) {
                                let customerLink = window.location.href;
                                innerHtml += `<a href='${customerLink}?account_number=${data[i].account_number.substr(2)}' style="display: block;padding:3px" id="${i}"> ${data[i].surname} ${data[i].first_name} ${data[i].account_number} </a>`;
                            }
                        }
                    } else {
                        innerHtml = "No record found";
                    }
                    targetElem.innerHTML = innerHtml;
                });
            }
        });
    })
</script>
@endsection