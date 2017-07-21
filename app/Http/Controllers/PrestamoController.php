<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use  App\libro;
use  App\prestamo;
use  App\user;
use  App\datawarehouse;
use  App\dim_libro;
use  App\autor;
use  App\dim_usuario;
use  App\dim_tiempo;
use Auth;
use Excel;
use Illuminate\Support\Collection as Collection;
use Datetime;
use DateInterval;
use Arrayobject;
class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
         $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                $dia=$dias[date("w")];
       return view('prestamo.index',compact('dia'));
    }
    public function indexbusqueda()
    {   
      
       return redirect('/');
    }
    public function indexusuario()
    {
        return view('usuario.prestamos');
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
    public function dashboard($tipo)
    {
       
        $id_empresa=Auth::user()->id_empresa;
            if($tipo=='Hoy')
            {
                $fecha_inicio = new Datetime;
                                  
                $ventas=new Arrayobject();
                
                    $ventas['Hoy'][0]=prestamo::where('fecha_devolucion',$fecha_inicio->format('Y-m-d'))->where('estado','1')->count('id');  
               
                    $ventas['Hoy'][1]=prestamo::where('fecha_prestamo',$fecha_inicio->format('Y-m-d'))->count('id');
              
                return $ventas;
            }
            elseif($tipo=='Semana')
            {
                $fecha = new Datetime;
                $fecha1= strtotime($fecha->format('Y-m-d'));
                switch (date('w',$fecha1))
                {
                    case '0':{
                                $fecha->sub(new DateInterval('P6D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;                                
                            }
                        break;
                    case '1':{
                                $fecha_inicio=$fecha;
                                $fecha_fin=new Datetime;

                             }
                        break;
                    case '2':{
                                $fecha->sub(new DateInterval('P1D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '3':{
                                $fecha->sub(new DateInterval('P2D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '4':{
                                $fecha->sub(new DateInterval('P3D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '5':{
                                $fecha->sub(new DateInterval('P4D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;
                            }
                        break;
                    case '6':{
                                $fecha->sub(new DateInterval('P5D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                } 

                             
                $ventas=new Arrayobject();
              
                /*Lunes*/
              
                
                    $ventas['Lunes'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->format('Y-m-d'))->where('estado','1')->count('id');  
                
                    $ventas['Lunes'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');




                    $ventas['Martes'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 

                
                     $ventas['Martes'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
             
                
               
               
                    
                    $ventas['Miercoles'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 

              
                     $ventas['Miercoles'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                
               
                /*Jueves*/
               
                    
                    $ventas['Jueves'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 

                
                     $ventas['Jueves'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                
                 /*Viernes*/
              
               
                    
                    $ventas['Viernes'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 

                     $ventas['Viernes'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                 
                 /*Sabado*/
            
        
                    $ventas['Sabado'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

               
                     $ventas['Sabado'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                    
                 /*Domingo*/
                 

                    
                    $ventas['Domingo'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->sum('id'); 

                
                     $ventas['Domingo'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                

                return $ventas;   
            }
            elseif($tipo=='Mes')
            {
                $fecha = new Datetime;
                $mes = $fecha->format('m');
                $numero = cal_days_in_month(CAL_GREGORIAN, $mes, $fecha->format('Y'));
                $fecha_inicio=$fecha->format('Y').'-'.$mes.'-01';  
                $fecha_inicio= new Datetime($fecha_inicio);                       
                $ventas=new Arrayobject();
             
              
                    $ventas['1'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->format('Y-m-d'))->where('estado','1')->count('id');
                    $ventas['1'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                    $ventas['2'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                     $ventas['2'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                     $ventas['3'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                     $ventas['3'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                     $ventas['4'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                      $ventas['4'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                      $ventas['5'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                       $ventas['5'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                       $ventas['6'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                        $ventas['6'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                        $ventas['7'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                        $ventas['7'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                        $ventas['8'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                        $ventas['8'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                        $ventas['9'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                         $ventas['9'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                         $ventas['10'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id');
                          $ventas['10'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                          $ventas['11'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                           $ventas['11'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                           $ventas['12'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['12'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                             $ventas['13'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['14'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['14'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['15'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['15'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['16'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['16'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['17'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['17'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['18'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['18'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['19'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['19'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['20'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['20'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['21'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['21'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['22'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['22'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['23'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['23'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['24'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['24'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['25'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['25'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['26'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['26'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['27'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                             $ventas['27'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            $ventas['28'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                            $ventas['28'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            if($numero > 28)
                            {
                                $ventas['29'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                                $ventas['29'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            }
                            if($numero > 29)
                            {
                                $ventas['30'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                                $ventas['30'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            }
                            if($numero > 30)
                            {
                                $ventas['31'][0]=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->where('estado','1')->count('id'); 
                                $ventas['31'][1]=prestamo::where('fecha_prestamo','=',$fecha_inicio->format('Y-m-d'))->count('id');
                            }

                
                

                
                return $ventas;   
            }
            
       
    }
    public function datadashboard($tipo,$fecha){
    
        if($fecha=='Hoy')
            $fecha_inicio=new Datetime;
        else if($fecha=='Semana')
        {
            $fecha = new Datetime;
                $fecha1= strtotime($fecha->format('Y-m-d'));
                switch (date('w',$fecha1))
                {
                    case '0':{
                                $fecha->sub(new DateInterval('P6D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;                                
                            }
                        break;
                    case '1':{
                                $fecha_inicio=$fecha;
                                $fecha_fin=new Datetime;

                             }
                        break;
                    case '2':{
                                $fecha->sub(new DateInterval('P1D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '3':{
                                $fecha->sub(new DateInterval('P2D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '4':{
                                $fecha->sub(new DateInterval('P3D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '5':{
                                $fecha->sub(new DateInterval('P4D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;
                            }
                        break;
                    case '6':{
                                $fecha->sub(new DateInterval('P5D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                } 
        }
        else if ($fecha=='Mes') 
        {
            $fecha = new Datetime;
            $mes = $fecha->format('m');
            $numero = cal_days_in_month(CAL_GREGORIAN, $mes, $fecha->format('Y'));
            $fecha_inicio=$fecha->format('Y').'-'.$mes.'-01';  
            $fecha_inicio= new Datetime($fecha_inicio);   
        }
$fecha_inicio=$fecha_inicio->format('Y-m-d');

        if($tipo=='prestamo')
            {
            
                $orders=prestamo::where('fecha_prestamo','>=',$fecha_inicio)->get();

            foreach ($orders as $key => $value)
            {
            
                $value->id_usuario=user::find($value->id_usuario)->name;
                $value->id_libro=libro::find($value->id_libro)->nombre.' '.$value->id_libro=libro::find($value->id_libro)->descripcion;
            
            }
        }
        else if($tipo=='devolucion')
        {
         
                $orders=prestamo::where('fecha_devolucion','>=',$fecha_inicio)->where('estado','1')->get();

            foreach ($orders as $key => $value)
            {
            
                $value->id_usuario=user::find($value->id_usuario)->name;
                $value->id_libro=libro::find($value->id_libro)->nombre.' '.$value->id_libro=libro::find($value->id_libro)->descripcion;
            
            }
        }
        
        return \Datatables::of($orders)->make(true) ; 
    }

    //PARA EL GRAFICO DE INDEX PRESTAMO
    public function grafico($tipo)
    {   //Barras
        if($tipo==1)
        {
             $fecha = new Datetime;
                $fecha1= strtotime($fecha->format('Y-m-d'));
                switch (date('w',$fecha1))
                {
                    case '0':{
                                $fecha->sub(new DateInterval('P6D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;                                
                            }
                        break;
                    case '1':{
                                $fecha_inicio=$fecha;
                                $fecha_fin=new Datetime;

                             }
                        break;
                    case '2':{
                                $fecha->sub(new DateInterval('P1D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '3':{
                                $fecha->sub(new DateInterval('P2D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '4':{
                                $fecha->sub(new DateInterval('P3D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                    case '5':{
                                $fecha->sub(new DateInterval('P4D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;
                            }
                        break;
                    case '6':{
                                $fecha->sub(new DateInterval('P5D'));
                                $fecha_inicio= $fecha;
                                $fecha_fin=new Datetime;}
                        break;
                } 

                             
                $ventas=new Arrayobject();
              
                /*Lunes*/
              
                
                    $ventas['Lunes']=prestamo::where('fecha_devolucion','=',$fecha_inicio->format('Y-m-d'))->count('id');  
                
                    




                    $ventas['Martes']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

                
                     
             
                
               
               
                    
                    $ventas['Miercoles']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

              
                     
                
               
                /*Jueves*/
               
                    
                    $ventas['Jueves']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

                
                     
                
                 /*Viernes*/
              
               
                    
                    $ventas['Viernes']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

                     
                 
                 /*Sabado*/
            
        
                    $ventas['Sabado']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 

               
                     
                    
                 /*Domingo*/
                 

                    
                    $ventas['Domingo']=prestamo::where('fecha_devolucion','=',$fecha_inicio->add(new DateInterval('P1D'))->format('Y-m-d'))->count('id'); 
                    $ventas['tipo']=1;
                
                     
                

                return $ventas;   
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
    public function data()
    {
        $orders=prestamo::where('estado','1')->get();
        foreach ($orders as $key => $value) {
            $value->id_usuario=user::find($value->id_usuario)->name.'-'.user::find($value->id_usuario)->dni;
            $value->id_libro=libro::find($value->id_libro)->nombre;
            $date1=new Datetime($value->fecha_prestamo);
            $actual=new Datetime;
            $dias_transcurridos=$date1->diff($actual);
           
            $value->dias_transcurridos=$dias_transcurridos->format('%a');
            if($value->estado_devolucion==1)
                $value->estado_devolucion='A tiempo';
            elseif($value->estado_devolucion==2)
                $value->estado_devolucion='Tardanza';
            else $value->estado_devolucion='Tardanza con sancion';
            if($value->estado_libro==1)
                $value->estado_libro='En mal estado';
            elseif($value->estado_libro==2)
                $value->estado_libro='Con algunas deficiencias';
            else $value->estado_libro='En buen estado';
        }
        return \Datatables::of($orders)->addColumn('action', 'prestamo.partials.vista')->make(true) ; 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {   
        if($request->tipo_avance==3)
        {
            $prestamo=prestamo::find($request->id_prestamo);
            
            $prestamo->descripcion_prestamo=$request->descripcion;
            $prestamo->estado=0;
            $prestamo->estado_devolucion=$request->estado_devolucion;
            $prestamo->save();

            if($prestamo->save())
            {   
                $fecha=new Datetime;
                $usuario=user::find($prestamo->id_usuario);
                $dim_usuario=new dim_usuario;
                $dim_usuario->nombre=$usuario->name;
                $dim_usuario->dni=$usuario->dni;
                $dim_usuario->direccion=$usuario->direccion;
                $dim_usuario->save();
                $dim_tiempo=new dim_tiempo;
                $dim_tiempo->fecha=$fecha;
                setlocale(LC_ALL,"es_ES");
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                $dim_tiempo->dia_semana=$dias[date("w")];
                $dim_tiempo->dia_mes=$fecha->format('d');
                $dim_tiempo->mes=$fecha->format('m');
                $dim_tiempo->anio=$fecha->format('Y');
                if($fecha->format('m')>6)
                    $dim_tiempo->ciclo='Impar';
                else $dim_tiempo->ciclo='Par';
                $dim_tiempo->save();
                $dim_libro=new dim_libro;   
                $libro=libro::find($prestamo->id_libro);
                $dim_libro->nombre=$libro->nombre;
                $dim_libro->autor=autor::find($libro->id_autor)->nombre;
                $dim_libro->descripcion=$libro->descripcion;
                $dim_libro->save();
                $dw_hechos=new datawarehouse;
                $dw_hechos->id_libro=$dim_libro->id;
                $dw_hechos->id_usuario=$dim_usuario->id;
                $dw_hechos->id_tiempo=$dim_tiempo->id;
               
                $esta= array("1","Buen estado","Con algunas deficiencias","Mal estado");
            
                $dw_hechos->estado_devolucion=$prestamo->estado_devolucion;
                $dw_hechos->estado_libro=$esta[$prestamo->estado_libro];
                $dw_hechos->save();

            }
            

            return 'Libro devuelto';
        }
        else{
        $prestamo= new prestamo;
        $prestamo->id_usuario=Auth::user()->id;
        $prestamo->id_libro=$request->id_libro;
        $prestamo->fecha_prestamo=new Datetime;
        $fechaDev=new Datetime($request->get('fecha_devolucion'));
        $prestamo->fecha_devolucion= $fechaDev->format('Y-m-d');
        $prestamo->estado_libro=$request->estado_libro;
        $prestamo->estado=1;
        $prestamo->descripcion_usuario=$request->get('descripcion');
        $prestamo->estado_devolucion=1;
        $prestamo->save();
        return 'Prestamo exitoso';
        }
    }

    //Funcion para obtener una habitacion
    //@Param $request -> viene el id de la habitacion
    public function get(Request $request)
    {   
        $prestamo=prestamo::find($request->get('id'));
            $prestamo->id_usuario=user::find($prestamo->id_usuario)->name.'-'.user::find($prestamo->id_usuario)->dni;
            $prestamo->id_libro=libro::find($prestamo->id_libro)->nombre;
         $date1=new Datetime($request->fecha_prestamo);
            $actual=new Datetime;
            $dias_transcurridos=$date1->diff($actual);
           
            $prestamo->dias_transcurridos=$dias_transcurridos->format('%a');
            if($prestamo->estado_devolucion==1)
                $prestamo->estado_devolucion='A tiempo';
            elseif($prestamo->estado_devolucion==2)
                $prestamo->estado_devolucion='Tardanza';
            else $prestamo->estado_devolucion='Tardanza con sancion';
              if($prestamo->estado_libro==1)
                $prestamo->estado_libro='En mal estado';
            elseif($prestamo->estado_libro==2)
                $prestamo->estado_libro='Con algunas deficiencias';
            else $prestamo->estado_libro='En buen estado';
        return $prestamo;
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
      
    }
    public function reporte_index()
    {
        return view('reporte.prestamo');
    }
     public function reporte($tipo)
     {
          Excel::create('Prestamos realizados', function($excel) use ($tipo)
        {
            $excel->sheet('Prestamos ', function($sheet) use ($tipo)
            {  
                $products = prestamo::select('id_usuario','id_libro','fecha_prestamo','fecha_devolucion','descripcion_pestramo')->where('estado',$tipo)->get();
                foreach ($products as $key => $value) {
                   $value->id_usuario=user::find($value->id_usuario)->name.' '.user::find($value->id_usuario)->apellidos;
                   $value->id_libro=libro::find($value->id_libro)->nombre.' '.libro::find($value->id_libro)->descripcion;
                }
                $orders = Collection::make($products);
                $sheet->fromArray($orders);
            });
        })->download('xlsx');
     }
}
