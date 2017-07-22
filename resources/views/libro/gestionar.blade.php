@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')


	<div class="panel-order">
		<a href="{{URL::to('recurso')}}"><i class="fa fa-street-view"></i><p>Gestion Bibliotecaria</p><h3>29</h3></a>
		<a href="{{URL::to('user_preindex')}}"><i class="fa fa-book"></i><p>Adm. Usuario</p><h3>49</h3></a>
		<a href="{{URL::to('servicios')}}"><i class="xa fa-users"></i><p>Servicios</p><h3>19</h3></a>
	</div>


		<!-- <div class="panel panel-default">
	  		<div class="panel-body">
	  			<a href="{{URL::to('escuela')}}">Escuela</a>

			</div>
		</div>
		<div class="panel panel-default">
	  		<div class="panel-body">
	  			<a href="{{URL::to('servicios')}}">Servicios</a>
			</div>
		</div>
		
	 -->
	@endsection()
	@section('script')

	@endsection()
