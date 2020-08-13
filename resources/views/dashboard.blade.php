@extends('layouts.mainlayout')

@section('content')
    hello world
    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('4', 'C39+',3,33)}}" alt="barcode"   />

@endsection

@section('pageTitle')
    Dashboard
@endsection

@section('parentPage')
    Home
@endsection