@extends('principal.index')
	@section('titulo')
		Reportes
	@endsection()
	@section('content')

	<div class="panel-order">
	
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{url('reportes/libro')}}">Libros</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('reportes/user_index')}}">Usuarios</a>
			</div>
		</div>
		
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('reporte/prestamo')}}">Prestamos</a>
			</div>

		</div> 

	</div>
		
	
	@endsection()
	@section('script')		
	
	@endsection()