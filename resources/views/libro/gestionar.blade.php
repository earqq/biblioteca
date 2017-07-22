@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')
<<<<<<< HEAD
	
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('recursos')}}">Recursos bibliograficos</a>
			</div>
		</div>
		<div class="panel panel-default">		
	  		<div class="panel-body">
	  			<a href="{{URL::to('user_preindex')}}">Adm. Usuarios</a>
=======

	<div class="panel-order">
		<a href="{{URL::to('autor')}}"><i class="fa fa-street-view"></i><p>Autores</p></a>
		<a href="{{URL::to('libro')}}"><i class="fa fa-book"></i><p>Libros</p></a>
		<a href="{{URL::to('user')}}"><i class="fa fa-users"></i><p>Usuarios</p></a>
	</div>


		<!-- <div class="panel panel-default">
	  		<div class="panel-body">
	  			<a href="{{URL::to('escuela')}}">Escuela</a>
>>>>>>> dd2583e6cc88a1d26b08af37f1e8b6060b4a5603
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
