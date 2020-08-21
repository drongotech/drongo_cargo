<?php

namespace App\models\companies;

use App\models\products\QRCodesModel;
use Illuminate\Database\Eloquent\Model;

class ShipmentItemsModel extends Model
{
    //
    protected $table = "shipment_items";

    protected $fillable = [
        "track_id",
        "item_tracking_number",
        "item_name",
        "item_number",
        "item_quantity",
        "item_unit",
        "item_cpm",
        "item_supplier",
        "item_remarks",
    ];

    public $errorMessage;

    public function addNewItem($data)
    {
        try {
            return $this->create([
                "track_id" => $data["item_track_id"],
                "item_tracking_number" => $data["item_tracking_number"],
                "item_name" => $data["item_name"],
                "item_number" => "DTS_" . $this->getShipCount(),
                "item_quantity" => $data["item_quantity"],
                "item_unit" => $data["item_unit"],
                "item_cpm" => $data["item_cpm"],
                "item_supplier" => $data["item_supplier"],
                "item_remarks" => $data["item_remarks"],

            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function getShipCount()
    {
        return $this->all()->count();
    }

    public function qrcode()
    {
        return $this->hasOne(QRCodesModel::class, 'qrcode', 'item_tracking_number');
    }
}
