
<form action="{{route('user.stripe.payment')}}" method="POST" id="checkout-form">
    @csrf
    <input type="hidden" name="stripe_token" id="stripe-token-id">

    <div id="card-element" class="form-control" style="padding: 18px"></div>
    <br>
    <button type="button" class="nav-link common_btn" id="pay-btn" onclick="createToken()">Pay with Stripe</button>
    
</form>



@php
    $stripeSetting = \App\Models\StripeSetting::first() ;   
@endphp


@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>

        var stripe = Stripe("{{ $stripeSetting->client_id }}");
        var elements = stripe.elements();
        var cardElement = elements.create('card');

        cardElement.mount('#card-element');

        function createToken(){

            document.getElementById("pay-btn").disabled = true
            stripe.createToken(cardElement).then(function(result){

                if(typeof result.error != 'undefined'){
                    document.getElementById("pay-btn").disabled = false ;
                    alert(result.error.message);  
                }

                // Creating Token Success :
                if(typeof result.token != 'undefined'){
                    document.getElementById("stripe-token-id").value = result.token.id ;
                    document.getElementById("checkout-form").submit() ;
                }


            });

        }


    </script>
@endpush