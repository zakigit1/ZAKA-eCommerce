<script>
    $(document).ready(function() {

        // this is for crsf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add to cart
        $(document).on('submit', '.shopping-cart-form', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('add-to-cart') }}",
                method: 'POST',
                data: formData,

                success: function(data) {
                    if (data.status == 'success') {
                        getCartCount()
                        fetchSidebarCartProducts()
                        $('.mini-cart-actions').removeClass('d-none');
                        toastr.success(data.message);
                    } else if (data.status == 'warning') {
                        toastr.warning(data.message);
                    }
                },
                error: function(data) {
                    console.log('error');
                }
            });
        });


        // remove product form  cart sidebar 

        $('body').on('click', '.remove-sidebar-product', function(e) {
            e.preventDefault();
            let rowId = $(this).data('rowid');


            $.ajax({
                type: 'POST',
                url: "{{ route('remove-product-form-sidebar-cart') }}",
                data: {
                    rowId: rowId
                },
                success: function(data) {
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
                        if ($('.mini-cart-wrapper').find('li').length == 0) {

                            $('.mini-cart-actions').addClass('d-none');
                            $('.mini-cart-wrapper').html(
                                '<li class="text-center"> Cart Is Empty ! </li>');

                            setTimeout(function() {
                                window.location.href = "{{ route('home') }}";
                            }, 1000); // 30000 milliseconds = 30 seconds ,1000 = 1 second
                        }

                        toastr.success(data.message);

                        getCartCount()

                    } else if (data.status == 'error') {
                        toastr.warning(data.message);

                        setTimeout(function() {
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
                url: "{{ route('cart-get-products') }}",

                success: function(data) {
                    console.log(data);
                    $('.mini-cart-wrapper').html("");
                    var html = '';

                    for (let item in data) {
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
                                        <a class="wsus__cart_title" href="{{ url('product-details') }}/${product.options.slug}">
                                            ${product.name} 
                                        </a>
                                        <p>{{ $settings->currency_icon }}${product.price}</p>
                                        <small>Variant Total : {{ $settings->currency_icon }}${product.options.variants_total_amount}</small>
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
        function getSidebarCartSubtotal() {
            $.ajax({
                url: "{{ route('cart-get-total-products-sidebar') }}",
                method: 'GET',


                success: function(data) {
                    $('#mini_cart_subtotal').text("{{ $settings->currency_icon }}" + data);
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

        // add product to wishlist with login user
        $(document).on('click', '.add_to_wishlist', function(e) {
                e.preventDefault();
                e.stopPropagation();

            var isAuthenticated = @auth true
                    @else
                        false
                    @endauth ;

            let productId = $(this).data('id');



            if (!isAuthenticated) {
                toastr.warning("You need to login to add this product to your wishlist");
                return;
            }

            $.ajax({
                    url: "{{ route('user.wishlist.store') }}",
                    method: 'GET',
                    data: {
                        productId: productId
                    },
                    success: function(data) {
                        
                        if (data.status == 'success') {
                            $('#wishlist_count').text(data.count)

                                // wish list button design (style)
                                wishlistStyleButton(data)
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

        // make the wishlist button style (this is the new optimazable function )
        function wishlistStyleButton(data) {
            // Constants for styling
            const STYLE_CLASSES = {
                FILLED: 'fas',
                EMPTY: 'far'
            };

            const BUTTON_STYLES = {
                buyNow: `
                    text-transform: uppercase;
                    font-weight: 600;
                    color: #fff !important;
                    background: #B01E28;
                    padding: 9px 15px;
                    border-radius: 30px;
                    font-size: 14px;
                `,
                default: `
                    text-transform: uppercase;
                    font-size: 12px;
                    font-weight: 600;
                    color: #fff !important;
                    background: #B01E28;
                    border-radius: 3px;
                `
            };

            // Get all heart icons for this product using a single selector
            const $heartIcons = $(`[id^="wishlist-heart-"][id$="-${data.productId}"]`);
            
            // Early return if no icons found
            if (!$heartIcons.length) {
                console.warn(`No wishlist hearts found for product ${data.productId}`);
                return;
            }

            const newClass = data.style === STYLE_CLASSES.FILLED ? STYLE_CLASSES.EMPTY : STYLE_CLASSES.FILLED;
            const oldClass = data.style === STYLE_CLASSES.FILLED ? STYLE_CLASSES.FILLED : STYLE_CLASSES.EMPTY;

            // Update all icons at once
            $heartIcons
                .removeClass(oldClass)
                .addClass(newClass);

            // Handle parent styling
            const $parents = $heartIcons.parent();
            
            if (newClass === STYLE_CLASSES.FILLED) {
                // Apply styles based on parent class
                $parents.each(function() {
                    const $parent = $(this);
                    const style = $parent.hasClass('buy_now') ? 
                        BUTTON_STYLES.buyNow : 
                        BUTTON_STYLES.default;
                    
                    $parent.attr('style', style);
                });
            } else {
                // Clear all parent styles
                $parents.removeAttr('style');
            }
        }


        // make the wishlist button style (this is the old function but it is understandable because i created by myself)  )
        function wishlistStylebutton(data){
            
            
            // Update the heart icon based on the product's wishlist status
            const heartIcon0 = $(`#wishlist-heart-0-${data.productId}`); 
            const heartIcon1 = $(`#wishlist-heart-1-${data.productId}`); 
            const heartIcon2 = $(`#wishlist-heart-2-${data.productId}`); 
            const heartIcon3 = $(`#wishlist-heart-3-${data.productId}`); 
            const heartIcon4 = $(`#wishlist-heart-4-${data.productId}`); 


            const parentLink = heartIcon0.parent(); 
            if (data.style === 'fas') {
                // Product is not in the wishlist

                heartIcon0.removeClass('fas').addClass('far'); // Change to empty heart
                heartIcon1.removeClass('fas').addClass('far'); // Change to empty heart
                heartIcon2.removeClass('fas').addClass('far'); // Change to empty heart
                heartIcon3.removeClass('fas').addClass('far'); // Change to empty heart
                heartIcon4.removeClass('fas').addClass('far'); // Change to empty heart






                // Remove styles from the parent <a> element
                heartIcon0.parent().attr('style', ''); // Clear styles
                heartIcon1.parent().attr('style', ''); // Clear styles
                heartIcon2.parent().attr('style', ''); // Clear styles
                heartIcon3.parent().attr('style', ''); // Clear styles
                heartIcon4.parent().attr('style', ''); // Clear styles





            } else if (data.style === 'far') {
                // Product is in the wishlist
                heartIcon0.removeClass('far').addClass('fas'); // Change to filled heart
                heartIcon1.removeClass('far').addClass('fas'); // Change to filled heart
                heartIcon2.removeClass('far').addClass('fas'); // Change to filled heart
                heartIcon3.removeClass('far').addClass('fas'); // Change to filled heart
                heartIcon4.removeClass('far').addClass('fas'); // Change to filled heart


                if (parentLink.hasClass('buy_now')) {
                    heartIcon0.parent().attr('style', `
                        text-transform: uppercase;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        padding: 9px 15px;
                        border-radius: 30px;
                        font-size: 14px;
                    `);

                } else {
                    
                    heartIcon0.parent().attr('style', `
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        border-radius: 3px;
                    `);
                    heartIcon1.parent().attr('style', `
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        border-radius: 3px;
                    `);
                    heartIcon2.parent().attr('style', `
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        border-radius: 3px;
                    `);
                    heartIcon3.parent().attr('style', `
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        border-radius: 3px;
                    `);
                    heartIcon4.parent().attr('style', `
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 600;
                        color: #fff !important;
                        background: #B01E28;
                        border-radius: 3px;
                    `);
                }
            }
        }

        // Footer Newsletter
        $('#newsletter').on('submit', function(e) {
            e.preventDefault();

            let data = $(this).serialize();

            $.ajax({
                method: 'POST',
                url: "{{ route('newsletter-request') }}",
                data: data,
                beforeSend: function() {
                    $('.subscribe_btn').text('Loading ...');
                },
                success: function(data) {
                    if (data.status == 'success') {

                        $('.subscribe_btn').text('Subscribe');

                        $('.newsletter_email').val('');

                        toastr.success(data.message);

                    } else if (data.status == 'error') {

                        $('.subscribe_btn').text('Subscribe');

                        toastr.error(data.message);
                    }
                },
                error: function(data) {

                    let errors = data.responseJSON.errors;

                    if (errors) {
                        $.each(errors, function(key, value) {
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
                url: "{{ route('show-product-model', ':id') }}".replace(':id',
                    id), //if any error edit double cotation

                beforeSend: function() {
                    $('.product_model_content').html('<span class="loader"></span>');
                },
                success: function(response) {
                    if (response.status == 'error') {
                        toastr.error(response.message);
                    }
                    $('.product_model_content').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('error');
                },
                complete: function() {

                }
            });
        })



    })
</script>
