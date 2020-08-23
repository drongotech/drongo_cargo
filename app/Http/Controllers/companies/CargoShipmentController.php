<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\models\companies\CargoShipmentModel;
use App\models\companies\ShipmentItemsModel;
use App\models\products\QRCodesModel;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View as FacadesView;
use Milon\Barcode\DNS1D;
use Mpdf\Mpdf;

class CargoShipmentController extends Controller
{
    public function getItemWithTrackingNumber(Request $request)
    {
        $shipment = CargoShipmentModel::where([
            ["tracking_number", $request->tracking_number]
        ])->get();
        if ($shipment == null || $shipment->count() <= 0)
            return $this->jsonRespnse(false, "There is no shipment with the given tracking number");

        $shipment = $shipment[0];
        $shipment->date_created = $shipment->created_at->format('y-m-d');
        $shipment->date_updated = $shipment->updated_at->format('y-m-d');
        $shipment->items;
        $shipment->status = $shipment->statusTrack($shipment->track_status);
        return $this->jsonRespnse(true, null, $shipment);
    }
    public function getShipmentDetails(Request $request, $id, $tracking_number)
    {
        $company = $request->company;
        $shipment = CargoShipmentModel::where([
            ["id", $id],
            ["tracking_number", $tracking_number]
        ])->get();

        if ($shipment == null || $shipment->count() <= 0) {
            abort(404);
        }

        $shipment = $shipment[0];
        if ($shipment->company_id != $company->id)
            abort(403);


        return view('cargo_companies.shipment_details', compact('shipment', 'company'));
    }

