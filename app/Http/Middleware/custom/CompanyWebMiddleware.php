<?php

namespace App\Http\Middleware\custom;

use App\models\companies\CargoCompanyModel;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class CompanyWebMiddleware
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
        if ($request->cookie('cc_cookie') == null)
            return redirect::route('company_login');

        $company_token = $request->cookie('cc_cookie');
        $company = CargoCompanyModel::where('company_token', $company_token)->get();
        if ($company == null || $company->count() <= 0) {
            Cookie::queue(Cookie::forget('cc_cookie'));
            return redirect::route('company_login');
        }
        $request->merge(["company" => $company[0]]);

        return $next($request);
    }
}
