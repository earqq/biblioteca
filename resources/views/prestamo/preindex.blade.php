@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')

		<div class="panel-order po-2">
			<a href="{{URL::to('prestamo')}}"><i class="fa fa-calendar-o"></i><p>Prestamos</p></a>
			<a href="{{URL::to('sancion')}}"><i class="fa fa-exclamation-circle"></i><p>Sanciones</p></a>
		</div>

	@endsection()
	@section('script')

	@endsection()
