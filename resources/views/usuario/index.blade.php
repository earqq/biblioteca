@extends('principal.index')
	@section('titulo')
		Usuarios
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	@section('content')

	<div class="panel panel-default padding-box">
		<button onclick="abrir();" class="btn btn-accent"><i class="fa fa-plus-circle">&nbsp;</i>nuevo usuario</button>
	</div>

  <div class="sanciones_form panel panel-default padding-box ">
		<div class="container-fluid ">
				<table   id="example" class="table table table-hover table-result  width-all">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>DNI</th>
							<th>Direccion</th>
							<th>Telefono</th>
							<th>Tipo</th>
							<th>Fecha inscripcion</th>
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
				 <h3><i class="fa fa-bar-chart">&nbsp;</i>Usuarios activos esta semana </h3>
			 </div>
 			 <canvas id="myChart" class="chart"></canvas>
 		 </div>
 		 <div class="doughnut chart-section panel panel-default padding-box">
			 <div class="title-section">
				 <h3><i class="fa fa-bar-chart">&nbsp;</i>Sancion de usuarios mensual</h3>
			 </div>
 			 <canvas id="myChart2" class="chart"></canvas>
 		 </div>
 	 </div>
  </div>


	@include('usuario.partials.modal-user')
	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
 @endsection
 @section('script')
 <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>
 <script src="{{asset('js/Chart.js/dist/chart.js')}}"></script>


<script>
// graficos

function chart2(){

	  var route="./grafico/user/1";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,

            type:'GET',
                    success: function(result) {

                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx,
                        {
                        type: 'line',
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



                });

             //pastel
              var route="./grafico/user/2";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,

            type:'GET',
                    success: function(result) {

                         var ctx2 = document.getElementById("myChart2").getContext('2d');
                      var myChart2 = new Chart(ctx2, {
                            type: 'pie',
                            data: {
                                labels: ["Usuarios sancionados", "Usuarios no sancionados"],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [result.no_devolvio, result.devolvio],
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
		$('#form-user')[0].reset();
	 	$('#crear').val('0');
		$('#modal').modal('show');
	}
	function eliminar(id){
		var route="./user/"+id;
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
		var route="./get/user";
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
	        $("#mnombre").val(result.name);
			$("#memail").val(result.email);
			$("#mdni").val(result.dni);
			$("#mfecha_inscripcion").val(result.fecha_inscripcion);
			$("#mdireccion").val(result.direccion);
			$("#mtelefono").val(result.telefono);

			$("#mid_user").val(result.id);
			$("#mtipo option[value="+result.tipo+"]").prop('selected', 'selected').change();


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
	            "targets": [ 7 ],
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
	    "ajax": "./api/user",
	    'columns':[


	    	{data: 'name'},
	    	{data: 'email'},
	    	{data: 'dni'},

	    	{data: 'direccion'},
	    	{data: 'telefono'},
	    {data: 'tipo'},
	    {data: 'fecha_inscripcion'},


	    	{data: 'action'},
	    ]
	});



  	$('#btn-adduser').click(function(){

  		var form=$('#form-user');
  		var url=form.attr('action');
  		var divresul = "notificaciones_result";
  		var dataString = new FormData(document.getElementById("form-user"));
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
            	$('#form-user')[0].reset();
       	 		$('#example').DataTable().ajax.reload();
       	 		alert(user);
            }

        });
	});


		 });




	</script>

@endsection
