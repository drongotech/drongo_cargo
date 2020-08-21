@extends('layouts.cargo_layout')

@section('content')
<div class="row">
    <div class="card col-md-12 col-lg-12">
        <div class="card-header">
            Shipment details
        </div>
        <div class="card-body">
            <div class="row">
                <h3>
                    {{$company->company_name}}
                </h3>
            </div>
            <div class="row mb-3 mt-2">
                <img src="{{$shipment->qrcode->qrcode_image}}" alt="">
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <i class="fas fa-user-circle mr-4"></i>
                    {{$shipment->customer_name}}
                </div>
                <div class="col-md-6 col-lg-6">
                    <i class="fas fa-phone-square mr-4"></i>
                    {{$shipment->customer_phone}}
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 col-lg-6">
                    <i class="fas fa-plane-departure mr-4"></i>
                    {{$shipment->city_of_origin}}, {{$shipment->country_of_origin}}
                </div>
                <div class="col-md-6 col-lg-6">
                    <i class="fas fa-plane-arrival mr-4"></i>
                    {{$shipment->destination_city}}, {{$shipment->destination_country}}
                </div>
            </div>

            @php
            $items = $shipment->items;
            @endphp

            <table class="table mt-3">
                <thead class="bg-soft-primary text-dark">
                    <tr>
                        <th>Unit</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>CPM</th>
                        <th>Supplier</th>
                        <th>Remarks</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>
                            {{$item->item_unit}}
                        </td>
                        <td>{{$item->item_name}}</td>
                        <td>{{$item->item_quantity}}</td>
                        <td>{{$item->item_cpm}}</td>
                        <td>{{$item->item_supplier}}</td>
                        <td>{{$item->item_remarks}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="card col-md-12 col-lg-12">
                    <div class="card-header">
                        Item QR codes
                        <a class="btn btn-primary float-right" 
                        href="/cargo/shipments/view/{{$shipment->id.'/'.$shipment->tracking_number}}" target="_blank" >Get qrcode list </a>
                    </div>
                    <div class="card-body row bg-light-gray">
                        @foreach ($items as $item)
                        <div class="card col-md-4 col-lg-4">
                            <div class="card-header text-dark col-md-12 col-lg-12">
                                {{$item->item_unit}} {{$item->item_name}}
                            </div>
                            <div class="card-body ">
                                <div class="row text-dark">
                                    {{$company->company_name}}
                                </div>
                                <div class="row mt-4 mb-4">
                                    <img src="{{$item->qrcode->qrcode_image}}" width="" alt="">
                                </div>
                            </div>


                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
