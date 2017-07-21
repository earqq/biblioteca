@extends('principal.index')
	@section('titulo')
		Reporte Prestamos
	@endsection()
	@section('content')
			<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('reporte/prestamo/1')}}">Prestamos en curso</a>
			</div>
		</div>			
	<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{url('reporte/prestamo/0')}}">Prestamos devueltos</a>
			</div>
		</div>	
	
	
	@endsection()
	@section('script')		
	
		
	@endsection()