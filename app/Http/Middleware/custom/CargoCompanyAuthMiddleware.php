<?php

namespace App\Http\Middleware\custom;

use App\models\companies\CargoCompanyModel;
use App\models\companies\CompanyStaffModel;
use Closure;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CargoCompanyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rules = [
            "company_token" => "required|string|exists:cargo_companies,company_token",
            "company_id" => "required|integer|exists:cargo_companies,id",
            "host_type" => "required|integer|in:1,2",
            "staff_id" => "nullable|integer",
            "staff_email" => "nullable|string",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, 'Unauthenticated - Missing required credentials');
        }
        $staff = null;
        if ($request->host_type == 2) {
            $staff = CompanyStaffModel::where([
                ['id',  $request->staff_id],
                ['staff_email', $request->staff_email]
            ])->get();
            if ($staff == null || $staff->count() <= 0)
                return $this->jsonRespnse(false, 'Unauthenticated - Invalid staff credentials');
            else
                $staff = $staff[0];
        }
        $company = CargoCompanyModel::where([
            ["company_token", $request->company_token],
            ["id", $request->company_id]
        ])->get();
        if ($company == null || $company->count() <= 0) {
            return $this->jsonRespnse(false, 'Unauthenticated - Invalid credentials');
        }
        // if ($staff)
        // return $this->jsonRespnse(true, 'Unauthenticated - Invalid staff credentials', $staff);
        $request->merge(["company" => $company[0], "staff" => $staff]);
        return $next($request);
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
