@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')
	
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('escuela')}}">Escuela</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('user')}}">Usuarios</a>
			</div>
		</div>
		
	 
	@endsection()
	@section('script')		
	
	@endsection()