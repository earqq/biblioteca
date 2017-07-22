@extends('principal.index')
	@section('titulo')
		Reporte Usuarios
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')
		<div class="panel-order po-2">

			<a href="{{URL::to('reportes/user/1')}}"><i class="fa fa-users"></i><p>Usuarios</p></a>
			<a href="{{url('reportes/user/2')}}"><i class="fa fa-universal-access"></i><p>Trabajadores</p></a>

		</div>


	@endsection()
	@section('script')


	@endsection()
