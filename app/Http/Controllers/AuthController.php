<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
	{
		$this->validate($request, [
			'nama' => 'required|min:5',
			'email' => 'required|email|unique:employees',
			'password' => 'required|confirmed',
		]);
		$input = $request->all();
		//validation
		$validationRules = [
			'nama' => 'required|string',
			'email' => 'required|email|unique:employees',
			'password' => 'required|confirmed',
		];

		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
		}
		//validation end

		//create user employee
		$employee = new Employee;
		$employee->nama = $request->input('nama');
		$employee->email = $request->input('email');
		$plainPassword = $request->input('password');
		$employee->password = app('hash')->make($plainPassword);
		$employee->save();
		return response()->json($employee, 200);
    }

    public function login(Request $request)
	{
		$input = $request->all();

		//validation
		$validationRules = [
			'email' => 'required|string',
			'password' => 'required|string',
		];

		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
		}

		//procces login
		$credentials = $request->only(['email', 'password']);
		if(! $token = Auth::attempt($credentials)){
			return response()->json(['message' => 'Unaunthorized'], 401);
		}

		return response()->json([
			'token' => $token,
			'token_type' => 'bearer',
			'expires_in' => Auth::factory()->getTTL() * 60
		], 200);
	}
}
?>