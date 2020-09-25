@extends('layouts.cargo_layout')

@section('pageTitle')
New staff
@endsection

@section('parentPage')
Company profile
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                Company profile
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                        <div class="row text-center border border-darken-4 p-2">
                            @if ($company->company_logo == null)
                                <img src="/assets/images/add_camera.png" alt="" width="150px" 
                            onclick="document.getElementById('companyProfile').click()">
                            @else
                                <img src="{{$company->company_logo}}" alt="" width="150px" 
                            onclick="document.getElementById('companyProfile').click()">
                            @endif
                            <form action="/cargo/profile/image" method="post" id="companyProfileForm"
                            enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="company_profile" id="companyProfile" style="display: none"
                                onchange="document.getElementById('companyProfileForm').submit()">
                            </form>
                        </div>
                        <div class="hint">Click on the image to update the profile</div>
                    </div>
                    <div class="col-md-8 col-lg-8">
                        @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="">Compay name</label>
                            <input type="text" class="form-control" value="{{$company->company_name}}"
                             name="company_name">
                        </div>
                        <div class="form-group">
                            <label for="">Compay email</label>
                            <input type="text" class="form-control" value="{{$company->company_email}}" 
                            name="company_email">
                        </div>
                        <div class="form-group">
                            <label for="">Compay phone</label>
                            <input type="text" class="form-control" value="{{$company->company_phone}}"
                            name="company_phone">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Compay country</label>
                                <select name="company_country" id="" class="form-control">
                                    @php
                                        $countries = $company->countries;
                                    @endphp
                                    @foreach ($countries as $key => $country)
                                        @if (($key+1) == $company->company_country)
                                        <option value="{{$key+1}}" selected>{{$country}}</option>
                                        @else
                                        <option value="{{$key+1}}">{{$country}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Compay city</label>
                            <input type="text" class="form-control" value="{{$company->company_city}}"
                            name="company_address">
                        </div>
                        <div class="form-group">
                            <label for="">Compay address</label>
                            <input type="text" class="form-control" value="{{$company->company_location}}"
                            name="company_address">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>
@endsection
