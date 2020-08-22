<?php

namespace App\models\companies;

use App\models\products\QRCodesModel;
use Illuminate\Database\Eloquent\Model;

class CargoShipmentModel extends Model
{
    //
    protected $table = "cargo_shipments";

    protected $fillable = [
        "tracking_number",
        "customer_name",
        "customer_phone",
        "city_of_origin",
        "country_of_origin",
        "destination_city",
        "destination_country",
        "company_token",
        "company_id",
        "track_status"
    ];
    protected $timeformat = "Y-m-d";

    public $status_received = 10;
    public $status_loaded = 20;
    public $status_offloaded = 40;
    public $status_delivered = 80;

    public $errorMessage = null;
    public function addNewShipment($data, $company)
    {
        try {
            $this->errorMessage = null;
            return  $this->create([
                "tracking_number" => $data["tracking_number"],
                "customer_name" => $data["customer_name"],
                "customer_phone" => $data["customer_phone"],
                "city_of_origin" => $data["city_of_origin"],
                "country_of_origin" => $data["country_of_origin"],
                "destination_city" => $data["destination_city"],
                "destination_country" => $data["destination_country"],
                "company_token" => $company->company_token,
                "company_id" => $company->id,
                "track_status" => $this->status_received
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function items()
    {
        return $this->hasMany(ShipmentItemsModel::class, 'track_id', 'id');
    }

    public function statusTrack($status)
    {
        if ($status == $this->status_received) {
            return [
                "status_string" => "Recieved",
                "status_date" => $this->updated_at->format('Y-m-d'),
                "status" => $this->track_status,
            ];
        } else if ($status == $this->status_loaded) {
            return [
                "status_string" => "Loaded",
                "port" => $this->shipmentStatus->where('status', $status)->last()->loading_port,
                "loaded_port" => $this->shipmentStatus->where('status', $status)->last()->loading_port,
                "container" => $this->shipmentStatus->where('status', $status)->last()->container_number,
                "status_date" => $this->updated_at->format('Y-m-d'),
                "loaded_date" => $this->updated_at->format('Y-m-d'),
                "status" => $this->track_status,
            ];
        } else if ($status == $this->status_offloaded) {
            return [
                "status_string" => "offloaded",
                "port" => $this->shipmentStatus->where('status', $status)->last()->offloaded_port,
                "loaded_port" => $this->shipmentStatus->where('status', $this->status_loaded)->last()->loading_port,
                "offloaded_port" => $this->shipmentStatus->where('status', $status)->last()->offloaded_port,
                "status_date" => $this->updated_at->format('Y-m-d'),
                "offloaded_date" => $this->updated_at->format('Y-m-d'),
                "loaded_date" => $this->shipmentStatus->where('status', $this->status_loaded)->last()->created_at->format('Y-m-d'),
                "status" => $this->track_status,
            ];
        } else if ($status == $this->status_delivered) {
            return [
                "status_string" => "Delivered",
                "by" => $this->shipmentStatus->where('status', $status)->last()->delivered_by,
                "loaded_port" => $this->shipmentStatus->where('status', $this->status_loaded)->last()->loading_port,
                "offloaded_port" => $this->shipmentStatus->where('status', $this->status_offloaded)->last()->offloaded_port,
                "loaded_date" => $this->shipmentStatus->where('status', $this->status_loaded)->last()->created_at->format('Y-m-d'),
                "offloaded_date" => $this->shipmentStatus->where('status', $this->status_offloaded)->last()->created_at->format('Y-m-d'),
                "status_date" => $this->updated_at->format('Y-m-d'),
                "status" => $this->track_status,
            ];
        } else {
            return [
                "status_string" => "Unknown",
                "status_date" => $this->updated_at->format('Y-m-d'),
                "status" => $this->track_status,
            ];
        }
    }
    public function shipmentStatus()
    {
        return $this->hasMany(TrackingStatusModel::class, 'tracking_number', 'tracking_number');
    }

    public function qrcode()
    {
        return $this->hasOne(QRCodesModel::class, 'qrcode', 'tracking_number');
    }
}
