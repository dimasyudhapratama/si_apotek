<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Supplier;
use App\Pembelian;
use App\PembayaranPembelian;
use App\DetailPembelian;
use App\ProdukStokDetail;

class PembelianController extends Controller{

    function index(){
        $supplier = Supplier::get();
        return view('modules/pembelian/v_transaksi',['supplier' => $supplier]);
    }

    function produk($id){
        $data_from_db = DB::table('produk')
        ->select('nama_produk','harga_beli')
        ->where('id','=',$id)
        ->get();
        return $data_from_db;
    }
    function satuanProduk($id){
        $data_from_db = DB::table('produk_konversi_stok')
        ->select('id','satuan')
        ->where('produk_id','=',$id)
        ->where('status_aktif','=',"1")
        ->get();
        return $data_from_db;
    }
    function konversiSatuanProduk($id){
        $data_from_db = DB::table('produk_konversi_stok')
        ->select('nilai_konversi')
        ->where('id','=',$id)
        ->get();
        return $data_from_db;
    }

    function store(Request $request){
        //Save Ke Tabel Pembelian
        $array_data = [
            'user_id' => Auth::id(), 
            'supplier_id' => $request->supplier,
            'cara_pembayaran' => $request->cara_pembayaran, 
            'tgl_jatuh_tempo' => $request->jatuh_tempo,
            'status_pembayaran' => $request->terbayar >= $request->grand_total ? "1" : "0",
            'total' => $request->total,
            'diskon' => $request->diskon,
            'grand_total' => $request->grand_total,
            'terbayar' => $request->terbayar,
            'terbayar' => $request->terbayar >= $request->grand_total ? $request->grand_total : $request->terbayar,
            'sisa_tunggakan' => $request->terbayar >= $request->grand_total ? 0 : $request->grand_total - $request->terbayar,
            //Untuk Struk
            'uang_pembayaran' => $request->terbayar,
            'kembalian_pembayaran' => $request->terbayar >= $request->grand_total ? $request->terbayar - $request->grand_total : 0,
        ];

        $pembelian = Pembelian::create($array_data);

        //Insert Ke Tabel Pembayaran Pembelian
        if($request->terbayar > 0){
            $array_data_pembayaran = [
                'pembelian_id' => $pembelian->id,
                'jumlah' => $request->terbayar - $request->grand_total >= 0 ? $request->grand_total : $request->terbayar,
                'user_id' => Auth::id()
            ];
            PembayaranPembelian::create($array_data_pembayaran);
        }
        

        //Detail Pembelian
        for($i = 0; $i < count($request->subtotal); $i++){
            //Save Ke Tabel Detail Pembelian
            $array_data_detail = [
                'pembelian_id' => $pembelian->id,
                'produk_konversi_stok_id' => $request->satuan[$i],
                'produk_stok_detail_exp_date' => $request->exp_date[$i],
                'harga' => $request->harga[$i],
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ];
            DetailPembelian::create($array_data_detail);


            //Pengolahan Stok
            //Detail Konversi Stok Per Row - Mengambil Level Stok
            $detail_pembelian_produk = DB::table('produk_konversi_stok')->where('id',$request->satuan[$i])->select('level')->first();
            $level_satuan_initial = $detail_pembelian_produk->level;            

            //load Konversi Stok
            $produk_konversi_stok_data = DB::table('produk_konversi_stok')  //Looping Per Row Berdasarkan Produk ID dan Status Aktif 1
            ->join('produk','produk.id','=','produk_konversi_stok.produk_id')
            ->where('produk_konversi_stok.produk_id','=',$request->kode_produk[$i])
            ->where('produk_konversi_stok.status_aktif','=','1')
            ->select('produk.level_satuan','produk_konversi_stok.id AS produk_konversi_stok_id','produk_konversi_stok.level','produk_konversi_stok.nilai_konversi')
            ->orderByDesc('produk_konversi_stok_id')
            ->get();


            $increment_temporary = 0;
            $nilai_konversi = 1;
            $input_stok = 0;
            $stok_baru = 0;
            foreach($produk_konversi_stok_data as $p){
                
                //Increment Temporary Digunakan untuk Percabangan Multi Stok
                if($increment_temporary == 0){
                    //Nilai Konversi
                    $nilai_konversi = $p->nilai_konversi;

                    //Jika Level Satuan Barang Yang Diinput adalah level 1
                    if($level_satuan_initial == 1){
                        $input_stok = $request->qty[$i] * $nilai_konversi;

                    }else if($level_satuan_initial == 2){ //Jika Level Satuan Barang yang diinput adalah level 2
                        $input_stok = $request->qty[$i] * 1;
                    }


                    //Mencari Stok Lama Di Database
                    $stok_lama = 0;
                    if(DB::table('produk_stok_detail')
                        ->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)
                        ->where('exp_date',$request->exp_date[$i])
                        ->exists()){

                        $data = DB::table('produk_stok_detail')->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)->where('exp_date',$request->exp_date[$i])->first();
                        $stok_lama = $data->jumlah;
                    }

                    //Menjumlahkan Stok Lama dengan Input Stok
                    $stok_baru = $stok_lama + $input_stok;

                }else if($increment_temporary == 1){
                    $stok_baru = $stok_baru / $nilai_konversi;
                }

                //Increment Temporary
                $increment_temporary++;

                //Update or create New Data on Produk Stok Detail Table
                $where = [
                    'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
                    'exp_date' => $request->exp_date[$i],
                ];                
                $data_detail_stok = [
                    'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
                    'exp_date' => $request->exp_date[$i],
                    'jumlah' => $stok_baru,
                ];
                ProdukStokDetail::updateOrCreate($where, $data_detail_stok);
                
            }

        }

        //Return Ajax
        $return_data = [
            'status' => 'success',
            'invoice_number' => $pembelian->id

        ];
        return $return_data ;
    }

    function simpanPembayaranPembelian(Request $request){
        $data = [
            'pembelian_id' => $request->pembelian_id,
            'user_id' => Auth::id(),
            'jumlah' => $request->data_pembayaran_jumlah
        ];
        PembayaranPembelian::create($data);

        $pembelian = Pembelian::find($request->pembelian_id);
        if($pembelian->grand_total - $pembelian->terbayar <= 0){
            $pembelian->status_pembayaran = 1;
        }
        $pembelian->terbayar += $request->data_pembayaran_jumlah;
        $pembelian->save();
        return $pembelian;
    }

    function strukA4($id){
        //Data Pembelian
        $data_pembelian = DB::table('pembelian')
        ->leftJoin('users','pembelian.user_id','=','users.id')
        ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
        ->where('pembelian.id','=',$id)
        ->select('pembelian.id','pembelian.created_at','users.name AS nama_user','supplier.nama AS nama_supplier','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','total','diskon','grand_total','terbayar','sisa')
        ->first();

        //Data Detail Pembelian
        $detail_pembelian = DB::table('detail_pembelian')
        ->join('produk_konversi_stok','detail_pembelian.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('pembelian_id','=',$id)
        ->select('produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','harga','qty','subtotal')
        ->get();

        $data = [
            'master' => $data_pembelian,
            'detail_pembelian' => $detail_pembelian
        ];

        return view('modules/pembelian/struk_transaksi_a4',$data);
    }
}
