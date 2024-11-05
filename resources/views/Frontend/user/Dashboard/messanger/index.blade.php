@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Messanger "}}
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
                                            <h2>Seller List</h2>
                                            <div class="wsus__chatlist_body">
                                                <button class="nav-link seller"
                                                    id="seller-list-6" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                                    aria-controls="v-pills-home" aria-selected="true">
                                                    <div class="wsus_chat_list_img">
                                                        <img src="http://127.0.0.1:8000/uploads/custom-images/robert-james-2022-08-15-01-18-57-7752.png"
                                                            alt="user" class="img-fluid">
                                                        <span class="pending d-none" id="pending-6">0</span>
                                                    </div>
                                                    <div class="wsus_chat_list_text">
                                                        <h4>Robert James</h4>
                                                    </div>
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-7">
                                    <div class="wsus__chat_main_area">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">
                                                <div id="chat_box">
                                                    <div class="wsus__chat_area">
                                                        <div class="wsus__chat_area_header">
                                                            <h2>Chat with Daniel Paul</h2>
                                                        </div>
                                                        <div class="wsus__chat_area_body">
                                                            <div class="wsus__chat_single">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/daniel-paul-2022-08-15-01-16-48-4881.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Welcome to Shop name 2!

                                                                        Lorem Ipsum is simply dummy text of the printing
                                                                        and typesetting industry. Lorem Ipsum has been
                                                                        the industry's standard dummy text ever since
                                                                        the 1500s, when an unknown printer took a galley
                                                                        of type and scrambled it to make a type specimen
                                                                        book.</p>
                                                                    <span>15 August, 2022, 12:56 PM</span>
                                                                </div>
                                                            </div>
                                                            <div class="wsus__chat_single single_chat_2">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/john-doe-2022-08-15-01-14-20-3892.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Hello Paul</p>
                                                                    <span>15 August, 2022, 12:57 PM</span>
                                                                </div>
                                                            </div>
                                                            <div class="wsus__chat_single single_chat_2">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/john-doe-2022-08-15-01-14-20-3892.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>I have some queries</p>
                                                                    <span>15 August, 2022, 12:57 PM</span>
                                                                </div>
                                                            </div>
                                                            <div class="wsus__chat_single">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/daniel-paul-2022-08-15-01-16-48-4881.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Hi Joe, Thanks for your contact</p>
                                                                    <span>15 August, 2022, 12:58 PM</span>
                                                                </div>
                                                            </div>
                                                            <div class="wsus__chat_single">
                                                                <div class="wsus__chat_single_img">
                                                                    <img src="http://127.0.0.1:8000/uploads/custom-images/daniel-paul-2022-08-15-01-16-48-4881.png"
                                                                        alt="user" class="img-fluid">
                                                                </div>
                                                                <div class="wsus__chat_single_text">
                                                                    <p>Please tell me you query</p>
                                                                    <span>15 August, 2022, 12:58 PM</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wsus__chat_area_footer" style="margin-top: 50px;">
                                                            <form id="customerToSellerMsgForm">
                                                                <input type="text" placeholder="Type Message"
                                                                    id="seller_message" autocomplete="off">
                                                                <input type="hidden" name="seller_id" id="seller_id"
                                                                    value="5">
                                                                <button type="submit"><i class="fas fa-paper-plane"
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