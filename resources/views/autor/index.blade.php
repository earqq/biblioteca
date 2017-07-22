@extends('principal.index')
	@section('titulo')
		Autores
	@endsection()
	<link rel="stylesheet" href="{{asset('css/style.css')}}">
	@section('content')

	<div class="sanciones_form panel panel-default  padding-box ">
	  <button onclick="abrir();" class="btn btn-accent">Autor nuevo</button>
		<div class="container-fluid table-container ">
				<table   id="example" class="table table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Apellidos</th>
							<th>Nacionalidad</th>
							

							<th>Acciones</th>
						</tr>
					</thead>
				</table>
			<br/>
		</div>
	</div>
	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

 <div >
	 <div >
		 <div class="bar panel panel-default padding-box">
			 <div class="title-section">
				 <h3>Autores mas solicitados por mes</h3>
			 </div>
			 <canvas id="myChart" class="chart"></canvas>
		 </div>
		 
	 </div>
 </div>
 @include('autor.partials.modal-autor')
 @endsection
 @section('script')
 <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>
 <script src="{{asset('js/Chart.js/dist/chart.js')}}"></script>
<script>

	// graficos

	function chart(){
		   var route="./grafico/autor/"o;
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,

            type:'GET',
                    success: function(result) {
                      
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
                    }
                      });
                    
                    }

                });


		var ctx = document.getElementById("myChart").getContext('2d');

		var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange","Orange","Orange","Orange","Orange"],
						datasets: [{
								label: '# of Votes',
								data: [12, 19, 3, 5, 2, 3,3,3,3,3,],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
										'rgba(255,99,132,1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
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


	function abrir(){
		$('#form-autor')[0].reset();
	 	$('#crear').val('0');
		$('#modal').modal('show');
	}
	function eliminar(id){
		var route="./autor/"+id;
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
		var route="./get/autor";
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
			$("#mapellidos").val(result.apellidos);
			$("#mnacionalidad").val(result.nacionalidad);
			

			$("#mid_autor").val(result.id);
		
			$('#modal').modal('show');
	        $('#crear').val('1');
	        }
		});
	}

	/*Carga todos los productos y los agrega a la tabla*/


    function tableResposive(id, size){
      if($(window).width() < size ){

          var hijos = $(id + " > thead > tr").children();
          var hijos_responsive = $(id + " > tbody > tr").children();
          var numeroFilas = $(id + " > tbody > tr").length;
          var i=0,j=0, flag = 0;

          console.log($(id).children()[1])

          while(i < hijos.length) {

            console.log(hijos_responsive.eq(j).text());

            hijos_responsive.eq(j).html("<b>"+hijos.eq(i).text()+": </b>"+hijos_responsive.eq(j).text())
            i++;
            j++;
            if(i===(hijos_responsive.length/numeroFilas) && flag <= (hijos_responsive.length/numeroFilas)-1){
              i=0;
              flag++;
            }

          }
        $(id + "> thead").css({
          "display" : "none"
        });
        $(id + "> tbody tr").css({
          "display" : "flex",
          "flex-direction" : "column",
          "position": "relative"
        });

        $(id + "> tbody tr td ").css({
          "font-size" : "12px",
          "display": "flex",
          "justify-content": "space-between",
          "align-items": "center",
          "position": "absolute",
          "opacity": "0",
          "z-index": "-1"
        });

        $(id + "> tbody tr td:first-child ").css({
          "position": "relative",
          "z-index": "1",
          "background-color": "whitesmoke",
          "opacity": "1"
        });

        var active = true;

            // $(id).css({
            //  "width": "100%"
            // })

          $(id + "> tbody tr td:first-child ").click(function(){
            if(active==true){
            $(this).parent().css({
              "border" : "1px solid #cecece"
            });
            $(this).siblings().css({
              "position": "relative",
              "opacity": "1",
              "z-index": "1"

            })
            active = false;
          }else{
            $(this).parent().css({
              "border" : "none"
            });
            $(this).siblings().css({
              "position": "absolute",
              "opacity": "0"

            })
            active = true;
          }
          });


      }

    }

	$(document).ready(function() {

		chart();

  	/*Para el registro de nuevo producto o edicion*/
  	$('#example').DataTable( {
	    "processing": true,
	    "serverSide": true,
	    'bFilter':true,
	    "columnDefs": [
	        {
	            "targets": [ 3 ],
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
	    "ajax": "./api/autor",
	    'columns':[


	    	{data: 'nombre'},
	    	{data: 'apellidos'},
	    	{data: 'nacionalidad'},
	    	


	    	{data: 'action'},
	    ]
	});

tableResposive("#example", 980);

  	$('#btn-addlibro').click(function(){

  		var form=$('#form-autor');
  		var url=form.attr('action');
  		var divresul = "notificaciones_result";
  		var dataString = new FormData(document.getElementById("form-autor"));
  		var token=$("#token").val();
	     $.ajax({
		headers:{'X-CSRF-TOKEN':token},
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
				contentType: false,
			processData: false,

            success: function(autor) {

            	$('#crear').val('0');
            	$('#form-autor')[0].reset();
       	 		$('#example').DataTable().ajax.reload();
       	 		alert(autor);
            }

        });
	});


		 });




	</script>

@endsection
