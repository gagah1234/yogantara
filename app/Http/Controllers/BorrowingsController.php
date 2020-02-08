<?php
namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BorrowingsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $borrowing = Borrowing::OrderBy("id", "DESC")->paginate(10);

            if($acceptHeader === 'application/json')
            {
                return response()->json($borrowing, 200);
            } else {
                    $xml = new \SimpleXMLElement('<borrowings/>');

                    foreach ($borrowing->items('data') as $item)
                    {
                        $xmlItem = $xml->addChild('borrowing');

                        $xmlItem->addChild('id', $item->id);
                        $xmlItem->addChild('nama_peminjam', $item->nama_peminjam);
                        $xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
                        $xmlItem->addChild('alamat', $item->alamat);
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
            'nama_peminjam'=> 'required',
            'jenis_kelamin' => 'required|',
            'alamat' => 'required|'
             ];
            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $borrowing = Borrowing::create($input);
            if($acceptHeader === 'application/json')
            {
                return response()->json($borrowing, 200);
            } else {
                $xml = new \SimpleXMLElement('<borrowings/>');
                    $xmlItem = $xml->addChild('borrowing');

                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('nama_peminjam', $item->nama_peminjam);
                    $xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
                    $xmlItem->addChild('alamat', $item->alamat);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                    
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
            $borrowing = Borrowing::find($id);
            if(!$borrowing){
                abort(404);
            }

            if($acceptHeader === 'application/json')
            {
                return response()->json($borrowing, 200);
            } else {
                $xml = new \SimpleXMLElement('<borrowings/>');

                    $xmlItem = $xml->addChild('borrowing');

                    $xmlItem->addChild('id', $borrowing->id);
                    $xmlItem->addChild('nama_peminjam', $borrowing->nama_peminjam);
                    $xmlItem->addChild('jenis_kelamin', $borrowing->jenis_kelamin);
                    $xmlItem->addChild('alamat', $borrowing->alamat);
                    $xmlItem->addChild('created_at', $borrowing->created_at);
                    $xmlItem->addChild('updated_at', $borrowing->updated_at);
                    
                    return $xml->asXML();   
            }
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $borrowing = Borrowing::find($id);
            if(!$borrowing){
                abort(404);
            }

            $borrowing->delete();

            if($acceptHeader === 'application/json')
            {
                $message = ['message' => 'deleted succesfully', 'borrowing_id' => $id];

                return response()->json($message, 200);
            } else {
                $xml = new \SimpleXMLElement('<borrowings/>');
                $xmlItem = $xml->addChild('borrowing');

                $xmlItem->addChild('id', $borrowing->id);
                $xmlItem->addChild('message' , 'deleted succesfully');

                return $xml->asXML();
            }

        }else{
                return response('Not Acceptable', 406);
            }
    }
}
?>