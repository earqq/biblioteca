<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use  App\producto;
use  App\User;
use  App\prestamo;
use Datetime;
use DateInterval;
use Arrayobject;
use Excel;
use Illuminate\Support\Collection as Collection;    
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.index');
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
    public function reporte_index()
    {
        return view('reporte.usuario');

    }
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
                   
                
                     
                

                return $ventas;   
        }//Pastel
        else
        {
            $prestamo=new Arrayobject();
             $fecha= new Datetime;
            $mes=$fecha->format('m');
            $mes2=intval($mes)+1;
            $año=$fecha->format('Y');
            $fecha1=$año.'-'.$mes.'-01';
            $fecha2=$año.'-'.$mes2.'-01';

            $prestamos=prestamo::where('fecha_prestamo','>=',$fecha1)->where('fecha_prestamo','<',$fecha2)->get();
            $prestamo['devolvio']=prestamo::where('fecha_devolucion','>=',$fecha1)->where('fecha_devolucion','<',$fecha2)->where('estado',0)->count('id');
            $prestamo['no_devolvio']=prestamo::where('fecha_devolucion','>',$fecha->format('Y-m-d'))->where('estado',1)->count('id');
            return $prestamo;
        }
    }
    public function reporte($tipo)
    {
          Excel::create('Usuarios de biblioteca', function($excel) use($tipo)
        {
            $excel->sheet('Libros ', function($sheet) use ($tipo)
            {  
                $products = user::select('name','email','dni','telefono','direccion')->where('tipo',$tipo)->get();
               
                $orders = Collection::make($products);
                $sheet->fromArray($orders);
            });
        })->download('xlsx');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if($request->crear=='0')
            $user=new User;
        else             
            $user = User::find($request->id_user);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password = bcrypt($request->password);
            $user->dni=$request->dni;
            $user->fecha_nacimiento=$request->fecha_nacimiento;
            $user->fecha_inscripcion=new Datetime;
            $user->direccion=$request->direccion;
            $user->telefono=$request->telefono;
            $user->tipo=$request->tipo;        
            
            if($request->password==$request->password_2 && $user->save())
            {
                if($request->crear=='0')
                    return 'Usuario creado correctamente';
                else    return 'Usuario editado correctamente';
            }
            else
            { 
                if($request->crear=='0')
                    return 'No se pudo crear el Usuario';
                else    return 'No se pudo editar el Usuario';
            }
      
        
    }

    //Funcion para obtener un producto
    //@Param $request -> viene el id del producto
    public function get(Request $request)
    {
        return User::find($request->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return 'mostrando el user '.$id;
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
       $user = User::find($id);
       $user->delete();
       return 'user eliminado';
    }
    public function data(){
        $orders = User::all();        
        foreach ($orders as $key => $value) {
          if($value->tipo==1)
            $value->tipo='Usuario';
          elseif ($value->tipo==2)
            $value->tipo='Trabajador';
            else $value->tipo='Administrador';
        }
        return \Datatables::of($orders)->addColumn('action','usuario.partials.vista')->make(true);
    }
}
