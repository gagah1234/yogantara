<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $transaction = Transaction::OrderBy("id", "DESC")->paginate(10);

            if($acceptHeader === 'application/json')
            {
                return response()->json($transaction, 200);
            } else {
                    $xml = new \SimpleXMLElement('<transactions/>');

                    foreach ($transaction->items('data') as $item)
                    {
                        $xmlItem = $xml->addChild('transaction');

                        $xmlItem->addChild('id', $item->id);
                        $xmlItem->addChild('tgl_transaksi', $item->tgl_transaksi);
                        $xmlItem->addChild('tgl_kembali', $item->tgl_kembali);
                        $xmlItem->addChild('jml_transaksi', $item->jml_transaksi);
                        $xmlItem->addChild('biaya', $item->biaya);
                        $xmlItem->addChild('id_pegawai', $item->biaya);
                        $xmlItem->addChild('id_mobil', $item->id_mobil);
                        $xmlItem->addChild('id_supir', $item->id_supir);
                        $xmlItem->addChild('id_peminjam', $item->id_peminjam);
                        $xmlItem->addChild('created_at', $item->created_at);
                        $xmlItem->addChild('updated_at', $item->updated_at);
                    }
                    return $xml->asXML();   
                }
            }else{
                return response('Not Acceptable', 406);
        }
    }

    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $input = $request->all();

            $validationRules = [
            'tgl_transaksi'=> 'required',
            'tgl_kembali' => 'required|',
            'jml_transaksi' => 'required|',
            'biaya' => 'required|',
            'id_pegawai'=> 'required|exists:employees,id',
            'id_mobil'=> 'required|exists:cars,id',
            'id_supir'=> 'required|exists:drivers,id',
            'id_peminjaman'=> 'required|exists:borrowings,id',
             ];

            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $transaction = Transaction::create($input);

            if($acceptHeader === 'application/json')
            {
                return response()->json($transaction, 200);
            } else {
                $xml = new \SimpleXMLElement('<transactions/>');

                    $xmlItem = $xml->addChild('transaction');

                    $xmlItem->addChild('id', $transaction->id);
                    $xmlItem->addChild('tgl_transaksi', $transaction->tgl_transaksi);
                    $xmlItem->addChild('tgl_kembali', $transaction->tgl_kembali);
                    $xmlItem->addChild('jml_transaksi', $transaction->jml_transaksi);
                    $xmlItem->addChild('biaya', $transaction->biaya);
                    $xmlItem->addChild('id_pegawai', $transaction->biaya);
                    $xmlItem->addChild('id_mobil', $transaction->id_mobil);
                    $xmlItem->addChild('id_supir', $transaction->id_supir);
                    $xmlItem->addChild('id_peminjaman', $transaction->id_peminjaman);
                    $xmlItem->addChild('created_at', $transaction->created_at);
                    $xmlItem->addChild('updated_at', $transaction->updated_at);
                    
                    return $xml->asXML();   
            }
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $transaction = Transaction::find($id);
            if(!$transaction){
                abort(404);
            }

            if($acceptHeader === 'application/json')
            {
                return response()->json($transaction, 200);
            } else {
                $xml = new \SimpleXMLElement('<transactions/>');

                    $xmlItem = $xml->addChild('transaction');

                    $xmlItem->addChild('id', $transaction->id);
                    $xmlItem->addChild('tgl_transaksi', $transaction->tgl_transaksi);
                    $xmlItem->addChild('tgl_kembali', $transaction->tgl_kembali);
                    $xmlItem->addChild('jml_transaksi', $transaction->jml_transaksi);
                    $xmlItem->addChild('biaya', $transaction->biaya);
                    $xmlItem->addChild('id_pegawai', $transaction->biaya);
                    $xmlItem->addChild('id_mobil', $transaction->id_mobil);
                    $xmlItem->addChild('id_supir', $transaction->id_supir);
                    $xmlItem->addChild('id_peminjaman', $transaction->id_peminjaman);
                    $xmlItem->addChild('created_at', $transaction->created_at);
                    $xmlItem->addChild('updated_at', $transaction->updated_at);
                    
                    return $xml->asXML();   
            }
        }else{
            return response('Not Acceptable', 406);
        }
    }
}
?>