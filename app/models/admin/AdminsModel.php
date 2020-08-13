<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminsModel extends Model
{
    //
    protected $table = "admins";

    protected $fillable = [
        "admin_id",
        "admin_qrcode_permissions",
        "admin_user_permissions",
        "admin_product_permissions",
        "admin_tracking_permissions"
    ];

    public $perm_none = 0;
    public $perm_read = 10;
    public $perm_write = 20;
    public $perm_activate = 40;
    public $Perm_deactivate = 80;
    public $perm_delete = 160;
    public $perm_super = 320;

    public $errorMessage = null;
    public function initAdmin(Request $request)
    {
        try {
            return $this->create([
                "admin_id" => $request->user()->id,
                "admin_qrcode_permissions" => $this->perm_super,
                "admin_user_permissions" => $this->perm_super,
                "admin_product_permissions" => $this->perm_super,
                "admin_tracking_permissions" => $this->perm_super
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }
}
