@extends($route.'.main')
@section ('section-title', 'Dashboard')
@section ('display-btn-add-new', 'display:none')
@section ('section-css')



@endsection


@section ('section-content')
<form class="sign-box" id="form" name="form-signin_v1">
    <div class="sign-avatar">
        <img src="{{ asset ('public/user/img/logo.png') }}" alt="">
    </div>
    <header class="sign-title">Dashboard</header>
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
    <div class="form-group">
        <input  type="number" 
                value ="1221766518246" 
                class="form-control" 
                placeholder="Reciept Number"
                required
                id="myInput"
                name="reference_number" />
    </div>
    <button type="button" class="btn btn-inline" onclick="invoicePayment()">Submit</button>
    
</form>
<script>
    function invoicePayment(ctrl){
            // var id=ctrl.getAttribute('data-code');
             var reference_number = $("#myInput").val();
            
            // $.ajax({
          

            $.ajax({
                url: "http://96.9.67.237:44310/api/v2.1.2/validate-vpn-invoice?partner=ACLEDA&reference_number="+reference_number,
                method: 'GET',
                headers:
                        {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'), 
                            Authorization: 'Basic acle05dd34cefb112d3444fp6mee7b86fcqy2719a5da'
                        },
                success: function( response ) {
                    if(response.response_code == 200){
                        
                        swal("Nice!", 'Success',"success");
                        $.ajax({
                            url: "http://96.9.67.237:44310/api/v2.1.2/submit-vpn-invoice",
                            method: 'POST',
                            headers:
                                    {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'), 
                                        Authorization: 'Basic acle05dd34cefb112d3444fp6mee7b86fcqy2719a5da'
                                    },
                                });
                        
                    }else{
                        swal("Error!", "Reciept is not valid. " ,"error");
                    }
                    
                    console.log(response); 
                },
                error: function( response ) {
                    swal("Error!", "Sorry there is an error happens. " ,"error");
                }
            });
        }

</script>


@endsection