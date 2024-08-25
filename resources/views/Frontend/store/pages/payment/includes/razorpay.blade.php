
@php
    $razorpaySetting = \App\Models\RazorpaySetting::first() ;   

    // Calculate Razorpay Amount depending to currency rate exp : DA  -> USD  or Euro to USD: 
        $total = finalAmount();//this function in general file 
        $paidAmountfinal  = round( $total * $razorpaySetting ->currency_rate , 2);// you get the price in USD 
@endphp


<form action="{{route('user.razorpay.payment')}}" method="POST">

    @csrf

    <script src="http://checkout.razorpay.com/v1/checkout.js"
        data-key="{{ $razorpaySetting->razorpay_key }}"
        data-amount="{{ $paidAmountfinal * 100 }}"
        data-buttontext="Pay with Razorpay"
        data-name="payment"
        data-description="Payment For Product"
        data-prefill.name="{{auth()->user()->name}}"
        data-prefill.email="{{auth()->user()->email}}"
        data-theme.color="#ff7529"
    >

    </script>
    
</form>






{{-- @push('scripts')
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
@endpush --}}