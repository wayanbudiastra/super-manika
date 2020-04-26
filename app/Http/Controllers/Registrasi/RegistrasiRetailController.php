<?php

namespace App\Http\Controllers\Registrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pasien;
use App\model\Registrasi_retail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RegistrasiRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('registrasi.retail.add_reg_retail',[
            'title' => 'Registrasi Retail',
            'subtitle' => 'Add Registrasi Retail'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_pasien()
    {
        //
        $pasien = Pasien::where('aktif','=','Y')->get();
        //dd($pasien);
        return response()->json($pasien);
        // return reponse(['data'=>$pasien]);
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
        try{
            $per = GetPeriode();
            $request->request->add([
                                'tgl_reg'=> date('Y-m-d'),
                                'users_id' => auth()->user()->id,
                                'periode' => $per]);
           // dd($request->all());
             $registrasi_retail = Registrasi_retail::create($request->all());
             return redirect('/registrasi_retail/list')->with('sukses', 'Data Berhasil di input');
        }catch(\Exception $e){
            return redirect('/registrasi_retail/list')->with('gagal', 'Data Gagal di input ' .$e);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        
        $data = Registrasi_retail::where('aktif','=','Y')->get();
        // //dd(info_pasien_nama(1));
        // $data = info_pasien_nama(1);
       
         return view('registrasi.retail.index',[
            'title' => 'Registrasi Retail',
            'subtitle' => 'List Registrasi Retail',
            'data' => $data,
            'no' => 0
        ]);
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
        $data = Registrasi_retail::find($idx);
        $pasien = Pasien::where('aktif','=','Y')->get();
       
         return view('registrasi.retail.edit_reg_retail',[
            'title' => 'Registrasi Retail',
            'subtitle' => 'Edit Registrasi Retail',
            'data' => $data,
            'pasien' => $pasien
        ]);
    }

    
    public function update(Request $request, $id)
    {
       try {
                $validator = Validator::make(request()->all(), [
                    'pasien_id' => 'required',
                    'jenis_registrasi_retail_id'   => 'required',
                ]);

                if ($validator->fails()) {
                    $message = $validator->errors();
                    return redirect('/registrasi_retail/list')->with('gagal',
                        '<p>' . $message->first('pasien_id') . '</p>
                         <p>' . $message->first('jenis_registrasi_retail_id') . '</p>'
                    );
                }
                $data = Registrasi_retail::find($id);
                $data->update($request->all());
                return redirect('/registrasi_retail/list')->with('sukses', 'Data Berhasil di Edit');
            } catch (\Exception $e) {
                // store errors to log
                \Log::error('class : ' . SpesialisController::class . ' method : edit | ' . $e);

                return redirect('/registrasi_retail/list')->with('gagal', 'Data Gagal di Edit');
            }
    }

   
    public function cencel_ajax($id)
    {
        //
        $data = Registrasi_retail::find($id);
        $data->update(['iscencel'=>'Y','aktif'=>'N']);
         return response()->json($data);
    }
}
