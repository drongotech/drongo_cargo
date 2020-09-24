<?php

namespace App\models\companies;

use Illuminate\Database\Eloquent\Model;

class CompanyStaffModel extends Model
{
    //
    protected $table = 'company_staff';

    protected $fillable = [
        'staff_email',
        'staff_phone',
        'staff_password',
        'staff_name',
        'company_id',
        'company_token',
        'is_active',
        'has_customer_write_perm',
        'has_customer_delete_perm',
        'has_supplier_read_perm',
        'has_supplier_write_perm',
        'has_supplier_delete_perm',
        'has_shipment_read_perm',
        'has_shipment_write_perm',
        'has_shipment_delete_perm'
    ];

    protected $hidden = [
        'staff_password',
        'has_customer_write_perm',
        'has_customer_delete_perm',
        'has_supplier_read_perm',
        'has_supplier_write_perm',
        'has_supplier_delete_perm',
        'has_shipment_read_perm',
        'has_shipment_write_perm',
        'has_shipment_delete_perm'
    ];

    public $errorMessage = null;

    public function addNewStaff($data)
    {
        try {
            return $this->create([
                'staff_email' => $data['staff_email'],
                'staff_phone' => $data['staff_phone'],
                'staff_password' => $data['staff_password'],
                'staff_name' => $data['staff_name'],
                'company_id' => $data['company_id'],
                'company_token' => $data['company_token'],
                'is_active' => true,
                'has_customer_write_perm' => isset($data['has_customer_write_perm']),
                'has_customer_delete_perm' => isset($data['has_customer_delete_perm']),
                'has_supplier_read_perm' => isset($data['has_supplier_read_perm']),
                'has_supplier_write_perm' => isset($data['has_supplier_write_perm']),
                'has_supplier_delete_perm' => isset($data['has_supplier_delete_perm']),
                'has_shipment_read_perm' => isset($data['has_shipment_read_perm']),
                'has_shipment_write_perm' => isset($data['has_shipment_write_perm']),
                'has_shipment_delete_perm' => isset($data['has_shipment_delete_perm'])
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }
}
