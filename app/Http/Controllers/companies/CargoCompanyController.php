<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\models\companies\CargoCompanyModel;
use App\models\companies\CargoShipmentModel;
use App\Notifications\NewCargoCompanyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Validator;

class CargoCompanyController extends Controller
{
    //
    public function openIndexPage(Request $request)
    {
        $company = $request->company;
        $one_day = Carbon::now()->subDay();
        $latest_shipments = CargoShipmentModel::where([
            ["created_at", ">=", $one_day],
            ["company_id", $company->id],
            ["company_token", $company->company_token]
        ])->whereHas('items')->latest()->get();
        return view('welcome', compact('company', 'latest_shipments'));
    }
    public function openNewCargoCompanyFormPage(Request $request)
    {
        $user = $request->user();

        return view('cargo_companies.new_company_form');
    }


    public function viewListCargoCompanies(Request $request)
    {
        $companies = CargoCompanyModel::all();

        return view('cargo_companies.list_companies', compact('companies'));
    }

    public function loginPage(Request $request)
    {
        if ($request->cookie('cc_cookie') != null) {
            // return 'not logged in';
            return redirect()->route('welcome');
        }
        return view('auth.comp_login');
    }

    //

    public function loginCompany(Request $request)
    {
        if ($request->cookie('cc_cookie') != null) {
            // return 'not logged in';
            return redirect()->route('welcome');
        }
        $rules = [
            "company_email" => "required|email|max:255",
            "company_pincode" => "required|string|max:255",
        ];


        $data =  $request->validate($rules);
        $company = CargoCompanyModel::where([
            ["company_email", $data["company_email"]]
        ])->get();

        if ($company == null || $company->count() <= 0) {
            return Redirect::back()->withErrors(['errorMessage' => "Invalid email or company pincode"]);
        }

        if (Crypt::decrypt($company[0]->company_pincode) != ($data["company_pincode"])) {
            return Redirect::back()->withErrors(['errorMessage' => "Invalid company or email pincode "]);
        }

        // $response = new Response('set cookies');
        // $response->withCookie(cookie('cc_cookie', $company[0]->company_token, 60 * 24 * 365));

        Cookie::queue('cc_cookie', $company[0]->company_token, 60 * 24 * 365);
        return redirect()->route('welcome');
    }

    public function addNewCargoCompany(Request $request)
    {
        $user = $request->user();

        $rules = [
            "company_name" => "required|string|max:75|min:15|unique:cargo_companies,company_name",
            "company_phone" => "required|string|max:25|min:6|unique:cargo_companies,company_phone",
            "company_email" => "required|email|max:75|min:3|unique:cargo_companies,company_email",
            "company_city" => "required|string|min:3|max:75",
            "company_country" => "required|integer|in:1,2",
            "company_address" => "nullable|string|max:255",
        ];

        $data = $request->validate($rules);

        $data["user_id"] = $user->id;
        $CargoCompanyModel = new CargoCompanyModel();
        $new_company = $CargoCompanyModel->addCompany($data);
        if ($new_company) {
            $new_company->notify(new NewCargoCompanyNotification($new_company));
            return Redirect::back()->with('success', 'successfully added new company');
        }

        return Redirect::back()->withErrors(['errorMessage' => 'Error: ' . $CargoCompanyModel->errorMessage]);
    }

    public function authenticateCompany(Request $request)
    {
        $rules = [
            "email" => "required|email|max:255",
            "pincode" => "required|string|max:8",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->jsonRespnse(false, $validator->errors()->first());
        }

        $data = $validator->validated();
        $company = CargoCompanyModel::where([
            ["company_email", $data["email"]]
        ])->get();

        if ($company == null || $company->count() <= 0) {
            return $this->jsonRespnse(false, "Invalid email or company pincode");
        }

        if (Crypt::decrypt($company[0]->company_pincode) != ($data["pincode"])) {
            return $this->jsonRespnse(
                false,
                "Invalid company or email pincode "
            );
        }

        return $this->jsonRespnse(true, null, $company[0]);
    }

    public function logoutCompany(Request $request)
    {

        return redirect::back()->withCookie(Cookie::forget('cc_cookie'));
    }

    public function jsonRespnse($status, $errorMessage, $data = [])
    {
        return FacadesResponse::json([
            "isSuccess" => $status,
            "errorMessage" => $errorMessage,
            "data" => $data,
        ]);
    }
}
