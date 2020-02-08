<?php
namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CarsController extends Controller
{
	public function index(Request $request)
	{
		$acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $car = Car::OrderBy("id", "DESC")->paginate(10);

            if($acceptHeader === 'application/json')
			{
                return response()->json($car, 200);
			} else {
                    $xml = new \SimpleXMLElement('<cars/>');

                    foreach ($car->items('data') as $item)
                    {
                        $xmlItem = $xml->addChild('car');

                        $xmlItem->addChild('id', $item->id);
                        $xmlItem->addChild('jenis', $item->jenis);
                        $xmlItem->addChild('kapasitas', $item->kapasitas);
                        $xmlItem->addChild('nopol', $item->nopol);
                        $xmlItem->addChild('id_pegawai', $item->harga);
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
            'jenis'=> 'required',
            'kapasitas' => 'required|',
            'nopol' => 'required|',
            'id_pegawai' => 'required|exists:employees,id',
	         ];

	        $validator = \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            return response()->json($validator->errors(), 400);
	        }

            $car = Car::create($input);

            if($acceptHeader === 'application/json')
			{
				return response()->json($car, 200);
			} else {
                $xml = new \SimpleXMLElement('<cars/>');

                    $xmlItem = $xml->addChild('car');

                    $xmlItem->addChild('id', $car->id);
                    $xmlItem->addChild('jenis', $car->jenis);
                    $xmlItem->addChild('kapasitas', $car->kapasitas);
                    $xmlItem->addChild('nopol', $car->nopol);
                    $xmlItem->addChild('id_pegawai', $car->id_pegawai);
                    $xmlItem->addChild('created_at', $car->created_at);
                    $xmlItem->addChild('updated_at', $car->updated_at);
                    
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
            $car = Car::find($id);
	        if(!$car){
	            abort(404);
	        }

            if($acceptHeader === 'application/json')
			{
				return response()->json($car, 200);
			} else {
                $xml = new \SimpleXMLElement('<cars/>');

                    $xmlItem = $xml->addChild('car');

                    $xmlItem->addChild('id', $car->id);
                    $xmlItem->addChild('jenis', $car->jenis);
                    $xmlItem->addChild('kapasitas', $car->kapasitas);
                    $xmlItem->addChild('nopol', $car->nopol);
                    $xmlItem->addChild('id_pegawai', $car->id_pegawai);
                    $xmlItem->addChild('created_at', $car->created_at);
                    $xmlItem->addChild('updated_at', $car->updated_at);
                    
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
            'jenis'=> 'required',
            'kapasitas' => 'required|',
            'nopol' => 'required|',
            'id_pegawai' => 'required|exists:employees,id',
	         ];

	        $validator = \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            return response()->json($validator->errors(), 400);
	        }
	        
            $car = Car::find($id);
	        if(!$car){
	            abort(404);
	        }
            $car = Car::create($input);

            $car->fill($input);
        	$car->save();

            if($acceptHeader === 'application/json')
			{
				return response()->json($car, 200);
			} else {
                $xml = new \SimpleXMLElement('<cars/>');

                    $xmlItem = $xml->addChild('car');

                    $xmlItem->addChild('id', $car->id);
                    $xmlItem->addChild('jenis', $car->jenis);
                    $xmlItem->addChild('kapasitas', $car->kapasitas);
                    $xmlItem->addChild('nopol', $car->nopol);
                    $xmlItem->addChild('id_pegawai', $car->id_pegawai);
                    $xmlItem->addChild('created_at', $car->created_at);
                    $xmlItem->addChild('updated_at', $car->updated_at);
                    
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
			$car = Car::find($id);
	        if(!$car){
	            abort(404);
	        }

	        $car->delete();

			if($acceptHeader === 'application/json')
			{
				$message = ['message' => 'deleted succesfully', 'car_id' => $id];

        		return response()->json($message, 200);
			} else {
				$xml = new \SimpleXMLElement('<Cars/>');
				$xmlItem = $xml->addChild('car');

				$xmlItem->addChild('id', $car->id);
				$xmlItem->addChild('message' , 'deleted succesfully');

				return $xml->asXML();
			}

		}else{
				return response('Not Acceptable', 406);
			}
	}
}
?>