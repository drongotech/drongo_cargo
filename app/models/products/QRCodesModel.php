<?php

namespace App\models\products;

use Illuminate\Database\Eloquent\Model;

class QRCodesModel extends Model
{
    //
    protected $table = "qrcodes";

    protected $fillable = [
        "qrcode",
        "qrcode_type",
        "qrcode_image",
        "qrcode_token",
        "qrcode_generated_by",
        "qrcode_used",
    ];

    public $errorMessage = null;
    public function saveQRCode($image_path, $admin, $code, $type = 1)
    {
        try {
            return $this->create([
                "qrcode" => $code,
                "qrcode_image" => $image_path,
                "qrcode_token" => hash('md5', $this->generateCode()),
                "qrcode_generated_by" => $admin,
                "qrcode_type" => $type
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function generateCode()
    {
        $existingCodes = $this->all()->count();
        $code = rand(111111111111, 999999999999) + time();
        $existing = $this->where('qrcode', $code)->exists();
        while ($existing) {
            $code = rand(111111111111, 999999999999) + time();
            $existing = $this->where('qrcode', $code)->exists();
        }
        return $code;
    }
}
