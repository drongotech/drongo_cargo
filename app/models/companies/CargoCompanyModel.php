<?php

namespace App\models\companies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CargoCompanyModel extends Model
{
    use Notifiable;
    //
    protected $table = "cargo_companies";

    protected $hidden = [
        "company_pincode"
    ];
    protected $fillable = [
        "company_token",
        "company_name",
        "company_logo",
        "company_phone",
        "company_email",
        "company_city",
        "company_country",
        "company_location",
        "company_listed",
        "company_pincode",
        "company_added_by",
    ];

    public $errorMessage = null;

    protected $countries = [
        "China",
        "United Arab Emirates"
    ];

    public $pincode;
    public function addCompany($data)
    {
        try {
            $company_token = hash('md5', time());
            $this->pincode = Str::random(6);

            return $this->create([
                "company_token"  => $company_token,
                "company_name" => $data["company_name"],
                "company_phone" => $data["company_phone"],
                "company_email" => $data["company_email"],
                "company_city" => $data["company_city"],
                "company_country" => $data["company_country"],
                "company_location" => $data["company_address"],
                "company_listed" => true,
                "company_pincode" => Crypt::encrypt($this->pincode),
                "company_added_by" => $data["user_id"],

            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }
    public function routeNotificationForMail($notification)
    {
        return $this->company_email;
    }

    public function getCountryName()
    {
        try {
            return $this->countries[$this->company_country - 1];
        } catch (\Throwable $th) {
            return 'Unknown';
        }
    }
}
