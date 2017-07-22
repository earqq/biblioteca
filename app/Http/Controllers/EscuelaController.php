<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use  App\libro;
use  App\categoria;
use  App\escuela;

class EscuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
      
       return view('escuela.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return View::make('producto.partial.modal-producto');

    }
     public function data()
    {
        $orders=escuela::all();
        
        return \Datatables::of($orders)->addColumn('action', 'escuela.partials.vista')->make(true) ; 
    }
     public function reporte()
    {
        return view('reporte.escuela');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {   

       if($request->crear==0)
           $libro=new escuela;
       else $libro=escuela::find($request->get('id_escuela'));
            $libro->nombre=$request->nombre;
            $libro->facultad=$request->facultad;
          
            $libro->save();
           return 'Escuela guardada';
        
    }

    //Funcion para obtener una habitacion
    //@Param $request -> viene el id de la habitacion
    public function get(Request $request)
    {
        $escuela= escuela::find($request->id);

        return $escuela;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

 
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
       $escuela=escuela::find($id);
        $escuela->delete();
        return 'Escuela borrada';
    }

}
