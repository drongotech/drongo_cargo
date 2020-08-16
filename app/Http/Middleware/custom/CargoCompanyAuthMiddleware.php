<?php

namespace App\Http\Middleware\custom;

use App\models\companies\CargoCompanyModel;
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
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonRespnse(false, 'Unauthenticated - Missing required credentials');
        }
        $company = CargoCompanyModel::where([
            ["company_token", $request->company_token],
            ["id", $request->company_id]
        ])->get();
        if ($company == null || $company->count() <= 0) {
            return $this->jsonRespnse(false, 'Unauthenticated - Invalid credentials');
        }
        $request->merge(["company" => $company[0]]);
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
