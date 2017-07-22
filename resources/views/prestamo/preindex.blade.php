@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')
	
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('prestamo')}}">Prestamos</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('sancion')}}">Sanciones</a>
			</div>
		</div>
		
		
	 
	@endsection()
	@section('script')		
	
	@endsection()