<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\models\products\QRCodesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class QRCodeController extends Controller
{
    //

    public function openNewQRCodeFormPage(Request $request)
    {
        return view('qrcodes.new_qrcode_page');
    }
    public function openQRCodeList(Request $request)
    {
        return view('qrcodes.qrcodes_list_all');
    }


    //post functions

    public function generateNewQRCodes(Request $request)
    {
        $user = $request->user();
        $rules = [
            "qr_code_quantity" => "required|integer|min:10|max:999",
        ];

        $data = $request->validate($rules);

        $num_to_generate = $data["qr_code_quantity"];
        $generated_codes = 0;
        for ($i = 0; $i < $num_to_generate; $i++) {
            $d = new DNS1D();
            try {
                $d->setStorPath('/qrcodes/cache/');
                $QRCodeModel = new QRCodesModel();
                $code =  $QRCodeModel->generateCode();
                $image =  base64_decode($d->getBarcodePNG($code, 'C39+', 3, 33));
                $imageurl = '/qrcodes/cache/qrcode_' . (time() + $i) . '.png';
                Storage::disk('public')->put($imageurl, $image);

                $new_qrcode = $QRCodeModel->saveQRCode(env('APP_URL') . '/storage/' . $imageurl, $user->id, $code);
                if ($new_qrcode == false) {
                    throw new Exception("QR code generation failed " . $QRCodeModel->errorMessage, 1);
                }
                $generated_codes += 1;
            } catch (\Throwable $th) {
                if ($generated_codes > 0) {
                    Session::flash('success', 'Generated only ' . $generated_codes . ' qrcodes');
                }
                return Redirect::back()->withErrors(['qr_code_quantity' => $th->getMessage()]);
            }
        }
        return Redirect::back()->with('success', 'successfully generateed ' . $generated_codes . ' qrcodes');
    }
}
