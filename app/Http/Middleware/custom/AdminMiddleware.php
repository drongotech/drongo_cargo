<?php

namespace App\Http\Middleware\custom;

use App\models\admin\AdminsModel;
use Closure;
use Illuminate\Support\Facades\Response;

class AdminMiddleware
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
        $user = $request->user();
        if ($user->isAdmin($request)) {
            $errorMessage = null;
            $permissions = $user->Permissions;
            $route_name = $request->route()->getName();
            if ($route_name == null) {
                $errorMessage = "unknown route name";
            } else {
                switch ($route_name) {
                    case 'qrcode_new':
                        if ($permissions->admin_qrcode_permissions < $permissions->perm_write) {
                            $errorMessage = "You are not authorized for writing qrcodes";
                        }
                        break;
                    case 'qrcode_list':
                        if ($permissions->admin_qrcode_permissions < $permissions->perm_read) {
                            $errorMessage = "You are not authorized for read qrcodes";
                        }
                        break;
                    case 'qrcode_generate':
                        if ($permissions->admin_qrcode_permissions < $permissions->perm_write) {
                            $errorMessage = "You are not authorized for generating qrcodes";
                        }
                        break;
                    default:
                        $errorMessage = "unknown route name";
                }
            }
            if ($errorMessage == null)
                return $next($request);
        }
        if ($user->errorMessage != null)
            $errorMessage = $user->errorMessage;
        else
            $errorMessage = "You are not authorized for this action";
        if ($request->expectsJson()) {

            return Response::json([
                "isSuccess" => false,
                "errorMessage" => $errorMessage,
                "data" => [],
            ]);
        } else
            abort(403);
    }
}
