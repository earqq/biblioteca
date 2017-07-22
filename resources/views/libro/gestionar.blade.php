@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')

	<div class="panel-order">
		<a href="{{URL::to('autor')}}"><i class="fa fa-street-view"></i><p>Autores</p><h3>29</h3></a>
		<a href="{{URL::to('libro')}}"><i class="fa fa-book"></i><p>Libros</p><h3>49</h3></a>
		<a href="{{URL::to('user')}}"><i class="fa fa-users"></i><p>Usuarios</p><h3>19</h3></a>
	</div>


		<!-- <div class="panel panel-default">
	  		<div class="panel-body">
	  			<a href="{{URL::to('escuela')}}">Escuela</a>
			</div>
		</div>
		<div class="panel panel-default">
	  		<div class="panel-body">
	  			<a href="{{URL::to('categoria')}}">Categoria</a>
			</div>
		</div>
	 -->
	@endsection()
	@section('script')

	@endsection()
