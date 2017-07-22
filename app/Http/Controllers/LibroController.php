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
use Excel;
use Illuminate\Support\Collection as Collection;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $autores=autor::all();
       return view('libro.index',compact('autores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {           
               

    }
    public function grafico($tipo)
    {   //Barras
        if($tipo==1)
        {
           
            $libros=libro::all();
            $fecha= new Datetime;
            $mes=$fecha->format('m');
            $mes2=intval($mes)+1;
            $año=$fecha->format('Y');
            $fecha1=$año.'-'.$mes.'-01';
            $fecha2=$año.'-'.$mes2.'-01';
            $prestamos=prestamo::where('fecha_prestamo','>=',$fecha1)->where('fecha_prestamo','<',$fecha2)->get();

            $datos=array();
            $datos1=new Arrayobject();
            $datos2=new Arrayobject();
            $datos3=new Arrayobject();
            $contador=0;
            foreach ($libros as $key => $libro) {
                 $dato=0;
                foreach ($prestamos as $key => $prestamo)
                {      
                        if($prestamo->id_libro==$libro->id)
                        {   
                            $dato++;
                            
                        }
                        
                }
                $datos1[$contador]=$libro->nombre;
                $datos2[$contador]=$dato;
                $contador++;
            }   
            
            //ordenando

            for ($i=0; $i < count($datos2)-1; $i++) 
            { 
              for ($j=0; $j <count($datos2)-1; $j++) { 
                      if($datos2[$j]<$datos2[$j+1])   
                      { 
                        $aux=$datos2[$j+1];
                        $aux2=$datos1[$j+1];
                        $datos2[$j+1]=$datos2[$j];
                        $datos1[$j+1]=$datos1[$j];

                        $datos2[$j]=$aux;
                        $datos1[$j]=$aux2;

                      }
                   }     
            }

            $datos4=array();
            $datos5=array();
            foreach ($datos1 as $key => $value) {
               array_push($datos4,$value);
               
            }
            foreach ($datos2 as $key => $value) {
               array_push($datos5,$value);
               
            }

            $datos1=array_slice($datos4, 0, 7);
            $datos2=array_slice($datos5, 0, 7);
            $datos3['datos']=$datos1;
            $datos3['valor']=$datos2;
            return $datos3;   
        }//Pastel
        else
        {
            $prestamo=new Arrayobject();
            $fecha= new Datetime;
            $prestamo['devolver']=prestamo::where('fecha_devolucion',$fecha->format('Y-m-d'))->where('estado',1)->count('id');
            $prestamo['devueltos']=prestamo::where('fecha_devolucion',$fecha->format('Y-m-d'))->where('estado',0)->count('id');
            $prestamo['tipo']=2;
            return $prestamo;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function data()
    {
        $orders=libro::all();
        foreach ($orders as $key => $value) {
          
            if(count(autor::find($value->id_autor)))
                $value->id_autor=autor::find($value->id_autor)->nombre;
            else $value->id_autor='No asignado';
               
        }
        return \Datatables::of($orders)->addColumn('action', 'libro.partials.vista')->make(true) ; 
    }
    public function data_prestar()
    {
        $orders=libro::all();
        foreach ($orders as $key => $value) {
          
            if(count(autor::find($value->id_autor)))
                $value->id_autor=autor::find($value->id_autor)->nombre;
            else $value->id_autor='No asignado';
               
        }
        return \Datatables::of($orders)->addColumn('action', 'libro.partials.vista_prestar')->make(true) ; 
    }
   public function store(Request $request)
    {   
        if($request->crear_libro==0)
           $libro=new libro;
       else $libro=libro::find($request->get('id_libro'));
            $libro->nombre=$request->nombre;
            $libro->descripcion=$request->descripcion;
            $libro->id_autor=$request->id_autor;
            $libro->fecha_publicacion=$request->fecha_publicacion;
            $libro->fecha_adquisicion=$request->fecha_adquisicion;
            $libro->estado_libro=$request->estado_libro;
            $libro->save();
           return 'Libro guardado';
        

    }
    public function buscar_libro()
    {
        return view('libro.buscar');
    }
    //Funcion para obtener una habitacion
    //@Param $request -> viene el id de la habitacion
    public function get(Request $request)
    {
        $libro= libro::find($request->id);

        return $libro;
    }
    public function reporte()
    {   
        
        Excel::create('Libros de biblioteca', function($excel) 
        {
            $excel->sheet('Libros ', function($sheet) 
            {  
                $products = libro::select('nombre','descripcion','id_autor','ejemplares','fecha_publicacion')->get();
               foreach ($products as $key => $value) {
                   $value->id_autor=autor::find($value->id_autor)->nombre.' '.autor::find($value->id_autor)->apellidos;
               }
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
        $libro=libro::find($id);
        $libro->delete();
        return 'Libro borrado';
    }

}
