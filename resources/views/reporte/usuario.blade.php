@extends('principal.index')
	@section('titulo')
		Reporte Usuarios
	@endsection()
	@section('content')
	<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('reportes/user/1')}}">Usuarios</a>
			</div>
		</div>			
	<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{url('reportes/user/2')}}">Trabajadores</a>
			</div>
		</div>
		
	
	@endsection()
	@section('script')		
	
		
	@endsection()