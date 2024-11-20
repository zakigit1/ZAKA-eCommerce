@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || User Messanger " }}
@endsection


@section('content')
    <!--=============================
                DASHBOARD START
            ==============================-->
    <section>
        <div>
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-star" aria-hidden="true"></i> Message</h3>
                        <div class="wsus__dashboard_review">
                            <div class="row">
                                <div class="col-xl-4 col-md-5">
                                    <div class="wsus__chatlist d-flex align-items-start">
                                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <h2>Sellers List</h2>
                                            @if (isset($sallersInfo) && count($sallersInfo) > 0)
                                                @foreach ($sallersInfo as $sellerInfo)
                                                    <div class="wsus__chatlist_body">
                                                        <button class="nav-link seller conversion-messages"
                                                            data-id="{{ $sellerInfo->receiverProfile->id }}"
                                                            data-bs-toggle="pill" data-bs-target="#v-pills-home"
                                                            type="button" role="tab" aria-controls="v-pills-home"
                                                            aria-selected="true">
                                                            <div class="wsus_chat_list_img">
                                                                <img src="{{ $sellerInfo->receiverProfile->image }}"
                                                                    alt="user" class="img-fluid">
                                                                <span class="pending d-none" id="pending-6">0</span>
                                                            </div>
                                                            <div class="wsus_chat_list_text">
                                                                <h4>{{ $sellerInfo->receiverProfile->name }}</h4>
                                                            </div>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-7">
                                    <div class="wsus__chat_main_area">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">
                                                <div id="chat_box">
                                                    <div class="wsus__chat_area"
                                                        style="position: relative;
                                                        height: 78vh ;">
                                                        <div class="wsus__chat_area_header">
                                                            <h2 id="receiver-name">Chat with Daniel Paul</h2>
                                                        </div>
                                                        <div class="wsus__chat_area_body">

                                                            {{-- <div class="wsus__chat_single single_chat_2">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/john-doe-2022-08-15-01-14-20-3892.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Hello Paul</p>
                                                                    <span>15 August, 2022, 12:57 PM</span>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="wsus__chat_single">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/daniel-paul-2022-08-15-01-16-48-4881.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Please tell me you query</p>
                                                                    <span>15 August, 2022, 12:58 PM</span>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="wsus__chat_area_footer"
                                                            style="margin-top: 50px;
                                                            
                                                            position: absolute;
                                                            width: 100%;
                                                            bottom: 0;">
                                                            <form id="conversion-message-form">
                                                                @csrf

                                                                <input type="hidden" name="receiver_id" id="receiver_id"
                                                                    value="">

                                                                <input type="text" name="message" placeholder="Type Message" 
                                                                    class="message-box" autocomplete="off">

                                                                <button type="submit"><i class="fas fa-paper-plane send-message-button"
                                                                        aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                DASHBOARD START
            ==============================-->
@endsection

@push('scripts')
    <script>
        const mainChatInbox = $('.wsus__chat_area_body');

        // function to costum the time : 
        function formatDateTime(dateTimeString) {
            const options = {
                year: 'numeric',
                month: 'short',// like : November = Nov
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                // hour12: false 
                };

            const formatedDateTime = new Intl.DateTimeFormat('en-US', options).format(new Date(dateTimeString));

            return formatedDateTime;
        }

        // scrolling the conversion to button automatically when you click to the bull
        function scrollToButton() {
            mainChatInbox.scrollTop(mainChatInbox.prop("scrollHeight"));
        }


        $(document).ready(function() {
            // Click to the conversion bullet button :
            $('.conversion-messages').on('click', function() {
                let receiverId = $(this).data('id');
                let receiverName = $(this).find('h4').text();
                let receiverImage = $(this).find('img').attr('src');//Vendor image
                // console.log(receiverName);

                $('#receiver_id').val(receiverId);

                $.ajax({
                    method: 'GET',
                    url: "{{ route('user.get-conversions') }}",
                    data: {
                        receiverId: receiverId
                    },
                    beforeSend: function() {
                        mainChatInbox.html("");
                        // set receiver name 
                        $('#receiver-name').text(`Chat with ${receiverName}`);
                    },
                    success: function(response) {
                        if (response.status == 'success') {

                            $.each(response.conversion, function(index, value) {

                                if(value.sender_id == USER.id){
                                    var message = `                                              
                                        <div class="wsus__chat_single single_chat_2">
                                            <div class="wsus__chat_single_img">
                                                <img src="${USER.image}"
                                                    alt="user" class="img-fluid">
                                            </div>
                                            <div class="wsus__chat_single_text">
                                                <p>${value.message}</p>
                                                <span>${formatDateTime(value.created_at)}</span>
                                            </div>
                                        </div>`

                                    mainChatInbox.append(message);
                                } else {
                                        var message = `                                              
                                            <div class="wsus__chat_single">
                                                <div class="wsus__chat_single_img">
                                                    <img src="${receiverImage}"
                                                        alt="user" class="img-fluid">
                                                </div>
                                                <div class="wsus__chat_single_text">
                                                    <p>${value.message}</p>
                                                    <span>${formatDateTime(value.created_at)}</span>
                                                </div>
                                            </div>`
    
                                        mainChatInbox.append(message);
                                        
                                }
                            });
                            // scrolling the conversion to button automatically when you click to the bull
                            scrollToButton();



                        } else if (response.status == 'error') {

                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        toastr.error(xhr.responseJSON.message);

                    },
                    complete: function() {


                    }
                });
            })

            // Sending message :
            $('#conversion-message-form').on('submit', function(e) {
                e.preventDefault();

                let data = $(this).serialize();
                let messageData = $('.message-box').val();

                var formSubmitting = false; // this will be true when the user write a message in the box 

                if(formSubmitting || messageData === "") {
                    return ;
                }

                // Send message in conversion 
                // let message = `                                              
                //     <div class="wsus__chat_single single_chat_2">
                //         <div class="wsus__chat_single_img">
                //             <img src="${USER.image}"
                //                 alt="user" class="img-fluid">
                //         </div>
                //         <div class="wsus__chat_single_text">
                //             <p>${messageData}</p>
                //             <span>${formatDateTime(new Date().toISOString())}</span>
                //         </div>
                //     </div>`

                // mainChatInbox.append(message);
                // scrollToButton();



                $.ajax({
                    method: 'POST',
                    url: "{{ route('user.send-message-to-vendor') }}",
                    data: data,
                    beforeSend: function() {
                       $('.send-message-button').prop('disabled', true);
                       formSubmitting = true;
                    },
                    success: function(response) {

                        if (response.status == 'success') {
                            $('.message-box').val('');
                            
                            
                        }else if (response.status == 'error') {
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        toastr.error(xhr.responseJSON.message);  
                        
                        $('.send-message-button').prop('disabled', false);  
                        formSubmitting = false;
                    },
                    complete: function() {

                        // Send message in conversion 
                        let message = `                                              
                            <div class="wsus__chat_single single_chat_2">
                                <div class="wsus__chat_single_img">
                                    <img src="${USER.image}"
                                        alt="user" class="img-fluid">
                                </div>
                                <div class="wsus__chat_single_text">
                                    <p>${messageData}</p>
                                    <span>${formatDateTime(new Date().toISOString())}</span>
                                </div>
                            </div>`

                        mainChatInbox.append(message);
                        scrollToButton();


                        $('.send-message-button').prop('disabled', false);
                        formSubmitting = false;
                    }
                });
            })

        });
    </script>
@endpush
