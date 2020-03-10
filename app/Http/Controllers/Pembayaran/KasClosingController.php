<?php

namespace App\Http\Controllers\Pembayaran;

    use  App\User;
    use App\model\MasterData\Dokter;
    use App\model\Pembayaran\Kas;
    use App\model\Pembayaran\Pembayaran;
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
        $kas_manual = Kas_manual::where('kas_id','=','id')->get();
        dd($pembayaran->toArray());

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
