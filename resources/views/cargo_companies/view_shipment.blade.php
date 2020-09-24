<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> DRONGO - CTS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Barashada Diinta Islaamka" name="description" />
    <meta content="Drongo Technology" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    @yield('links')

</head>

<body data-layout="detached" data-topbar="colored">

    <div class="container">
        @php
        $items = $shipment->items;
        @endphp
        <div class="row">
            {{-- <div class="col-md-4 col-lg-4"></div> --}}
            <div class="col-md-12 col-lg-12" >
                {{-- <div class="row"> --}}
                @foreach ($items as $item)

                <div class="row">
                    <div class="card" style="width:100%">
                        <div class="card-header font-size-24">
                            Shipment qrcode
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="card" style="width: 100%">
                                    <div class="card-header text-dark text-center font-size-24">
                                        {{$company->company_name}}
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="row text-dark text-center mb-3 font-size-24">
                                            <i class="fas fa-list-ol mr-3"></i>
                                            {{$shipment->items->count()}} Item(s)
                                        </div>
                                        <div class="row text-dark text-center font-size-24">
                                            <i class="fas fa-plane-arrival mr-2"></i>
                                            {{$shipment->destination_city}}, {{$shipment->destination_country}}
                                        </div>
                                        <div class="row mt-4 mb-4 text-center" style="width: 100%">
                                            <img src="{{$item->qrcode->qrcode_image}}" width="100%" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width:100%">
                        <div class="card-header font-size-24">
                            Item qrcode
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="card" style="width: 100%">
                                    <div class="card-header text-dark text-center font-size-24">
                                        {{$item->item_unit}} {{$item->item_name}}
                                    </div>
                                    <div class="card-body text-center font-size-24">
                                        <div class="row text-dark">
                                            {{$company->company_name}}
                                        </div>
                                        <div class="row mt-4 mb-4 text-center" >
                                            <img src="{{$item->qrcode->qrcode_image}}" width="100%" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                {{-- </div> --}}
            </div>
            {{-- <div class="col-md-4 col-lg-4"></div> --}}
        </div>

    </div>

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>

    @yield('scripts')
    <!-- App js -->
    <script src="/assets/js/app.js"></script>

</body>

</html>