    public function latestShipmentsView(Request $request)
    {
        $company = $request->company;
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token]
        ])->get();

        return view('cargo_companies.latest_shipments', compact('shipments', 'company'));
    }
    public function deliveredtShipmentsView(Request $request)
    {
        $company = $request->company;
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["track_status", 80], //delivered status
        ])->get();

        return view('cargo_companies.delivered_shipments', compact('shipments', 'company'));
    }
    public function viewShipmentDetails(Request $request, $id, $tracking_number)
    {
        $company = $request->company;
        $shipment = CargoShipmentModel::where([
            ["id", $id],
            ["tracking_number", $tracking_number]
        ])->get();

        if ($shipment == null || $shipment->count() <= 0) {
            abort(404);
        }

        $shipment = $shipment[0];
        if ($shipment->company_id != $company->id)
            abort(403);

        // $mpdf = new Mpdf();


        return view('cargo_companies.view_shipment', compact('shipment', 'company'));
    }
    public function latestShipments(Request $request)
    {
        $company = $request->company;
        $one_month = Carbon::now()->subMonth();
        $latest_shipments = CargoShipmentModel::where([
            ["created_at", ">=", $one_month],
            ["company_id", $company->id],
            ["company_token", $company->company_token]
        ])->whereHas('items')->latest()->get();
    }
    //

    public function getTodaysItems(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["created_at", ">=", $one_day]
        ])->latest()->get();
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        return $this->jsonRespnse(true, null, $shipments);
    }

    public function getTodaysItemsPDF(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["created_at", ">=", $one_day]
        ])->latest()->get();
        if ($shipments == null || $shipments->count() <= 0)
            return $this->jsonRespnse(false, "There are no shipments at this time");
        // return $shipments;
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        $path =  'storage/uploads/items/today/' . $company->company_token . '/';
        $mpdf = new Mpdf(["tempDir" => $path]);
        $filename = "item_" . time() . "_shipments.pdf";
        $mpdf->WriteHTML($html = view('cargo_companies.shipment_list_pdf', compact('shipments'))->render());
        $mpdf->Output($path . $filename, \Mpdf\Output\Destination::FILE);

        $data = ["url" => env('APP_URL') . $path . $filename];
        return $this->jsonRespnse(true, null, $data);
    }

    public function getLatestItemsPDF(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["track_status", "!=", 80]
        ])->latest()->get();
        if ($shipments == null || $shipments->count() <= 0)
            return $this->jsonRespnse(false, "There are no shipments at this time");
        // return $shipments;
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        $path =  'storage/uploads/items/today/' . $company->company_token . '/';
        $mpdf = new Mpdf(["tempDir" => $path]);

        $filename = "item_" . time() . "_shipments.pdf";
        $mpdf->WriteHTML($html = view('cargo_companies.shipment_list_pdf', compact('shipments'))->render());
        $mpdf->Output($path . $filename, \Mpdf\Output\Destination::FILE);

        $data = ["url" => env('APP_URL') . $path . $filename];
        return $this->jsonRespnse(true, null, $data);
    }

    public function getDeliveredItemsPDF(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["track_status", 80]
        ])->latest()->get();
        if ($shipments == null || $shipments->count() <= 0)
            return $this->jsonRespnse(false, "There are no shipments at this time");
        // return $shipments;
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        $path =  'storage/uploads/items/today/' . $company->company_token . '/';
        $mpdf = new Mpdf(["tempDir" => $path]);

        $filename = "item_" . time() . "_shipments.pdf";
        $mpdf->WriteHTML($html = view('cargo_companies.shipment_list_pdf', compact('shipments'))->render());
        $mpdf->Output($path . $filename, \Mpdf\Output\Destination::FILE);

        $data = ["url" => env('APP_URL') . $path . $filename];
        return $this->jsonRespnse(true, null, $data);
    }

    public function getLatestItems(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $shipments = CargoShipmentModel::where([
            ["company_id", $company->id],
            ["company_token", $company->company_token],
            ["track_status", "!=", 80]
        ])->latest()->get();
        foreach ($shipments as $key => $shipment) {
            $shipments[$key]->date_created = $shipment->created_at->format('y-m-d');
            $shipments[$key]->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->items;
            $shipments[$key]->status = $shipment->statusTrack($shipment->track_status);
        }
        return $this->jsonRespnse(true, null, $shipments);
    }
    public function addNewShipment(Request $request)
    {
        $company = $request->company;

        $rules = [
            "customer_name" => "required|string|max:255",
            "customer_phone" => "required|string|max:255",
            "city_of_origin" => "required|string|max:255",
            "country_of_origin" => "required|string|max:255",
            "destination_city" => "required|string|max:255",
            "destination_country" => "required|string|max:255",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->all());
        }

        $data = $validator->validated();

        // return $data;
        try {
            $d = new DNS1D();
            $d->setStorPath('/qrcodes/cache/');
            $QRCodeModel = new QRCodesModel();
            $code =  $QRCodeModel->generateCode();
            $image =  base64_decode($d->getBarcodePNG($code, 'C39', 1, 45));
            $imageurl = '/qrcodes/cache/qrcode_' . (time()) . '.png';
            Storage::disk('public')->put($imageurl, $image);
            $new_qrcode = $QRCodeModel->saveQRCode(env('APP_URL') . '/storage/' . $imageurl, $company->id, $code);
            if ($new_qrcode == false) {
                throw new Exception("QR code generation failed " . $QRCodeModel->errorMessage, 1);
            }
            $ShipmentModel = new CargoShipmentModel();
            $data["tracking_number"] = $code;
            $new_shipment = $ShipmentModel->addNewShipment($data, $company);
            if ($new_shipment) {
                return $this->jsonRespnse(true, null, $new_shipment);
            }
            return $this->jsonRespnse(false, $ShipmentModel->errorMessage);
        } catch (\Throwable $th) {
            return $this->jsonRespnse(false, $th->getMessage());
            // return Redirect::back()->withErrors(['qr_code_quantity' => $th->getMessage()]);
        }
    }

    public function getLatestDelievered(Request $request)
    {
        $company = $request->company;

        $shipments = CargoShipmentModel::where([
            ["company_token", $company->company_token],
            ["company_id", $company->id],
            ["track_status", 80]
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
            "item_quantity" => "required|numeric|min:1",
            "item_unit" => "required|string|max:30",
            "item_cpm" => "required|numeric",
            "item_remarks" => "required|string|max:255",
            "item_supplier" => "required|string|max:255"
        ];


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


        try {
            $d = new DNS1D();
            $d->setStorPath('/qrcodes/cache/');
            $QRCodeModel = new QRCodesModel();
            $code =  $QRCodeModel->generateCode();
            $image =  base64_decode($d->getBarcodePNG($code, 'C39', 1, 45));
            $imageurl = '/qrcodes/cache/qrcode_' . (time()) . '.png';
            Storage::disk('public')->put($imageurl, $image);
            $new_qrcode = $QRCodeModel->saveQRCode(env('APP_URL') . '/storage/' . $imageurl, $company->id, $code, 2);
            if ($new_qrcode == false) {
                throw new Exception("QR code generation failed " . $QRCodeModel->errorMessage, 1);
            }
            $ItemModel = new ShipmentItemsModel();
            $data = $validator->validated();
            $data["item_tracking_number"] = $code;
            $new_item = $ItemModel->addNewItem($data);
            $shipment->date_created = $shipment->created_at->format('y-m-d');
            $shipment->date_updated = $shipment->updated_at->format('y-m-d');
            $shipment->status = $shipment->statusTrack($shipment->track_status);
            if ($new_item) {
                $shipment->items;
                return $this->jsonRespnse(true, null, $shipment);
            } else {
                $shipment->delete();
                return $this->jsonRespnse(false, $ItemModel->errorMessage);
            }
        } catch (\Throwable $th) {
            $shipment->delete();
            return $this->jsonRespnse(false, $th->getMessage());
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
