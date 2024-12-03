@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Admin Messanger " }}
@endsection

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Messanger</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Conversion</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-md-3">
                    <div class="card" style="height: 70vh">
                        <div class="card-header">
                            <h4>Clients List</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @if (isset($clientsInfo) && count($clientsInfo) > 0)
                                    @foreach ($clientsInfo as $clientInfo)
                                        @php
                                            $unseenMessage =App\Models\Chat::where([
                                                    'sender_id' => $clientInfo->senderProfile->id ,
                                                    'receiver_id' => auth()->user()->id ,
                                                    'seen' => 0])
                                                ->exists();
                                        @endphp
                                        
                                        
                                        <li class="media conversion-messages" 
                                            data-id="{{ $clientInfo->senderProfile->id }}">
                                            <img alt="image" style="height: 40px;object-fit: cover " 
                                            class="mr-3 rounded-circle {{($unseenMessage) ? 'msg-notification' : ''}}" width="50"
                                                src="{{ $clientInfo->senderProfile->image }}">
                                            <div class="media-body">
                                                <div class="mt-0 mb-1 font-weight-bold chat-receiver-name">
                                                    {{ $clientInfo->senderProfile->name }}</div>
                                                {{-- <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i>
                                                    Online</div> --}}
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card chat-box d-none" id="mychatbox" style="height: 70vh">
                        <div class="card-header">
                            <h4 id="receiver-name"></h4>
                        </div>

                        <div class="card-body chat-content" data-inbox="">

                            {{-- Vendor messages : --}}       
                            {{-- <div class="chat-item chat-left" style=""> 
                                <div class="chat-item chat-right" style=""><img src="../dist/img/avatar/avatar-2.png">
                                <div class="chat-details">
                                    <div class="chat-text">Wat?!</div>
                                    <div class="chat-time">02:06</div>
                                </div>
                            </div> --}}

                            {{-- Client messages :--}}
                            {{-- <div class="chat-item chat-left" style="">
                                <img src="../dist/img/avatar/avatar-1.png">
                                <div class="chat-details">
                                    <div class="chat-text">You wanna know?</div>
                                    <div class="chat-time">02:06</div>
                                </div>
                            </div> --}}

                        </div>
                        
                        
                        <div class="card-footer chat-form">
                            <form id="conversion-message-form">
                                @csrf
                                <input type="hidden" name="receiver_id" id="receiver_id" value="">

                                <input type="text" class="form-control message-box" name="message" autocomplete="off" placeholder="Type a message">
                                

                                <button type="submit" class="btn btn-primary">
                                    <i class="far fa-paper-plane send-message-button"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const mainChatInbox = $('.chat-content');

        // function to costum the time : 
        function formatDateTime(dateTimeString) {
            const options = {
                year: 'numeric',
                month: 'short', // like : November = Nov
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
                let receiverName = $(this).find('.chat-receiver-name').text();//Client Name
                let receiverImage = $(this).find('img').attr('src');//Client image
                $('.chat-box').removeClass('d-none');
                mainChatInbox.attr('data-inbox', receiverId);

                //remove circul notification when click to chat 
                $(this).find('img').removeClass('msg-notification');
                // console.log(receiverName);

                // Set the receiver_id in the value of the input hidden field.
                $('#receiver_id').val(receiverId);

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-conversions') }}",
                    data: {
                        receiverId: receiverId
                    },
                    beforeSend: function() {
                        mainChatInbox.html("");
                        // Set receiver name 
                        $('#receiver-name').text(`Chat with ${receiverName}`);
                    },
                    success: function(response) {
                        if (response.status == 'success') {

                            $.each(response.conversion, function(index, value) {

                                if(value.sender_id == USER.id){
                                    var message = `                                              
                                        <div class="chat-item chat-right" style="">
                                            <img src="${USER.image}" style="height: 50px;object-fit: cover">
                                            <div class="chat-details">
                                                <div class="chat-text">${value.message}</div>
                                                <div class="chat-time">${formatDateTime(value.created_at)}</div>
                                            </div>
                                        </div>`
    
                                    mainChatInbox.append(message);
                                }else{
                                    var message = `                                              
                                        <div class="chat-item chat-left" style="">
                                            <img src="${receiverImage}" style="height: 50px;object-fit: cover">
                                            <div class="chat-details">
                                                <div class="chat-text">${value.message}</div>
                                                <div class="chat-time">${formatDateTime(value.created_at)}</div>
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

                // console.log(messageData);
                var formSubmitting = false; // this will be true when the user write a message in the box 

                if(formSubmitting || messageData === "") {
                    return ;
                }

                // send message in conversion 
                let message = `                                              
                    <div class="chat-item chat-right" style="">
                         <img src="${USER.image}" style="height: 50px;object-fit: cover">
                         <div class="chat-details">
                                <div class="chat-text">${messageData}</div>
                                <div class="chat-time">${formatDateTime(new Date().toISOString())}</div>
                        </div>
                    </div> `
                    
                mainChatInbox.append(message);
                $('.message-box').val('');
                scrollToButton();
                
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.send-message-to-vendor') }}",
                    data: data,
                    beforeSend: function() {
                       $('.send-message-button').prop('disabled', true);
                       formSubmitting = true;
                    },
                    success: function(response) {

                        if (response.status == 'success') {

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

                        // send message in conversion 
                        // let message = `                                              
                        //     <div class="chat-item chat-right" style="">
                        //         <img src="${USER.image}" style="height: 50px;object-fit: cover">
                        //         <div class="chat-details">
                        //                 <div class="chat-text">${messageData}</div>
                        //                 <div class="chat-time">${formatDateTime(new Date().toISOString())}</div>
                        //         </div>
                        //     </div> `
                    
                        // mainChatInbox.append(message);
                        // $('.message-box').val('');
                        // scrollToButton();

                        $('.send-message-button').prop('disabled', false);
                        formSubmitting = false;
                    }
                });
            })


        });
    </script>
@endpush
