<script>
    $(document).ready(function() {

        // this is for crsf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Add to cart
            $(document).on('submit','.shopping-cart-form',function(e) {
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
                                
                                setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                }, 1000); // 30000 milliseconds = 30 seconds ,1000 = 1 second
                            }   

                            toastr.success(data.message);

                            getCartCount()

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


        // Add Products to the  Wishlist: 

        // $('.add_to_wishlist').on('click',function(e){
        //     e.preventDefault();

        //     let productId = $(this).data('id');

        //     // i want to add codition about when you click if user are not login it will get a message about need to login to add your product to wishlist

        //     $.ajax({
        //             url: "{{ route('user.wishlist.store') }}",
        //             method: 'GET',
        //             data: {productId : productId },
        //             success: function(data) {
        //                 if(data.status =='success'){
        //                     $('#wishlist_count').text(data.count)
        //                     toastr.success(data.message);
        //                 }else if(data.status =='error'){
        //                     toastr.error(data.message);   
        //                 }
        //             },
        //             error: function(data) {
        //                 console.log('error');
        //             }
        //         });
        // })
            
        
        $(document).on('click','.add_to_wishlist',function(e) {
            e.preventDefault();
            e.stopPropagation();

            var isAuthenticated = @auth true @else false @endauth;
            
            let productId = $(this).data('id');

       

            if (!isAuthenticated) {
                toastr.warning("You need to login to add this product to your wishlist");
                return;
            }

            $.ajax({
                url: "{{ route('user.wishlist.store') }}",
                method: 'GET',
                data: { productId: productId },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#wishlist_count').text(data.count)
                        toastr.success(data.message);
                    } else if (data.status == 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    console.log('error');
                }
            });
        });

        // Footer Newsletter

        $('#newsletter').on('submit',function(e){
            e.preventDefault();

            let data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: "{{ route('newsletter-request') }}",
                    data: data,
                    beforeSend : function () {
                        $('.subscribe_btn').text('Loading ...');
                    },
                    success: function(data) {
                        if(data.status =='success'){

                            $('.subscribe_btn').text('Subscribe');

                            $('.newsletter_email').val('');

                            toastr.success(data.message);

                        }else if(data.status =='error'){

                            $('.subscribe_btn').text('Subscribe');

                            toastr.error(data.message);   
                        }
                    },
                    error: function(data) {

                        let errors = data.responseJSON.errors;

                        if(errors){
                            $.each(errors, function(key, value){
                                toastr.error(value);
                            })

                        }

                    }
                });
        })

        
        // Show Product Model POP UP 
        $('.show_product_model').on('click', function() {

            let id = $(this).data('id')

            $.ajax({
                method: 'GET',
                url: "{{ route('show-product-model',':id') }}".replace(':id', id),//if any error edit double cotation
                
                beforeSend: function() {
                    $('.product_model_content').html('<span class="loader"></span>');
                },
                success: function(response) {
                    if(response.status =='error'){
                        toastr.error(response.message);
                    }
                    $('.product_model_content').html(response);
                },
                error: function(xhr, status, error){
                    console.log('error');
                }, 
                complete: function() {
                    
                }
            });
        })


    })
</script>