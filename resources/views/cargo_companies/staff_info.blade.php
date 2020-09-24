@extends('layouts.cargo_layout')


@section('pageTitle')
Staff info
@endsection

@section('parentPage')
Copmany staff info
@endsection

@section('content')
<div class="card">
    <div class="card-head text-center">
        <strong>
            {{$staff->staff_name}}
        </strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 col-lg-4">Email: {{$staff->staff_email}}</div>
            <div class="col-md-4 col-lg-4">Phone: {{$staff->staff_phone}}</div>
        </div>

        @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div> 
        @endif
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Supplier info</th>
                            <th>Customer info</th>
                            <th>Shipment info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Read</strong>
                            </td>
                            <td>
                                @if ($staff->has_supplier_read_perm)
                                    <form action="/cargo/staff/21/{{$staff->id}}" method="post" id="supplierRead">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierRead').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/21/{{$staff->id}}" method="post" id="supplierRead">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierRead').submit()">
                                    </form>
                                @endif
                                
                            </td>
                            <td>
                                
                                
                            </td>
                            <td>
                                @if ($staff->has_shipment_read_perm)
                                    <form action="/cargo/staff/31/{{$staff->id}}" method="post" id="customerRead">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('customerRead').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/31/{{$staff->id}}" method="post" id="customerRead">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('customerRead').submit()">
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Write</strong>
                            </td>
                            <td>
                                @if ($staff->has_supplier_write_perm)
                                    <form action="/cargo/staff/22/{{$staff->id}}" method="post" id="supplierWrite">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierWrite').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/22/{{$staff->id}}" method="post" id="supplierWrite">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierWrite').submit()">
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($staff->has_customer_write_perm)
                                    <form action="/cargo/staff/12/{{$staff->id}}" method="post" id="customerWrite">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('customerWrite').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/12/{{$staff->id}}" method="post" id="customerWrite">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('customerWrite').submit()">
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($staff->has_shipment_write_perm)
                                    <form action="/cargo/staff/32/{{$staff->id}}" method="post" id="shipmentWrite">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('shipmentWrite').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/32/{{$staff->id}}" method="post" id="shipmentWrite">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('shipmentWrite').submit()">
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Delete</strong>
                            </td>
                            <td>
                                @if ($staff->has_supplier_delete_perm)
                                    <form action="/cargo/staff/23/{{$staff->id}}" method="post" id="supplierDelete">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierDelete').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/23/{{$staff->id}}" method="post" id="supplierDelete">
                                        @csrf
                                        <input type="checkbox" class="m-3" name="permission" 
                                        onchange="document.getElementById('supplierDelete').submit()">
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($staff->has_customer_delete_perm)
                                    <form action="/cargo/staff/13/{{$staff->id}}" method="post" id="customerDelete">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('customerDelete').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/13/{{$staff->id}}" method="post" id="customerDelete">
                                        @csrf
                                        <input type="checkbox" class="m-3" name="permission" 
                                        onchange="document.getElementById('customerDelete').submit()">
                                    </form>
                                @endif
                                
                            </td>
                            <td>
                                @if ($staff->has_shipment_delete_perm)
                                    <form action="/cargo/staff/33/{{$staff->id}}" method="post" id="shipmentDelete">
                                        @csrf
                                        <input type="checkbox" checked class="m-3" name="permission" 
                                        onchange="document.getElementById('shipmentDelete').submit()">
                                    </form>
                                @else
                                    <form action="/cargo/staff/33/{{$staff->id}}" method="post" id="shipmentDelete">
                                        @csrf
                                        <input type="checkbox"  class="m-3" name="permission" 
                                        onchange="document.getElementById('shipmentDelete').submit()">
                                    </form>
                                @endif
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection