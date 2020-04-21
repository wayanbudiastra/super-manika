<?php

namespace App\Http\Controllers\Pembayaran;

    use  App\User;
    use App\model\MasterData\Dokter;
    use App\model\Pembayaran\Kas;
    use App\model\Pembayaran\Pembayaran;
    use App\model\Pembayaran\Kas_manual;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\MasterData\DokterRequest;
    use Illuminate\Http\Request;
    use Yajra\DataTables\DataTables;
    use Illuminate\Support\Facades\Validator;

class KasClosingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $kas;

    public function __construct(Kas $kas)
    {
        $this->kas = $kas;
    }

    public function index()
    {
        //
        $row = $this->kas->where('aktif','=','Y')->orderBy('id', 'desc')->paginate(30);
        return view('pembayaran.kas_closing.index')->with([
               'data'             => $row,
               'title'            => 'Data Kas',
               'subtitle'         => 'Proses Closing',
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
        $kas = Kas::find($id);
       // dd($kas->toArray());
        $pembayaran = Pembayaran::where('kas_id','=',$id)->get();
        $kas_manual = Kas_manual::where('kas_id','=',$id)->get();
       // dd($pembayaran->toArray());


       $row = $this->kas->where('aktif','=','Y')->orderBy('id', 'desc')->paginate(30);
        return view('pembayaran.kas_closing.closing')->with([
               'pembayaran'             => $pembayaran,
               'total_pembayaran'       => total_pembayaran($pembayaran),//ambil dari helper global
               'kas_manual'             => $kas_manual,
               'total_kasManual'        => total_kasManual($kas_manual),
               'kas'                    => $kas,
               'title'                  => 'Data Kas',
               'subtitle'               => 'Proses Closing',
               'no'                     => '0',
           ]);
       // dd($kas->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function lanjut_closing($id){
      $kas = Kas::find($id);
      $pembayaran = Pembayaran::where('kas_id','=',$id)->get();
      $kas_manual = Kas_manual::where('kas_id','=',$id)->get();
      $total_pembayaran = total_pembayaran($pembayaran);
      $total_kasManual = total_kasManual($kas_manual);
      $kas_akhir = $kas->kas_awal + $total_pembayaran + $total_kasManual;

      try{
          $kas->update(['tgl_close' => date('Y-m-d'),
          'total_transaksi' => $total_pembayaran,
          'total_manualKas' => $total_kasManual,
          'kas_akhir' => $kas_akhir,
          'aktif' => 'N' ]);

          //update pembayaran 
        $updatePembayaran = Pembayaran::where('kas_id','=',$id)->update(['aktif'=>'N']);
        $updateKasManual = Kas_manual::where('kas_id','=',$id)->update(['aktif'=>'N']);
          
         return response()->json([
                'success' => true,
                'kas' => $kas,
                'updatePembayaran' => $updatePembayaran,
                'updateKasManual' => $updateKasManual,
                'message' => "Data Berhasil di input"
            ], 200);

         }catch(\Exception $e){
          return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
      }
    }
}
