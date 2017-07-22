<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use  App\libro;
use  App\categoria;
use  App\escuela;
use  App\prestamo;
use  App\user;
use Datetime;
use Arrayobject;
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
    public function grafico($tipo)
    {
        //Barras
        if($tipo==1)
        {
             $escuelas=escuela::all();
            $fecha= new Datetime;
           
            $usuarios=user::all();

            $datos=new Arrayobject();
            $datos1=new Arrayobject();
            $datos2=new Arrayobject();
            $datos3=new Arrayobject();
            foreach ($escuelas as $key => $escuela) {
                 $datos[$escuela->nombre]=0;
                foreach ($usuarios as $key => $user)
                {      
                        
                        if($user->id_escuela==$escuela->id)
                        {
                            $datos[$escuela->nombre]=$datos[$escuela->nombre]+1;
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
            
        }//Pastel
        else
        {
            $escuelas=escuela::all();
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
            foreach ($escuelas as $key => $escuela) {
                 $dato=0;
                foreach ($prestamos as $key => $prestamo)
                {       $user=user::find($prestamo->id_usuario);
                        if($user->id_escuela==$escuela->id)
                        {   
                            $dato++;
                            
                        }
                        
                }
                $datos1[$contador]=$escuela->nombre;
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
        }
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
