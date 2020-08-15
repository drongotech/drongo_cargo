@extends('layouts.mainlayout')

@section('pageTitle')
New Cargo company
@endsection

@section('parentPage')
Companies
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                Registering new company
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
                    <div class="form-group">
                        <label for="">Compay name</label>
                        <input type="text" class="form-control" placeholder="Enter company name" name="company_name">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Compay phone</label>
                                <input type="text" class="form-control" placeholder="Enter company name" name="company_phone">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Compay email</label>
                                <input type="text" class="form-control" placeholder="Enter company email" name="company_email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Compay city</label>
                                <input type="text" class="form-control" placeholder="Enter company city" name="company_city">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Compay country</label>
                                <select name="company_country" id="" class="form-control">
                                    <option value="1">China</option>
                                    <option value="2">United Arab Emirates</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label for="">Compay address</label>
                                <input type="text" class="form-control" placeholder="Enter company address" name="company_address">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for=""> .</label>
                                <button type="submit" class="btn btn-primary form-control">Add company</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>
@endsection
