<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\models\companies\CargoCompanyModel;
use App\models\companies\CompanyStaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class CompanyStaffController extends Controller
{
    //

    public function openStaffIndexPage(Request $request)
    {
        $company = $request->company;

        return view('cargo_companies.staff_index', compact('company'));
    }
    public function listStaffToCompany(Request $request)
    {
        $company = $request->company;

        $stafflist = CompanyStaffModel::where([
            ['company_id', $company->id],
            ['company_token', $company->company_token]
        ])->get();

        return view('cargo_companies.staff_list', compact('stafflist', 'company'));
    }

    public function addNewStaffToCompany(Request $request)
    {
        $company = $request->company;
        $rules = [
            "staff_name" => 'required|string|max:255',
            "staff_email" => 'required|string|max:75:unique:company_staff,staff_email',
            "staff_phone" => 'required|string|max:255',
            "staff_password" => 'required|string|max:255',
        ];

        $data = $request->validate($rules);

        $data['company_id'] = $company->id;
        $data['company_token'] = $company->company_token;
        $CompanyStaffModel = new CompanyStaffModel();

        $password = hash('md5', $request->staff_password);
        $data['staff_password'] = $password;
        $is_added = $CompanyStaffModel->addNewStaff($data);

        if ($is_added) {
            return Redirect::back()->with('success', 'added the company staff successful');
        }

        return Redirect::back()->withErrors(['errorMessage' => $CompanyStaffModel->errorMessage]);
    }

    public function viewCompanyStaff(Request $request, $staff_id)
    {
        $company = $request->company;

        $staff = CompanyStaffModel::where([
            ['company_id', $company->id],
            ['company_token', $company->company_token],
            ['id', $staff_id]
        ])->get();

        abort_if($staff == null || $staff->count() <= 0, 404);
        $staff = $staff[0];
        return view('cargo_companies.staff_info', compact('staff', 'company'));
    }
    
    public function deleteCompanyStaff(Request $request, $staff_id)
    {
        $company = $request->company;

        $staff = CompanyStaffModel::where([
            ['company_id', $company->id],
            ['company_token', $company->company_token],
            ['id', $staff_id]
        ])->get();

        abort_if($staff == null || $staff->count() <= 0, 404);
        $staff = $staff[0];
        $staff->delete();
        return Redirect::back()->with('success', 'successfully delete staff '.$staff->staff_name);
        // return view('cargo_companies.staff_info', compact('staff', 'company'));
    }
    public function updateStaffPermission(Request $request, $permission_number, $staff_id)
    {
        $company = $request->company;
        $staff = CompanyStaffModel::where([
            ['company_id', $company->id],
            ['company_token', $company->company_token],
            ['id', $staff_id]
        ])->get();

        $staff = $staff[0];

        if ($staff == null || $staff->count() <= 0)
            return Redirect::back()->withErrors(['errorMessage' => 'The staff could not be verified ']);


        $rules = [
            "permission" => "nullable|in:on",
        ];

        $data = $request->validate($rules);

        $permissions = [
            12, 13, 21, 22, 23, 31, 32, 33,
            //11 is reading customer info, that is automatic set to true
        ];
        if (!in_array($permission_number, $permissions)) {
            return Redirect::back()->withErrors(['errorMessage' => 'The permission is not valid']);
        }

        switch ($permission_number) {
            case 12:
                $staff->update([
                    'has_customer_write_perm' => isset($data['permission'])
                ]);
                break;
            case 13:
                $staff->update([
                    'has_customer_delete_perm' => isset($data['permission'])
                ]);
                break;
            case 21:
                $staff->update([
                    'has_supplier_read_perm' => isset($data['permission'])
                ]);
                break;
            case 22:
                $staff->update([
                    'has_supplier_write_perm' => isset($data['permission'])
                ]);
                break;
            case 23:
                $staff->update([
                    'has_supplier_delete_perm' => isset($data['permission'])
                ]);
                break;
            case 31:
                $staff->update([
                    'has_shipment_read_perm' => isset($data['permission'])
                ]);
                break;
            case 32:
                $staff->update([
                    'has_shipment_write_perm' => isset($data['permission'])
                ]);
                break;
            case 33:
                $staff->update([
                    'has_shipment_delete_perm' => isset($data['permission'])
                ]);
                break;

            default:
                return Redirect::back()->withErrors(['errorMessage' => 'The permission is not valid']);
        }
        return Redirect::back()->with('success', 'successfully updated staff permission');
    }


    //api

    public function AuthenticatedStaff(Request $request)
    {

        $rules = [
            "email" => "required|email|max:255",

            "password" => "required|string|max:8",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->first());
        }

        $data = $validator->validated();


        $staff = CompanyStaffModel::where([
            ['staff_email', $request->email],
            ['staff_password', hash('md5', $request->password)]
        ])->get();
        if ($staff == null || $staff->count() <= 0)
            return $this->jsonRespnse(false, "Invalid password or email ");

        $staff = $staff[0];
        $company = CargoCompanyModel::where([
            ["id", $staff->company_id],
            ['company_token', $staff->company_token]
        ])->get();

        if ($company == null || $company->count() <= 0) {
            return $this->jsonRespnse(false, "Could not find your company information");
        }

        return $this->jsonRespnse(true, null, ['company' => $company[0], 'staff' => $staff]);
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
