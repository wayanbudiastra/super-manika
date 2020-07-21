<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\MasterData\ProdukItem;

class MinMaxController extends Controller
{
    //
    public function index(){
        $data = ProdukItem::all();
        //dd($data);
        return view('inventory.minmax.index',[
            'data' => $data,
            'no' => 0,
            'subtitle'=>'Data Min-Max',
            'title'=>'List  Produk']);
    }

    public function set_max($id,$qty){
        if(auth()->user()->id == ''){
            return response()->json(['status'=> 401], 401);
        }
        try{
            $produk = ProdukItem::find($id);
            $produk->stok_max= $qty;
            $produk->update();

            return response()->json(['status'=>200],200);
        }catch(Exception $e){
            return response()->json(['data' => $e, 'status'=>500],500);
        }
   }

   public function set_min($id,$qty){
    if(auth()->user()->id == ''){
        return response()->json(['status'=> 401], 401);
    }
    try{
        $produk = ProdukItem::find($id);
        $produk->stok_min= $qty;
        $produk->update();

        return response()->json(['status'=>200],200);
    }catch(Exception $e){
        return response()->json(['data' => $e, 'status'=>500],500);
    }
}

public function cari(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;

        // mengambil data dari table produk sesuai pencarian data
        $data = ProdukItem::where('kode', 'like', "%" . $cari . "%")->
        orWhere('nama_item', 'like', "%" . $cari . "%")->get();
        return view('inventory.minmax.index',[
            'data' => $data,
            'no' => 0,
            'subtitle'=>'Data Min-Max',
            'title'=>'List  Produk']);

    }
}
