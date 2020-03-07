<?php

namespace App\Http\Controllers\Pembayaran;

use App\User;
use App\model\Pembayaran\Kas;
use App\model\Pembayaran\Kas_manual;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\DokterRequest;
use App\model\MasterData\Spesialis;
use App\model\MasterData\SubSpesialis;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class KasManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $kas_manual;

    public function __construct(Kas_manual $kas_manual)
    {
        $this->kas_manual = $kas_manual;
    }

    public function index()
    {
        //

        $row = $this->kas_manual->where('aktif','=','Y')->orderBy('id', 'desc')->paginate(30);
        return view('pembayaran.kas_manual.index')->with([
               'data'             => $row,
               'title'            => 'Data Kas Manual',
               'subtitle'         => 'List Kas Manual',
               'no'               => '0',
           ]);

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
       // dd($request->all());

        $user = auth()->user()->id;
        $tgl_open =  date("Y-m-d");
        $cek = Kas::where([
            ['users_id','=',$user],
            ['tgl_open','=',date("Y-m-d")],
        ])->get();
        if($cek->first()){
            try{

                $request->request->add(['kas_id'=>$cek->first()->id,
                'users_id' => $user,
                ]);
                $kas_manual = Kas_manual::create($request->all());
                return redirect('/kas_manual')->with('sukses', 'Data Berhasil di input');
            }catch(\Exception $e){
                return redirect('/kas_manual')->with('gagal', 'Data Gagal Di input...!! '.$e);
            }

        }else{
             return redirect('/kas_manual')->with('gagal', 'Anda Belum Melakukan Open Kas...!!');
        }
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
