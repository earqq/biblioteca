<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use  App\libro;
use  App\categoria;
use  App\prestamo;
use Datetime;
use Arrayobject;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
      
       return view('categoria.index');
    }
    public function grafico()
    {
        //barras

        $categorias=categoria::all();
        $fecha= new Datetime;
        $mes=$fecha->format('m');
        $mes2=intval($mes)+1;
        $año=$fecha->format('Y');
        $fecha1=$año.'-'.$mes.'-01';
        $fecha2=$año.'-'.$mes2.'-01';
        $prestamos=prestamo::where('fecha_prestamo','>=',$fecha1)->where('fecha_prestamo','<',$fecha2)->get();

        $datos=new Arrayobject();
        $datos1=new Arrayobject();
        $datos2=new Arrayobject();
        $datos3=new Arrayobject();
        foreach ($categorias as $key => $categoria) {
             $datos[$categoria->nombre]=0;
            foreach ($prestamos as $key => $prestamo)
            {      
                    $libro=libro::find($prestamo->id_libro);
                    if($libro->id_categoria==$categoria->id)
                    {
                        $datos[$categoria->nombre]=$datos[$categoria->nombre]+1;
                    }
                    
            }
        }   
        $datos1=array();
        $datos2=array();
        foreach ($datos as $key => $value) {
           array_push($datos1,$key);
           array_push($datos2,$value);
        }
        $datos3['datos']=$datos1;
        $datos3['valor']=$datos2;
        return $datos3;   
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
        $orders=categoria::all();
        
        return \Datatables::of($orders)->addColumn('action', 'categoria.partials.vista')->make(true) ; 
    }
     public function reporte()
    {
        return view('reporte.categoria');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {   
   
       if($request->crear_area==0)
           $libro=new categoria;
       else $libro=categoria::find($request->get('id_categoria'));
            $libro->nombre=$request->nombre;
            $libro->descripcion=$request->descripcion;
          
            $libro->save();
           return 'Categoria guardada';
        
    }

    //Funcion para obtener una habitacion
    //@Param $request -> viene el id de la habitacion
    public function get(Request $request)
    {
        $categoria= categoria::find($request->id);

        return $categoria;
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
       $categoria=categoria::find($id);
        $categoria->delete();
        return 'Categoria borrado';
    }

}
