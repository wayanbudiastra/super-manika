<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Pembayaran;
use App\model\Pembayaran\PembayaranDetil;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use App\model\MasterData\Terpis;
use DB;
use FPDF;
use App\Exports\FeeTerapisExport;
use Maatwebsite\Excel\Facades\Excel;

class FeeTerapisController extends Controller
{
    //
}
