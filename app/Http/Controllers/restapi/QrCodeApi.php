<?php

namespace App\Http\Controllers\restapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeApi extends Controller
{
    public function doctorInfo($id)
    {
        $url = route('qr.code.show.doctor.info', $id);
        return QrCode::size(300)->generate($url);
    }
}
