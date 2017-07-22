@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')
	
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('recursos')}}">Recursos bibliograficos</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('user_preindex')}}">Adm. Usuarios</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('servicios')}}">Servicios</a>
			</div>
		</div>
		
	 
	@endsection()
	@section('script')		
	
	@endsection()