@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')


		<div class="panel-order po-2">
			<a href="{{URL::to('escuela')}}"><i class="fa fa-university"></i><p>Escuela</p></a>
			<a href="{{URL::to('user')}}"><i class="fa fa-users"></i><p>Usuarios</p></a>
		</div>

	@endsection()
	@section('script')

	@endsection()
