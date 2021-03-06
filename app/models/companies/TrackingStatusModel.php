<?php

namespace App\models\companies;

use Illuminate\Database\Eloquent\Model;

class TrackingStatusModel extends Model
{
    //
    protected $table = 'tracking_status';
    protected $fillable = [
        "tracking_number",
        "status",
        "loading_port",
        "container_number",
        "offloaded_port",
        "delivered_by",
    ];

    public $errorMessage = null;

    public function updateStatus($tn, $status, $onport = null, $container = null, $offport, $deliveredby)
    {
        try {
            return $this->create([
                "tracking_number" => $tn,
                "status" => $status,
                "loading_port" => $onport,
                "container_number" => $container,
                "offloaded_port" => $offport,
                "delivered_by" => $deliveredby,
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }
}
