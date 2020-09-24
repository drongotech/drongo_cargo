@extends('layouts.cargo_layout')

@section('pageTitle')
Staff List
@endsection

@section('parentPage')
Companies
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 col-lg-10">
        
        <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>phone</th>
                                                <th>Is Active</th>
                                            </tr>
                                        </thead>

                                        
                                        <tbody>
                                            @foreach ($stafflist as $staff)
                                                <tr>
                                                <td>
                                                    <a href="/cargo/staff/{{$staff->id}}">
                                                        {{$staff->staff_name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="/cargo/staff/{{$staff->id}}">
                                                        {{$staff->staff_email}}
                                                    </a>
                                                </td>
                                                <td>{{$staff->staff_phone}}</td>
                                                <td>
                                                    @if ($staff->is_active)
                                                        <i class="fas fa-check-circle"></i> Is active
                                                    @else
                                                        
                                                        <i class="fas fa-times-circle"></i> not active
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>

    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection


@section('scripts')
    <!-- Required datatable js -->
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Buttons examples -->
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/libs/jszip/jszip.min.js"></script>
    <script src="/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection

@section('links')
    
    <!-- DataTables -->
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection