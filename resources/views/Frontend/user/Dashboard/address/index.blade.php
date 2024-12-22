@extends('Frontend.user.Dashboard.layouts.master')


@section('title')
    {{ "$settings->site_name || Addresses" }}
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <div class="back_button">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary"> <i class="fas fa-chevron-circle-left"></i>
                        back</a>
                </div>
                <br>
                <h3><i class="fas fa-map-marked-alt"></i> address</h3>
                <div class="wsus__dashboard_add">
                    <div class="row">

                        <div class="col-12 mb-5">
                            <a href="{{ route('user.address.create') }}" class="add_address_btn common_btn">
                                <i class="far fa-plus"></i>
                                add new address
                            </a>
                        </div>
                        @if (isset($addresses) && count($addresses) > 0)
                            @foreach ($addresses as $address)
                                <div class="col-xl-6">
                                    <div class="wsus__dash_add_single">
                                        <h4>{{ auth()->user()->name }} Address </h4>

                                        <ul>
                                            <li><span>name :</span> {{ $address->name }}</li>
                                            <li><span>Phone :</span> {{ $address->phone }}</li>
                                            <li><span>email :</span> {{ $address->email }}</li>
                                            <li><span>country :</span> {{ $address->country }}</li>
                                            <li><span>state :</span> {{ $address->state }}</li>
                                            <li><span>city :</span> {{ $address->city }}</li>
                                            <li><span>zip code :</span> {{ $address->zip }}</li>
                                            <li><span>address :</span> {{ $address->address }}</li>
                                        </ul>
                                        <div class="wsus__address_btn">
                                            <a href="{{ route('user.address.edit', $address->id) }}" class="edit"><i
                                                    class="fal fa-edit"></i> edit</a>
                                            <a href="{{ route('user.address.destroy', $address->id) }}"
                                                class="del  delete-item-with-ajax"><i class="fal fa-trash-alt"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
