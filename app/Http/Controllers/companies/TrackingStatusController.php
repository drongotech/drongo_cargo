<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\models\companies\CargoShipmentModel;
use App\models\companies\TrackingStatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TrackingStatusController extends Controller
{
    //

    public function updateStatus(Request $request, $status)
    {

        if ($status == 20) {
            $rules = [
                "tracking_number" => "required|integer|exists:cargo_shipments,tracking_number",
                "container_number" => "nullable|string|max:25",
                "loaded_port" => "required|string|max:255"
            ];
        } else if ($status == 40) {
            $rules = [
                "tracking_number" => "required|integer|exists:cargo_shipments,tracking_number",
                "offloaded_port" => "required|string|max:255"
            ];
        } else if ($status == 80) {
            $rules = [
                "tracking_number" => "required|integer|exists:cargo_shipments,tracking_number",
                "delivered_by" => "required|string|max:255"
            ];
        } else {
            return $this->jsonRespnse(false, "The given status is not valid");
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors());
        }
        $shipment = CargoShipmentModel::where([
            ["tracking_number", $request->tracking_number]
        ])->get();

        if ($shipment == null || $shipment->count() <= 0) {
            return $this->jsonRespnse(false, "The given shipment could not be found");
        }

        $shipment = $shipment[0];
        if ($shipment->track_status >= $status) {
            return $this->jsonRespnse(false, "Cannot update the shipment with the given status. Invalid status");
        }

        $TrackerModel = new TrackingStatusModel();
        $new_status = $TrackerModel->updateStatus(
            $request->tracking_number,
            $status,
            $request->loaded_port,
            $request->container_number,
            $request->offloaded_port,
            $request->delivered_by
        );


        if ($new_status) {
            $shipment->update(["track_status" => $status]);
            $shipment = CargoShipmentModel::where([
                ["tracking_number", $request->tracking_number]
            ])->get()[0];

            $shipment->date_created = $shipment->created_at->format('y-m-d');
            $shipment->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->status = $shipment->statusTrack($shipment->track_status);
            $shipment->items;
            return $this->jsonRespnse(true, null, $shipment);
        }
        return $this->jsonRespnse(false, $TrackerModel->errorMessage);
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
