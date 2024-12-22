@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Contact Us")

@section('content')
    <!--============================
            BREADCRUMB START
        ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Contact Us</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            BREADCRUMB END
        ==============================-->


    <!--============================
            CONTACT PAGE START
        ==============================-->
    <section id="wsus__contact">
        <div class="container">
            <div class="wsus__contact_area">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">

                            {{-- Mail address  --}}
                            @if ($settings->contact_email)
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="fal fa-envelope"></i>
                                        <h5>mail address</h5>
                                        <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                                        <span><i class="fal fa-envelope"></i></span>
                                    </div>
                                </div>
                            @endif

                            {{-- Phone --}}
                            @if ($settings->contact_phone)
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="far fa-phone-alt"></i>
                                        <h5>phone number</h5>
                                        <a
                                            href="macallto:{{ @$settings->contact_phone }}">{{ @$settings->contact_phone }}</a>
                                        <span><i class="far fa-phone-alt"></i></span>
                                    </div>
                                </div>
                            @endif

                            {{-- Contatct address  --}}
                            @if ($settings->contact_address)
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="fal fa-map-marker-alt"></i>
                                        <h5>contact address</h5>
                                        <a href="javascript:;">{{ $settings->contact_address }}</a>
                                        <span><i class="fal fa-map-marker-alt"></i></span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>


                    @if (!$settings->contact_email && !$settings->contact_phone && !$settings->contact_address)
                        <div class="col-xl-12">
                        @else
                            <div class="col-xl-8">
                    @endif
                    <div class="wsus__contact_question">
                        <h5>Send Us a Message</h5>

                        <form id="contact-form">
                            @csrf


                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Enter Your Name">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter Your Email">
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="text" name="subject" value="{{ old('subject') }}"
                                            placeholder="Enter Your Subject">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <textarea name="message" placeholder="Enter Your Message">{!! old('message') !!}</textarea>
                                    </div>

                                    <button type="submit" class="common_btn contact_submit">send now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Map --}}
                @if ($settings->contact_map)
                    <div class="col-xl-12">
                        <div class="wsus__con_map">
                            <iframe {{-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.1435090089785!2d90.42196781465853!3d23.81349539228068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c62fb95f16c1%3A0xb333248370356dee!2sJamuna%20Future%20Park!5e0!3m2!1sen!2sbd!4v1639724859199!5m2!1sen!2sbd" --}} src="{{ $settings->contact_map }}" width="1600" height="450"
                                style="border:0;" allowfullscreen="100" loading="lazy"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </section>
    <!--============================
            CONTACT PAGE END
        ==============================-->


@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $('#contact-form').on('submit', function(e) {
                e.preventDefault();

                let data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "{{ route('handle-contact-form') }}",
                    data: data,
                    beforeSend: function() {
                        $('.contact_submit').text('sending ...');
                        $('.contact_submit').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.status == 'success') {

                            toastr.success(data.message);
                            $('#contact-form')[0].reset();
                            $('.contact_submit').text('send now');
                            $('.contact_submit').attr('disabled', false);

                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }


                    },
                    error: function(data) {

                        let errors = data.responseJSON.errors;

                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            })

                            $('.contact_submit').text('send now');
                            $('.contact_submit').attr('disabled', false);
                        }

                    }
                });
            })





        });
    </script>
@endpush
