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

        $ItemModel = new ShipmentItemsModel();
        $new_item = $ItemModel->addNewItem($validator->validated());
        if ($new_item) {
            return $this->jsonRespnse(true, null, $new_item);
        }
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
