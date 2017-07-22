@extends('principal.index')
	@section('titulo')
		Reportes
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')

	<div class="panel-order">

		<a href="{{url('reportes/libro')}}"><i class="fa fa-book"></i><p>Libros</p></a>
		<a href="{{URL::to('reportes/user_index')}}"><i class="fa fa-users"></i><p>Usuarios</p></a>
		<a href="{{URL::to('reporte/prestamo')}}"><i class="fa fa-ticket"></i><p>Prestamos</p></a>

	</div>


	@endsection()
	@section('script')

	@endsection()
