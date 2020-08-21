<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Drongo Technology</title>
    <style>
        .tableCustomer {
            width: 100%;
            border: thin solid gray;
        }

        .theadCustomer {
            background-color: lightgray;
            color: black;
            text-align: left;
            padding: 10px;
        }

        .theadCustomer>th,
        .theadItem>th {
            padding: 10px;
            text-align: left;
        }

        .tbodyCustomer>tr .theadItem>tr {
            border: thin solid blue;
            padding: 10px;
        }

        .tbodyCustomer>tr>td,
        .tbodyItem>tr>td {
            padding: 10px;
        }

        .tableItem {
            margin-top: 20px;
            border: thin solid blue;
            width: 100%;
        }

        .theadItem {
            background-color: lightblue;
            text-align: left;
        }

        .tbodyItem>tr>td:nth-child(1) {
            width: 10%;
        }

        .tbodyItem>tr>td:nth-child(2) {
            width: 20%;
        }

        .tbodyItem>tr>td:nth-child(3),
        .tbodyItem>tr>td:nth-child(4) {
            width: 10%;
        }

        .tbodyItem>tr>td:nth-child(5) {
            width: 20%;
        }

        .tbodyItem>tr>td:nth-child(6) {
            width: 30%;
        }

        .footerNote {
            margin-top: 50px;
        }

    </style>
</head>

<body>
    <div>
        <h3>
            Iley Cargo Company
        </h3>
    </div>
    <div>
        <div style="margin-top: 10px;">
            Located at : Guanzhou, China
        </div>



    </div>

    @foreach ($shipments as $shipment)
    <div style="margin-top: 10px;">
        {{$shipment->created_at}}
    </div>
    <table class="tableCustomer">
        <tr class="theadCustomer" style="text-algin:left;">

            <th style="text-align: left; padding:10px;">
                Customer name

            </th>
            <th style="text-align: left; padding:10px;">
                Customer phone

            </th>
            <th style="text-align: left; padding:10px;">
                From:

            </th>
            <th style="text-align: left; padding:10px;">
                To:

            </th>

        </tr>
        <tbody class="tbodyCustomer">
            <tr>
                <td style="text-align: left; padding:10px;">
                    {{$shipment->customer_name}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$shipment->customer_phone}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$shipment->city_of_origin}}, {{$shipment->country_of_country}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$shipment->destination_city}}, {{$shipment->destination_country}}
                </td>
            </tr>
        </tbody>
    </table>


    @php
    $items = $shipment->items;
    @endphp

    
    <table class="tableItem">
        <tr class="theadItem" style="text-align: left;">
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    Unit
                </div>

            </th>
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    Item name
                </div>

            </th>
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    Quantity
                </div>

            </th>
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    CPM
                </div>

            </th>
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    Supplier
                </div>

            </th>
            <th style="text-align: left; padding:10px;">
                <div class="itemLable">
                    Remarks
                </div>

            </th>
        </tr>
        @foreach ($items as $item)
        <tbody class="tbodyItem">
            <tr>
                <td style="text-align: left; padding:10px;">
                    {{$item->item_unit}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$item->item_name}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$item->item_quantity}}
                </td>
                <td>
                    {{$item->item_cpm}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$item->item_supplier}}
                </td>
                <td style="text-align: left; padding:10px;">
                    {{$item->item_remarks}}
                </td>

            </tr>

        </tbody>
        @endforeach
    </table>
    

    @endforeach

    <footer class="footerNote">
        Generated from Drongo Technology Cargo System
    </footer>

</body>

</html>
