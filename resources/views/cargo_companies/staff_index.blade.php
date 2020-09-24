@extends('layouts.cargo_layout')

@section('pageTitle')
New staff
@endsection

@section('parentPage')
Company staff
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                Adding new company staff
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    @if (Session::has('errorMessage'))

                    <div class="alert alert-danger">
                        {{Session::get('errorMessage')}}
                    </div>
                    @elseif($errors->any())
                    <div class="alert alert-danger">
                        {{$errors->first()}}
                    </div>
                    @endif
                    @if (Session::has('success'))

                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Staff name</label>
                                <input type="text" class="form-control" placeholder="Enter staff name"
                                    name="staff_name" value="{{old('staff_name')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Staff email</label>
                                <input type="text" class="form-control" placeholder="Enter staff email"
                                    name="staff_email" value="{{old('staff_email')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Staff phone</label>
                                <input type="text" class="form-control" placeholder="Enter staff phone"
                                    name="staff_phone" value="{{old('staff_phone')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Staff password</label>
                                <input type="password" class="form-control" placeholder="Enter staff password"
                                    name="staff_password" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_read_shipment'))
                            <input type="checkbox" checked class="m-3" name="perm_read_shipment">
                            @else
                            <input type="checkbox" class="m-3" name="perm_read_shipment">
                            @endif
                            
                            <label for="">Permission to read shipment info </label>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_write_shipment'))
                            <input type="checkbox" checked class="m-3" name="perm_write_shipment">
                            @else
                            <input type="checkbox" class="m-3" name="perm_write_shipment">
                            @endif
                            <label for="">Permission to write shipment info </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_delete_shipment'))
                            <input type="checkbox" checked class="m-3" name="perm_delete_shipment">
                            
                            @else
                            <input type="checkbox" class="m-3" name="perm_delete_shipment">
                            
                            @endif
                            <label for="">Permission to delete shipment info </label>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_read_customer'))
                            <input type="checkbox" checked class="m-3" name="perm_read_customer">
                            
                            @else
                            <input type="checkbox" class="m-3" name="perm_read_customer">
                            
                            @endif
                            <label for="">Permission to read customer info </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_write_customer'))
                            <input type="checkbox" checked class="m-3" name="perm_write_customer">
                            
                            @else
                            <input type="checkbox" class="m-3" name="perm_write_customer">
                            
                            @endif
                            <label for="">Permission to write customer info </label>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_delete_customer'))
                            <input type="checkbox" checked class="m-3" name="perm_delete_customer">
                            
                            @else
                            <input type="checkbox" class="m-3" name="perm_delete_customer">
                            
                            @endif
                            <label for="">Permission to delete customer info </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_read_supplier'))
                            <input type="checkbox" checked class="m-3" name="perm_read_supplier">
                            @else
                            <input type="checkbox" class="m-3" name="perm_read_supplier">
                            @endif
                            <label for="">Permission to read supplier info </label>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            @if (old('perm_write_supplier'))
                            
                            <input type="checkbox" checked class="m-3" name="perm_write_supplier">
                            @else
                            
                            <input type="checkbox" class="m-3" name="perm_write_supplier">
                            @endif
                            <label for="">Permission to write supplier info </label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group m-3">
                            <label for=""> .</label>
                            <button type="submit" class="btn btn-primary form-control">Add staff</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>
@endsection
