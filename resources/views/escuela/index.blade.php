@extends('principal.index')
	@section('titulo')
		Escuelas
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')
	<div class="panel panel-default padding-box">
		<button onclick="abrir();" class="btn btn-accent"><i class="fa fa-plus-circle">&nbsp;</i>Nueva Escuela</button>
	</div>
  <div class="sanciones_form panel panel-default padding-box ">
		<div class="container-fluid ">
				<table   id="example" class="table table table-hover table-result  width-all">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Facultad</th>
							<th>Acciones</th>
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
				 <h3>Alumnos por escuela</h3>
			 </div>
 			 <canvas id="myChart" class="chart"></canvas>
 		 </div>
 		 <div class="doughnut chart-section panel panel-default padding-box">
			 <div class="title-section">
				 <h3>Escuela participativa por dia</h3>
			 </div>
 			 <canvas id="myChart2" class="chart"></canvas>
 		 </div>
 	 </div>
  </div>


	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
	@include('escuela.partials.modal-escuela')
 @endsection
 @section('script')
 <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>
 <script src="{{asset('js/Chart.js/dist/chart.js')}}"></script>
<script>


// graficos

function chart(){




		 var route="./grafico/escuela/1";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,
            type:'GET',
                    success: function(result)
                    {

                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx,
                        {
	                        type: 'bar',
	                        data:
	                        {
	                            labels: result.datos,
	                            datasets:
	                            [{
	                                label: '# de libros prestados',
	                                data: result.valor,
	                                backgroundColor:
	                                [
	                                    'rgba(255, 99, 132, 0.2)',
	                                    'rgba(54, 162, 235, 0.2)',
	                                    'rgba(255, 206, 86, 0.2)',
	                                    'rgba(75, 192, 192, 0.2)',
	                                    'rgba(153, 102, 255, 0.2)',
	                                    'rgba(255, 159, 64, 0.2)',
	                                    'rgba(255, 159, 64, 0.2)'
	                                ],
	                                borderColor:
	                                [
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
	                        options:
	                        {
	                            scales:
	                            {
	                                yAxes:
	                                [{
	                                    ticks:
	                                     {
	                                        beginAtZero:true
	                                    }
	                                }]
	                            }
	                        }
                    	});
                	}
                });


             var route="./grafico/escuela/2";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,
            type:'GET',
                    success: function(result)
                    {

                       	var ctx2 = document.getElementById("myChart2").getContext('2d');
						var myChart2 = new Chart(ctx2, {
								type: 'doughnut',
								data: {
										labels: result.datos,
										datasets: [{
												label: '# of Votes',
												data: result.valor,
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
                });


}


	function abrir(){
		$('#form-escuela')[0].reset();
	 	$('#crear').val('0');
		$('#modal').modal('show');
	}
	function eliminar(id){
		var route="./escuela/"+id;
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
		alert(result);
			}
		});
	}


		/*Pasar los datos al modal*/
	function editar(id){
		var route="./get/escuela";
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
	        $("#mnombre").val(result.nombre);
			$("#mdescripcion").val(result.descripcion);


			$("#mid_escuela").val(result.id);

			$('#modal').modal('show');
	        $('#crear').val('1');
	        }
		});
	}

	/*Carga todos los productos y los agrega a la tabla*/



	$(document).ready(function() {

		chart();

  	/*Para el registro de nuevo producto o edicion*/
  	$('#example').DataTable( {
	    "processing": true,
	    "serverSide": true,
	    'bFilter':true,
	    "columnDefs": [
	        {
	            "targets": [ 2 ],
	            "visible": true,
	            "searchable": false
	        },


	    ]  , "oLanguage": {
	           		"oPaginate": {
	 					"sNext": "Siguiente",
	 					"sPrevious": "Anterior",
	           		},
	            	"sSearch": "Buscar"	,
	            	"sInfo": " Mostrando _START_ a _END_ de _TOTAL_ entidades",
	            	"sLengthMenu": "Mostrar _MENU_ resultados por página",
	            	"sInfoFiltered": " - filtrando de _MAX_ resultados"
	         	},
	    "ajax": "./api/escuela",
	    'columns':[


	    	{data: 'nombre'},
	    	{data: 'facultad'},



	    	{data: 'action'},
	    ]
	});

tableResposive("#example", 980);

  	$('#btn-addescuela').click(function(){

  		var form=$('#form-escuela');
  		var url=form.attr('action');
  		var divresul = "notificaciones_result";
  		var dataString = new FormData(document.getElementById("form-escuela"));
  		var token=$("#token").val();
	     $.ajax({
		headers:{'X-CSRF-TOKEN':token},
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
				contentType: false,
			processData: false,

            success: function(user) {

            	$('#crear').val('0');
            	$('#form-escuela')[0].reset();
       	 		$('#example').DataTable().ajax.reload();
       	 		alert(user);
            }

        });
	});


		 });




	</script>

@endsection
