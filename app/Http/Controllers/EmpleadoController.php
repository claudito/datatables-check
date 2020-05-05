<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\EmpleadoRegistro;

class EmpleadoController extends Controller
{
    //

	public function index(Request $request)
	{


		if($request->ajax()){

			$result =  Empleado::all();

			return array('data'=>$result);

		}


		
		return view('empleado.index');

	}

	public function envio(Request $request)
	{

		$items = $request->items;

		$result  = Empleado::whereIn('id',$items)->get();


		//return array('data'=>$result);

		return $result;



	}


	public function registro(Request $request)
	{

		
		foreach ($request->id as $key => $id_empleado) {
			
			$cantidad  =  $request->salario[$key];

			EmpleadoRegistro::create([

				'id_empleado'=>$id_empleado,
				'cantidad'	 =>$cantidad

			]);

		}


		return array(

			'title' => 'Buen Trabajo',
			'text'  => 'Registro Agregado',
			'icon'  =>  'success'
 


		);


	}



}
