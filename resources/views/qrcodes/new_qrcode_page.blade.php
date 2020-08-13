@extends('layouts.mainlayout')

@section('content')

<div class="row">
    <div class="col-md-3 col-lg-3"></div>
    <div class="col-md-6 col-lg-6">
        <form action="" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    Generating QR Codes
                </div>
                <div class="card-body">
                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}} 
                    </div>
                    @endif
                    @error('qr_code_quantity')
                    <div class="alert alert-danger">
                        {{$message}} 
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="">Number of QR codes</label>
                        <input type="number" min="10" name="qr_code_quantity" class="form-control" value="10">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary">Generate QR Codes</button>
                </div>
            </div>
        </form>

    </div>
    <div class="col-md-3 col-lg-3"></div>
</div>

@endsection

@section('pageTitle')
Dashboard
@endsection

@section('parentPage')
Home
@endsection
