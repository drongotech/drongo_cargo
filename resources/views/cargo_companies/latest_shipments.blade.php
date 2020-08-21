@extends('layouts.cargo_layout')

@section('content')
    <div class="row">
    <div class="card col-md-10 col-lg-10">
        <div class="card-header bg-primary text-white">
            Latest shipments
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Tracking number</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Items</th>
                        <th>Date</th>
                    </tr>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td></td>
                                <td>
                                    <a href="/cargo/shipments/{{$shipment->id}}/{{$shipment->tracking_number}}">
                                        {{$shipment->tracking_number}}
                                    </a>
                                </td>
                                <td>{{$shipment->customer_name}}</td>
                                <td>{{$shipment->customer_phone}}</td>
                                <td>{{$shipment->items->count()}}</td>
                                <td>{{$shipment->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection