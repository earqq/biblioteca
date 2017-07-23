@extends('principal.index')
	@section('titulo')
		Gestionar
	@endsection()
	@section('content')

	<div class="tab-button ">
		<div class="tab active">
			<i class="fa fa-ticket"></i>&nbsp;&nbsp;<p>Historial de Prestamos</p>
		</div>

		<div class="tab" >
			<i class="fa fa-exclamation"></i>&nbsp;&nbsp;<p>Historial de Sanciones</p>
		</div>
	</div>


	<div class="row box-body">
			<div class="profile-empresa-content ">
				<div class="profile-tab active">
					<div class="sanciones_form panel panel-default padding-box ">
				     <div class="container-fluid  ">
				         <table   id="example" class="table table-hover   ">
				           <thead>
				             <tr>
				               <th>Usuario</th>
				               <th>Libro</th>
				               <th>Fecha prestamo</th>
				               <th>Fecha devolucion</th>
				               <th>Dias transcurridos</th>
				               <th>Estado devolucion</th>
				               <th>Devolver</th>
				             </tr>
				           </thead>
				         </table>
				       <br/>
				     </div>
				   </div>


				  <div class="chart-libros">
				    <div class="chart-libros-wrapper">
				      <div class="bar chart-section panel panel-default padding-box">
				        <div class="title-section">
				          <h3><i class="fa fa-bar-chart"></i>&nbsp;Numero de devoluciones</h3>
				        </div>
				        <canvas id="myChart" class="chart"></canvas>
				      </div>
				      <div class="doughnut chart-section panel panel-default padding-box">
				        <div class="title-section">
				          <h3><i class="fa fa-bar-chart"></i>&nbsp;Devoluciones {{$dia}}</h3>
				        </div>
				        <canvas id="myChart2" class="chart"></canvas>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="profile-tab">
					<div class="sanciones_form panel panel-default padding-box ">
						 <div class="container-fluid  ">
								 <table   id="example" class="table table-hover   ">
									 <thead>
										 <tr>
											 <th>Usuario</th>
											 <th>Libro</th>
											 <th>Fecha prestamo</th>
											 <th>Fecha devolucion</th>
											 <th>Dias transcurridos</th>
											 <th>Estado devolucion</th>
											 <th>Devolver</th>
										 </tr>
									 </thead>
								 </table>
							 <br/>
						 </div>
					 </div>


					<div class="chart-libros">
						<div class="chart-libros-wrapper">
							<div class="bar chart-section panel panel-default padding-box">
								<div class="title-section">
									<h3>Numero de devoluciones</h3>
								</div>
								<canvas id="myChart" class="chart"></canvas>
							</div>
							<div class="doughnut chart-section panel panel-default padding-box">
								<div class="title-section">
									<h3>Devoluciones {{$dia}}</h3>
								</div>
								<canvas id="myChart2" class="chart"></canvas>
							</div>
						</div>
					</div>

				</div>
			</div>
	</div>

	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    @include('prestamo.partials.modal-prestamo')

	@include('categoria.partials.modal-categoria')
		 @include('autor.partials.modal-autor')

	 @include('libro.partials.modal-libro')

	@endsection()
	@section('script')
	<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>
	<script src="{{asset('js/Chart.js/dist/chart.js')}}"></script>
<script>

function showEmpresa(){
	      $(".tab").click(function()
	      {
	        $(".profile-tab").eq($(this).index()).addClass("active");
	        $(".profile-tab").eq($(this).index()).siblings().removeClass("active");
	        $(this).addClass("active");
	        $(this).siblings().removeClass("active");
	      })
	    }

// graficos

