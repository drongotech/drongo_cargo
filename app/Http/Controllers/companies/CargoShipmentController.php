<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\models\companies\CargoShipmentModel;
use App\models\companies\ShipmentItemsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CargoShipmentController extends Controller
{
    //
    public function addNewShipment(Request $request)
    {
        $company = $request->company;

        $rules = [
            "tracking_number"  => "required|integer|exists:qrcodes,qrcode|unique:cargo_shipments,tracking_number",
            "customer_name" => "required|string|max:255",
            "city_of_origin" => "required|string|max:255",
            "country_of_origin" => "required|string|max:255",
            "destination_city" => "required|string|max:255",
            "destination_country" => "required|string|max:255",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->all());
        }

        $ShipmentModel = new CargoShipmentModel();
        $new_shipment = $ShipmentModel->addNewShipment($validator->validated(), $company);
        if ($new_shipment) {
            return $this->jsonRespnse(true, null, $new_shipment);
        }

        return $this->jsonRespnse(false, $ShipmentModel->errorMessage);
    }

    public function getLatestDelievered(Request $request)
    {
        $company = $request->company;

        $shipments = CargoShipmentModel::where([
            ["company_token", $company->company_token],
            ["company_id", $company->id]
        ])->get();
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        return $this->jsonRespnse(true, null, $shipments);
    }

    public function addShipmentItem(Request $request)
    {
        $company = $request->company;

        $rules = [
            "item_track_id" => "required|integer|exists:cargo_shipments,id",
            "item_name" => "required|string|max:255",
            "item_quantity" => "required|numeric",
            "item_unit" => "required|string|max:30",
            "item_cpm" => "required|numeric",
            "item_remarks" => "required|string|max:255",
            "item_supplier" => "required|string|max:255"
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->all());
        }
        $shipment = CargoShipmentModel::where("id", $request->item_track_id)->get();
        if ($shipment == null || $shipment->count() <= 0) {
            return $this->jsonRespnse(false, ["Could not get the shipment tracker"]);
        }

        if ($shipment[0]->company_id != $company->id) {
            return $this->jsonRespnse(false, ["The shipment company and the tracker are not a match"]);
        }
        $shipment = $shipment[0];

        $ItemModel = new ShipmentItemsModel();
        $new_item = $ItemModel->addNewItem($validator->validated());
        $shipment->date_created = $shipment->created_at->format('y-m-d');
        $shipment->date_updated = $shipment->updated_at->format('y-m-d');
        $shipment->status = $shipment->statusTrack($shipment->track_status);
        if ($new_item) {
            $shipment->items;
            return $this->jsonRespnse(true, null, $shipment);
        } else {
            return $this->jsonRespnse(false, $ItemModel->errorMessage);
        }
    }

    public function getShipmentTrackStatus(Request $request)
    {
        $rules = [
            "tracking_number" => "required|integer|exists:qrcodes,qrcode",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->all());
        }

        $shipment = CargoShipmentModel::where("tracking_number", $request->tracking_number)->get();
        if ($shipment == null || $shipment->count() <= 0) {
            return $this->jsonRespnse(false, ["Could not get the shipment tracker"]);
        }

        $shipment = $shipment[0];
        $shipment->date_created = $shipment->created_at->format('y-m-d');
        $shipment->date_updated = $shipment->updated_at->format('y-m-d');
        $shipment->status = $shipment->statusTrack($shipment->track_status);
        $shipment->items;

        return $this->jsonRespnse(true, null, $shipment);
    }

    public function getGivenDateShipments(Request $request)
    {
        $rules = [
            "timestamp" => "required|date",
            "delivered" => "required|boolean",
            "in_route" => "required|boolean",
        ];

        $company = $request->company;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->all());
        }
        $delivered_status = -1;
        $in_route_status = -1;
        if ($request->delivered) {
            $status = 10;
        }
        if ($request->in_route) {
            $in_route_status = 10;
        }
        $shipments = CargoShipmentModel::whereDate('created_at', '=', $request->timestamp)
            ->where([
                ["company_token", $company->company_token],
                ["company_id", $company->id],
                ["track_status", '>=', $delivered_status]
            ])->orWhere([
                ["company_token", $company->company_token],
                ["company_id", $company->id],
                ["track_status", '>=', $in_route_status]
            ])->whereDate('created_at', '=', $request->timestamp)->get();

        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        return $this->jsonRespnse(true, null, $shipments);
    }

    public function jsonRespnse($status, $errorMessage, $data = [])
    {
        return Response::json([
            "isSuccess" => $status,
            "errorMessage" => $errorMessage,
            "data" => $data,
        ]);
    }
}
