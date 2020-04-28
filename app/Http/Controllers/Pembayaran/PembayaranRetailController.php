<?php

namespace App\Http\Controllers\Pembayaran;

use  App\User;
use App\model\Pembayaran\Kas;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detil;
use \App\model\Registrasi_retail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Registrasi_retail::where([['aktif','=','Y'],['iscencel','=','N']])->get();
        //dd($data);
       
        return view('pembayaran.pembayaran_retil.index',['data' => $data,'no' => 0,
            'subtitle'=>'Data Registrasi',
            'title'=>'List Registrasi Pasien']);
       
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