function chart(tipo_grafico){

				var route="./prestamo/grafico/"+tipo_grafico;
						var token=$("#token").val();
						 $.ajax({
						headers:{'X-CSRF-TOKEN':token},
						url:route,

						type:'GET',
										success: function(result) {
											if(result.tipo==1)
											{
												var ctx = document.getElementById("myChart").getContext('2d');
												var myChart = new Chart(ctx,
												{
												type: 'bar',
												data: {
														labels: ["Lunes", "Martes", "Miercoles", "Jueves","Viernes", "Sabado", "Domingo"],
														datasets: [{
																label: '# de devoluciones',
																data: [result.Lunes, result.Martes, result.Miercoles, result.Jueves, result.Viernes, result.Sabado,result.Domingo],
																backgroundColor: [
																		'rgba(255, 99, 132, 0.2)',
																		'rgba(54, 162, 235, 0.2)',
																		'rgba(255, 206, 86, 0.2)',
																		'rgba(75, 192, 192, 0.2)',
																		'rgba(153, 102, 255, 0.2)',
																		'rgba(255, 159, 64, 0.2)',
																		'rgba(255, 159, 64, 0.2)'
																],
																borderColor: [
																		'rgba(255,99,132,1)',
																		'rgba(54, 162, 235, 1)',
																		'rgba(255, 206, 86, 1)',
																		'rgba(75, 192, 192, 1)',
																		'rgba(153, 102, 255, 1)',
																		'rgba(255, 159, 64, 1)',
																		'rgba(255, 159, 64, 1)'
																],
																borderWidth: 1
														}]
												},
												options: {
														scales: {
																yAxes: [{
																		ticks: {
																				beginAtZero:true
																		}
																}]
														}
												}
											});
										}
										else
										{

											var ctx2 = document.getElementById("myChart2").getContext('2d');
											var myChart2 = new Chart(ctx2, {
														type: 'pie',
														data: {
																labels: ["Libros a devolver", "Libros devueltos"],
																datasets: [{
																		label: '# of Votes',
																		data: [result.devolver, result.devueltos],
																		backgroundColor: [
																				'rgba(255, 99, 132, 0.2)',
																				'rgba(54, 162, 235, 0.2)'
																		],
																		borderColor: [
																				'rgba(255,99,132,1)',
																				'rgba(54, 162, 235, 1)'
																		],
																		borderWidth: 1
																}]
														},
														options: {
																rotate: -0.5 * Math.PI
														}
												});

										}

										}

								});





}



	function abrir(){
		$('#form-prestamo')[0].reset();
		$('#crear').val('0');
		$('#modal').modal('show');
	}
	function eliminar(id){
		var route="./productos/"+id;
		var data=id;
		var token=$("#token").val();
		var divresul = "notificaciones_result";
		$.ajax({
		headers:{'X-CSRF-TOKEN':token},
		url:route,
		data:data,
		type:'DELETE',

		success: function(result){
			$('#example').DataTable().ajax.reload();
			$("#"+divresul+"").html(result);
			}
		});
	}

	/*Agregar productos a tienda*/
	function aumentar(id){
			var nombre=$("#n"+id).text();
			$("#nombreprod").text('Agregar '+nombre+' a tienda');
		$("#mid_tiendaprod").val(id);
		$('#modal1').modal('show');
			$('#crear').val('1');
	}
		/*Pasar los datos al modal*/
	function devolver(id){
		var route="./get/prestamo";
			var data={
			'id':id
		};
		var token=$("#token").val();
			 $.ajax({
		headers:{'X-CSRF-TOKEN':token},
		url:route,
		data:data,
		type:'GET',
					success: function(result) {
					$("#musuario").val(result.id_usuario);
			$("#mlibro").val(result.id_libro);
			$("#mfecha_prestamo").val(result.fecha_prestamo);
			$("#mfecha_devolucion").val(result.fecha_devolucion);
			$("#mestado_libro").val(result.estado_libro);
			$("#mestado_devolucion").val(result.estado_devolucion);
			$("#mid_prestamo").val(result.id);



			$('#modal').modal('show');
					$('#crear').val('1');
					}
		});
	}

	/*Carga todos los productos y los agrega a la tabla*/




	$(document).ready(function() {

		chart(1);
		chart(2);
		showEmpresa();

		/*Para el registro de nuevo producto o edicion*/
		$('#example').DataTable( {
			"processing": true,
			"serverSide": true,
			'bFilter':true,
			"columnDefs": [
					{
							"targets": [ 5 ],
							"visible": true,
							"searchable": false
					},


			]  , "oLanguage": {
								"oPaginate": {
						"sNext": "Siguiente",
						"sPrevious": "Anterior",
								},
								"sSearch": "Buscar" ,
								"sInfo": " Mostrando _START_ a _END_ de _TOTAL_ entidades",
								"sLengthMenu": "Mostrar _MENU_ resultados por página",
								"sInfoFiltered": " - filtrando de _MAX_ resultados"
						},
			"ajax": "./api/prestamo",
			'columns':[


				{data: 'id_usuario'},
				{data: 'id_libro'},
				{data: 'fecha_prestamo'},
				{data: 'fecha_devolucion'},
				{data: 'dias_transcurridos'},
				{data: 'estado_devolucion'},

				{data: 'action'},
			]
	});

tableResposive("#example", 980);

		$('#btn-addprestamo').click(function(){

			var form=$('#form-prestamo');
			var url=form.attr('action');
			var divresul = "notificaciones_result";
			var dataString = new FormData(document.getElementById("form-prestamo"));
			$.ajax({
						type: "POST",
						url: url,
						data: dataString,
						cache: false,
				contentType: false,
			processData: false,

						success: function(producto) {



						$('#example').DataTable().ajax.reload();
						alert(producto);
						}

				});
	});
		$('#btn-addtiendaprod').click(function(){

			var form=$('#form-tiendaprod');
			var url=form.attr('action');
			var divresul = "notificaciones_result";

			var dataString = new FormData(document.getElementById("form-tiendaprod"));
			 $.ajax({
						type: "POST",
						url: url,
						data: dataString,
						cache: false,
			contentType: false,
			processData: false,

						success: function(result) {
						$("#"+divresul+"").html(result);
							$('#form-tiendaprod')[0].reset();
							$('#example').DataTable().ajax.reload();
						}
				});
		});


		 });



</script>
	@endsection()
