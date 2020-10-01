@extends('layouts.cargo_layout')

@section('content')
<div class="row mb-4">
    <div class="card col-md-5 col-lg-5">
        <div class="card-header bg-primary text-white">
            New shipment
        </div>
        <div class="card-body bg-white">
            <form action="" method="post">
                <div class="row">
                    <div class="form-group col-md-12 col-lg-12">
                        <label for="">Customer name</label>
                        <input type="text" placeholder="Customer name" class="form-control" name="customer_name"
                            v-model="Shipment.customer_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-lg-12">
                        <label for="">Customer telephone</label>
                        <input type="text" placeholder="Customer telephone" class="form-control"
                            name="customer_telephone" v-model="Shipment.customer_telephone">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-6">
                        <label for="">Origin city</label>
                        <input type="text" placeholder="Origin city" class="form-control" name="origin_city"
                            v-model="Shipment.origin_city">
                    </div>
                    <div class="form-group col-md-6 col-lg-6">
                        <label for="">Origin Country</label>
                        <input type="text" placeholder="Origin country" class="form-control" name="origin_country"
                            v-model="Shipment.origin_country">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-6">
                        <label for="">Destination city</label>
                        <input type="text" placeholder="Destination city" class="form-control" name="destination_city"
                            v-model="Shipment.destination_city">
                    </div>
                    <div class="form-group col-md-6 col-lg-6">
                        <label for="">Destination Country</label>
                        <input type="text" placeholder="Destination country" class="form-control"
                            name="destination_country" v-model="Shipment.destination_country">
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card col-md-7 col-lg-7">
        <div class="card-header bg-primary text-white">
            Item information
            <button class="btn btn-success float-right" @click.prevent="SaveShipment()"
                v-if="Shipment.items.length > 0"> <i class="fas fa-save"></i> Save </button>
            <button class="btn btn-success float-right" disabled="true" v-else> <i class="fas fa-save"></i> Save
            </button>
        </div>
        <div class="card-body">

            <div class="row">
                <table class="table">
                    <thead class="bg-soft-primary text-dark">
                        <th> unit</th>
                        <th> name</th>
                        <th> quantity</th>
                        <th> CPM/KG</th>
                        <th>Total</th>
                        <th>Supplier</th>
                    </thead>
                    <tbody>
                        <tr v-for="(item,ikey) in Shipment.items" :key="ikey">
                            <td>
                                <i class="fas fa-times-circle text-danger" @click.prevent="removeItem(item)"></i>
                                <span v-text="item.item_unit+'/'+item.item_total"></span>
                            </td>
                            <td v-text="item.item_name"></td>
                            <td v-text="item.item_quantity"></td>
                            <td v-text="item.item_cpm+'/'+item.item_kgs"></td>
                            <td v-text="item.item_item_total"></td>
                            <td v-text="item.item_supplier"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Item name</label>
                    <input type="text" placeholder="Item name" class="form-control" name="item_name"
                        v-model="ItemForm.item_name">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Item Quantity</label>
                    <input type="text" placeholder="Item quantity" class="form-control" name="item_quantity"
                        v-model="ItemForm.item_quantity">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Item CPM</label>
                    <input type="text" placeholder="Item cpm" class="form-control" name="item_cpm"
                        v-model="ItemForm.item_cpm">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Item Supplier</label>
                    <input type="text" placeholder="Item supplier" class="form-control" name="item_supplier"
                        v-model="ItemForm.item_supplier">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Item Kgs</label>
                    <input type="text" placeholder="Item Kgs" class="form-control" name="item_kgs"
                        v-model="ItemForm.item_kgs">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Package number</label>
                    <input type="text" placeholder="Package number" class="form-control" name="package_number"
                        v-model="ItemForm.package_number">
                </div>
            </div>
            <div class="row">

                <div class="form-group col-md-6 col-lg-6">
                    <label for="">Receipt number</label>
                    <input type="text" placeholder="Receipt number" class="form-control" name="item_receipt_number"
                        v-model="ItemForm.item_receipt_number">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 col-lg-12">
                    <label for="">Item Remarks</label>
                    <textarea name="item_remarks" name="item_remarks" cols="30" rows="3" style="resize: none"
                        class="form-control" placeholder="Remarks" v-model="ItemForm.item_remarks"></textarea>
                </div>
            </div>
            <button class="btn btn-primary" @click.prevent="addNewItem()">
                <i class="fas fa-plus-circle text-white mr-3"></i> Add item
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-md-10 col-lg-10">
        <div class="card-header bg-primary text-white">
            Today's shipments
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
                    @foreach ($latest_shipments as $shipment)
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

@section('scripts')

<!-- Sweet Alerts js -->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Sweet alert init js-->
{{-- <script src="/assets/js/pages/sweet-alerts.init.js"></script> --}}
@php
$hash = hash('md5', public_path('/js/newshipment.js'));
@endphp
<script>
    window.company_token = "{{$company->company_token}}";
    window.company_id = "{{$company->id}}";
    window.host_type = "{{isset($staff) ? 2 : 1}}"
    window.staff_id = "{{isset($staff) ? $staff->id : null}}"
    window.staff_email = "{{isset($staff) ? $staff->staff_email : null}}"

</script>
<script src={{"/js/newshipment.js?".$hash}}></script>
@endsection

@section('links')


<!-- Sweet Alert-->
<link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection
