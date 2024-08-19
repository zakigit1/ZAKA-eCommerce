<script>
    $(document).ready(function() {

        // this is for crsf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.shopping-cart-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('add-to-cart') }}",
                    method: 'POST',
                    data: formData,

                    success: function(data) {
                        if(data.status =='success'){
                            getCartCount()
                            fetchSidebarCartProducts()
                            $('.mini-cart-actions').removeClass('d-none');
                            toastr.success(data.message);
                        }else if(data.status =='warning'){
                            toastr.warning(data.message);
                        }
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            });
    

        // remove product form  cart sidebar 

            $('body').on('click', '.remove-sidebar-product',function(e){
                e.preventDefault();
                let rowId = $(this).data('rowid');


                $.ajax({
                    type: 'POST',
                    url: "{{route('remove-product-form-sidebar-cart')}}",
                    data: {
                        rowId: rowId
                    },
                    success: function (data) {
                        if (data.status == 'success') {

                            let productId = '#mini_cart_' + rowId;
                            $(productId).remove()
                            
                            //cart details remove product : 
                            let productId2 = "#cart_details_" + rowId;
                            $(productId2).remove()

                            // this working but not correct i need to fix it : (this if condition using for redirect when the cart is empty )
                            // if($(".cart-item").length == 0 && $(productId2).length == 0){
                            //     window.location.reload();
                            // }  


                            getSidebarCartSubtotal()
                            if($('.mini-cart-wrapper').find('li').length == 0){

                                $('.mini-cart-actions').addClass('d-none');
                                $('.mini-cart-wrapper').html('<li class="text-center"> Cart Is Empty ! </li>');
                            }   

                            toastr.success(data.message);

                        }else if(data.status == 'error'){ 
                            toastr.warning(data.message);
                        
                            setTimeout(function(){
                                window.location.reload();
                            }, 3000);    
                        }
                    }
                });
            });


        // AJAX Functions : 

        // fetch all product from the cart add display it in the sidebar :
            function fetchSidebarCartProducts() {
                $.ajax({
                    method: 'GET',
                    url: "{{route('cart-get-products')}}",

                    success: function(data) {
                        console.log(data);
                        $('.mini-cart-wrapper').html("");
                        var html = '';

                        for(let item in data){
                            let product = data[item];
                            html += `    
                                <li id="mini_cart_${product.rowId}">
                                    <div class="wsus__cart_img">
                                        <a href="url('product-details')}}/${product.options.slug}">
                                            <img src="${product.options.image}" alt="product" class="img-fluid w-100">
                                        </a>
                                        
                                        <a class="wsis__del_icon remove-sidebar-product" href="#" data-rowid="${product.rowId}">
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
                                    </div>

                                    <div class="wsus__cart_text">
                                        <a class="wsus__cart_title" href="{{url('product-details')}}/${product.options.slug}">
                                            ${product.name} 
                                        </a>
                                        <p>{{$settings->currency_icon}}${product.price}</p>
                                        <small>Variant Total : {{$settings->currency_icon }}${product.options.variants_total_amount}</small>
                                        <br>
                                        <small>Qty : ${product.qty}</small>
                                    </div>
                                </li>`
                        }

                        // console.log(html);
                        $('.mini-cart-wrapper').html(html);

                        getSidebarCartSubtotal()
                    },
                    error: function(data) {

                    }
                });
            }

        // get sidebar cart subtotal : 
            function getSidebarCartSubtotal(){
                $.ajax({
                    url: "{{ route('cart-get-total-products-sidebar') }}",
                    method: 'GET',
                    

                    success: function(data) {
                        $('#mini_cart_subtotal').text("{{$settings->currency_icon}}" + data);
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            }

        //  dispaly cart counter :
            function getCartCount() {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('cart-counter') }}",
                    success: function(data) {
                        $('#cart-count').text(data);
                    },
                    error: function(data) {}
                });
            }

        
            

    });
</script>