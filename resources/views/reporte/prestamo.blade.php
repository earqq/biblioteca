@extends('principal.index')
	@section('titulo')
		Reporte Prestamos
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')

	<div class="panel-order po-2">
		<a href="{{URL::to('reporte/prestamo/1')}}"><i class="fa fa-calendar-o"></i><p>Prestamos en curso</p></a>
		<a href="{{url('reporte/prestamo/0')}}"><i class="fa fa-calendar-times-o"></i><p>Prestamos devueltos</p></a>
	</div>



	@endsection()
	@section('script')


	@endsection()
