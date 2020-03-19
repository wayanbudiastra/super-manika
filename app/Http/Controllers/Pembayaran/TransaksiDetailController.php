<?php

namespace App\Http\Controllers\Pembayaran;

use App\model\MasterData\ProdukItem;
use App\model\Inventory\Kartustok;
use App\model\MasterData\Jasa;
use App\model\TindakanItem;
use App\model\Pembayaran\PembayaranDetil;
use  App\User;
use App\model\Pembayaran\Kas;
use App\model\Pembayaran\Pembayaran;
use \App\model\Registrasi1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pembayaran\KasRequest;
use App\model\MasterData\Dokter;
use App\model\MasterData\Poli;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use PDF;

class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $idx = Crypt::decrypt($id);
        $data = Pembayaran::find($idx);
        dd($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
