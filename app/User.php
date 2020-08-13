<?php

namespace App;

use App\models\admin\AdminsModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Permissions()
    {
        return $this->hasOne(AdminsModel::class, 'admin_id', 'id');
    }

    public $errorMessage = null;

    public function isAdmin(Request $request)
    {
        $AdminModel = new AdminsModel();
        if ($AdminModel->get()->count() <= 0) {
            $new_admin = $AdminModel->initAdmin($request);
            if ($new_admin == false) {
                $this->errorMessage = $AdminModel->errorMessage;
                return false;
            }
        }
        return $this->Permissions != null && $this->Permissions->count() > 0;
    }
}
