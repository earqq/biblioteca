<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Datetime;
use DB;
use App\libro;
use App\autor;
use App\prestamo;
use Arrayobject;
class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $autores=autor::all();
       return view('autor.index',compact('autores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {           
               

    }
    public function grafico()
    {
        //barras

        $autores=autor::all();
        $fecha= new Datetime;
        $mes=$fecha->format('m');
        $mes2=intval($mes)+1;
        $año=$fecha->format('Y');
        $fecha1=$año.'-'.$mes.'-01';
        $fecha2=$año.'-'.$mes2.'-01';
        $prestamos=prestamo::where('fecha_prestamo','>=',$fecha1)->where('fecha_prestamo','<',$fecha2)->get();
        $datos=new Arrayobject();
        foreach ($autores as $key => $autor) {
             $datos[$autor->nombre]=0;
            foreach ($prestamos as $key => $prestamo)
            {
            
                    if($prestamo->id_autor=$autor->id)
                    $datos[$autor->nombre]=$datos[$autor->nombre]+1;
            }
        }
        return $datos;   
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function data()
    {
        $orders=autor::all();
  
        return \Datatables::of($orders)->addColumn('action', 'libro.partials.vista')->make(true) ; 
    }
  
   public function store(Request $request)
    {   
        if($request->crear==0)
           $libro=new autor;
       else $libro=autor::find($request->get('id_autor'));
            $libro->nombre=$request->nombre;
            $libro->apellidos=$request->apellidos;
            $libro->nacionalidad=$request->nacionalidad;
            $libro->save();
           return 'Autor guardado';
        

    }
    public function buscar_autor()
    {
        return view('autor.buscar');
    }
    //Funcion para obtener una habitacion
    //@Param $request -> viene el id de la habitacion
    public function get(Request $request)
    {
        $libro= autor::find($request->id);

        return $libro;
    }
    public function reporte()
    {
          Excel::create('Autor registrados', function($excel) 
        {
            $excel->sheet('Autores ', function($sheet) 
            {  
                $products = autor::select('nombre','apellidos','nacionalidad')->get();
               
                $orders = Collection::make($products);
                $sheet->fromArray($orders);
            });
        })->download('xlsx');
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
    //funcion para la disponibilidad
   
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
        $libro=autor::find($id);
        $libro->delete();
        return 'Autor borrado';
    }

}
