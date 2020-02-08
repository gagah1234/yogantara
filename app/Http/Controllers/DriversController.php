<?php
namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DriversController extends Controller
{
	public function index(Request $request)
	{
		$acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $driver = Driver::OrderBy("id", "DESC")->paginate(10);

            if($acceptHeader === 'application/json')
			{
                return response()->json($driver, 200);
			} else {
                    $xml = new \SimpleXMLElement('<drivers/>');

                    foreach ($driver->items('data') as $item)
                    {
                        $xmlItem = $xml->addChild('driver');

                        $xmlItem->addChild('id', $item->id);
                        $xmlItem->addChild('nama', $item->nama);
                        $xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
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
            'nama'=> 'required',
            'jenis_kelamin' => 'required|',
             ];

            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $driver = Driver::create($input);

            if($acceptHeader === 'application/json')
            {
                return response()->json($driver, 200);
            } else {
                $xml = new \SimpleXMLElement('<drivers/>');

                    $xmlItem = $xml->addChild('driver');

                    $xmlItem->addChild('id', $driver->id);
                    $xmlItem->addChild('nama', $driver->nama);
                    $xmlItem->addChild('jenis_kelamin', $driver->jenis_kelamin);
                    $xmlItem->addChild('created_at', $driver->created_at);
                    $xmlItem->addChild('updated_at', $driver->updated_at);
                    
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
            $driver = Driver::find($id);
            if(!$driver){
                abort(404);
            }

            if($acceptHeader === 'application/json')
            {
                return response()->json($driver, 200);
            } else {
                $xml = new \SimpleXMLElement('<drivers/>');

                    $xmlItem = $xml->addChild('driver');

                    $xmlItem->addChild('id', $driver->id);
                    $xmlItem->addChild('nama', $driver->nama);
                    $xmlItem->addChild('jenis_kelamin', $driver->jenis_kelamin);
                    $xmlItem->addChild('created_at', $driver->created_at);
                    $xmlItem->addChild('updated_at', $driver->updated_at);
                    
                    return $xml->asXML();   
            }
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $input = $request->all();

            $validationRules = [
            'nama'=> 'required',
            'jenis_kelamin' => 'required|',
             ];

            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            
            $driver = Driver::find($id);
            if(!$driver){
                abort(404);
            }

            $driver->fill($input);
            $driver->save();

            if($acceptHeader === 'application/json')
            {
                return response()->json($driver, 200);
            } else {
                $xml = new \SimpleXMLElement('<drivers/>');

                    $xmlItem = $xml->addChild('driver');

                    $xmlItem->addChild('id', $driver->id);
                    $xmlItem->addChild('nama', $driver->nama);
                    $xmlItem->addChild('jenis_kelamin', $driver->jenis_kelamin);
                    $xmlItem->addChild('created_at', $driver->created_at);
                    $xmlItem->addChild('updated_at', $driver->updated_at);
                    
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
            $driver = Driver::find($id);
            if(!$driver){
                abort(404);
            }

            $driver->delete();

            if($acceptHeader === 'application/json')
            {
                $message = ['message' => 'deleted succesfully', 'driver_id' => $id];

                return response()->json($message, 200);
            } else {
                $xml = new \SimpleXMLElement('<drivers/>');
                $xmlItem = $xml->addChild('driver');

                $xmlItem->addChild('id', $driver->id);
                $xmlItem->addChild('message' , 'deleted succesfully');

                return $xml->asXML();
            }

        }else{
                return response('Not Acceptable', 406);
            }
    }
}
?>