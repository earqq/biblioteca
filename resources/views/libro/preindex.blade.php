@extends('principal.index')
	@section('titulo')
		Libros
	@endsection()

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

@section('content')

    <div class="row box-body">
        <div class="tab-button ">
          <div class="tab active" id="perfil-button">
            <i class="fa fa-user"></i>&nbsp;&nbsp;<p>autor</p>
          </div>
          <div class="tab" id="asistencia-button">
            <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;<p>areas</p>
          </div>
         
          <div class="tab" id="asistencia-users-button">
            <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;<p>libros</p>
          </div>

        </div>
        <div class="profile-empresa-content ">
          <div id='perfil' class="profile-tab active">
           			<div class="panel panel-default padding-box">
			<button onclick="abrir_autor();" class="btn btn-accent"><i class="fa fa-plus-circle">&nbsp;</i>Autor nuevo</button>
					</div>
					<div class="sanciones_form panel panel-default  padding-box ">
					<div class="container-fluid table-container ">
							<table   id="example_autor" class="table table-hover">
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
						 <canvas id="myChart_autor" class="chart"></canvas>
					 </div>
					 
				 </div>
			 </div>
          </div>

          <!--Fin autor-->
          <div id='asistencia' class="profile-tab">
          		
			  <div class="sanciones_form panel panel-default padding-box ">
			    <button onclick="abrir_area();" class="btn btn-accent">Nueva Area</button>
					<div class="container-fluid ">
							<table   id="example_area" class="table table table-hover table-result  width-all">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Descripcion</th>
										<th>Acciones</th>
									</tr>
								</thead>
							</table>
						<br/>
					</div>
				</div>

				<div class="chart-libros">
			 	 <div class="chart-libros-wrapper">
			 		 <div class="bar  panel panel-default padding-box">
						 <div class="title-section">
							 <h3>Categorias mas prestadas por mes</h3>
						 </div>
			 			 <canvas id="myChart_area" class="chart"></canvas>
			 		 </div>
			 		
			 	 </div>
			  </div>


				<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
				<!--Fin categoria-->
        </div>
     
        <div id='asistencia-adm' class="profile-tab">
	          <div class="panel panel-default padding-box">
					<button onclick="abrir_libro();" class="btn btn-accent"><i class="fa fa-plus-circle">&nbsp;</i>libro nuevo</button>
				</div>
				<div class="sanciones_form panel panel-default  padding-box ">
					<div class="container-fluid table-container ">
							<table   id="example_libro" class="table table-hover">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Descripcion</th>
										<th>Autor</th>
										<th>Ejemplares</th>
										<th>Estado libros</th>
										<th>Fecha publicacion</th>
										<th>Fecha adquisicion</th>
										<th>Acciones</th>
									</tr>
								</thead>
							</table>
						<br/>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

			 <div class="chart-libros title-content">
				 <div class="chart-libros-wrapper">
					 <div class="bar chart-section panel panel-default padding-box">
						 <div class="title-section">
							 <h3><i class="fa fa-bar-chart"></i>&nbsp;Prestamos por mes</h3>
						 </div>
						 <canvas id="myChart_libro" class="chart"></canvas>
					 </div>
					 <div class="doughnut chart-section panel panel-default padding-box">
						 <div class="title-section">
							 <h3><i class="fa fa-bar-chart"></i>&nbsp;Prestamos por area</h3>
						 </div>
						 <canvas id="myChart2_libro" class="chart"></canvas>
					 </div>
				 </div>
			 </div>
        </div>
     
        </div>


    </div>


@include('categoria.partials.modal-categoria')
	 @include('autor.partials.modal-autor')
	 
 @include('libro.partials.modal-libro')

@endsection

@section('script')
<script type="text/javascript" src="<?=URL::to('js/autocomplete.js');?>"></script>
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">

function showPerfil(){
  $("#perfil-button").click(function(){
    $("#perfil-button").addClass("active");
    $("#asistencia-button").removeClass("active");
    $("#asistencia-users-button").removeClass("active");
    $("#perfil").addClass("active");
    $("#asistencia_adm").removeClass("active");
    $("#asistencia").removeClass("active");
  })
  $("#asistencia-button").click(function(){
    $("#perfil-button").removeClass("active");
    $("#asistencia-button").addClass("active");
    $("#asistencia-users-button").removeClass("active");
    $("#perfil").removeClass("active");
    $("#asistencia-adm").removeClass("active");
    $("#asistencia").addClass("active");
  })
  $("#asistencia-users-button").click(function(){
     $("#perfil-button").removeClass("active");
    $("#asistencia-button").removeClass("active");
    $("#asistencia-users-button").addClass("active");
    $("#perfil").removeClass("active");
    $("#asistencia-adm").addClass("active");
    $("#asistencia").removeClass("active");
  })
}


//Libroooooooooo
	// graficos

	function chart_libro(){

		var ctx = document.getElementById("myChart_libro").getContext('2d');
		var ctx2 = document.getElementById("myChart2_libro").getContext('2d');
		var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
						datasets: [{
								label: '# of Votes',
								data: [12, 19, 3, 5, 2, 3],
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


		var myChart2 = new Chart(ctx2, {
				type: 'doughnut',
				data: {
						labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
						datasets: [{
								label: '# of Votes',
								data: [12, 19, 3, 5, 2, 3],
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
						rotate: -0.5 * Math.PI
				}
		});
	}


	function abrir_libro(){
		$('#form-libro')[0].reset();
	 	$('#crear_libro').val('0');
		$('#modal_libro').modal('show');
	}
	function eliminar_libro(id){
		var route="./libro/"+id;
		var data=id;
		var token=$("#token").val();
		var divresul = "notificaciones_result";
		$.ajax({
		headers:{'X-CSRF-TOKEN':token},
		url:route,
		data:data,
		type:'DELETE',

		success: function(result){
	 		$('#example_libro').DataTable().ajax.reload();
		alert(result);
			}
		});
	}


		/*Pasar los datos al modal*/
	function editar_libro(id){
		var route="./get/libro";
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
	        $("#lmnombre").val(result.nombre);
			$("lmdescripcion").val(result.descripcion);
			$("#lmfecha_publicacion").val(result.fecha_publicacion);
			$("#lmfecha_adquisicion").val(result.fecha_adquisicion);
			$("#lmejemplares").val(result.ejemplares);

			$("#lmid_libro").val(result.id);
			$("#lmautor option[value="+result.autor+"]").prop('selected', 'selected').change();
			$("#lmestado_libro option[value="+result.estado_libro+"]").prop('selected', 'selected').change();


			$('#modal_libro').modal('show');
	        $('#crear_libro').val('1');
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
  	$('#example_libro').DataTable( {
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
	    "ajax": "./api/libro",
	    'columns':[


	    	{data: 'nombre'},
	    	{data: 'descripcion'},
	    	{data: 'id_autor'},
	    		{data: 'ejemplares'},
	    	{data: 'fecha_publicacion'},
	    	{data: 'fecha_adquisicion'},
	    	{data: 'estado_libro'},


	    	{data: 'action'},
	    ]
	});

tableResposive("#example_libro", 980);

  	$('#btn-addlibro').click(function(){

  		var form=$('#form-libro');
  		var url=form.attr('action');
  		var divresul = "notificaciones_result";
  		var dataString = new FormData(document.getElementById("form-libro"));
  		var token=$("#token").val();
	     $.ajax({
		headers:{'X-CSRF-TOKEN':token},
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
				contentType: false,
			processData: false,

            success: function(libro) {

            	$('#crear_libro').val('0');
            	$('#form-libro')[0].reset();
       	 		$('#example_libro').DataTable().ajax.reload();
       	 		alert(libro);
            }

        });
	});


		 });



//fin libroooo
//Autor
// graficos

	function chart(){
		   var route="./grafico/autor";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,
            type:'GET',
                    success: function(result) 
                    {
                      	console.log(result.datos);
                        var ctx = document.getElementById("myChart_autor").getContext('2d');
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
                    
               

		
	}


	function abrir_autor(){
		$('#form-autor')[0].reset();
	 	$('#crear_autor').val('0');
		$('#modal_autor').modal('show');
	}
	function eliminar_autor(id){
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
	 		$('#example_autor').DataTable().ajax.reload();
		alert(result);
			}
		});
	}


		/*Pasar los datos al modal*/
	function editar_autor(id){
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
	        $("#amnombre").val(result.nombre);
			$("#amapellidos").val(result.apellidos);
			$("#amnacionalidad").val(result.nacionalidad);


			$("#mid_autor").val(result.id);

			$('#modal_autor').modal('show');
	        $('#crear_autor').val('1');
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
  	$('#example_autor').DataTable( {
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

tableResposive("#example_autor", 980);

  	$('#btn-addautor').click(function(){

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

            	$('#crear_autor').val('0');
            	$('#form-autor')[0].reset();
       	 		$('#example_autor').DataTable().ajax.reload();
       	 		alert(autor);
            }

        });
	});


		 });


//Fin autor
//categoria

function chart_area(){

	var route="./grafico/categoria";
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,
            type:'GET',
                    success: function(result) 
                    {
                
                        var ctx = document.getElementById("myChart_autor").getContext('2d');
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
                    
               

}


	function abrir_area(){
		$('#form-categoria')[0].reset();
	 	$('#crear_area').val('0');
		$('#modal_area').modal('show');
	}
	function eliminar_area(id){
		var route="./categoria/"+id;
		var data=id;
		var token=$("#token").val();
		var divresul = "notificaciones_result";
		$.ajax({
		headers:{'X-CSRF-TOKEN':token},
		url:route,
		data:data,
		type:'DELETE',

		success: function(result){
	 		$('#example_area').DataTable().ajax.reload();
		alert(result);
			}
		});
	}


		/*Pasar los datos al modal*/
	function editar_area(id){
		var route="./get/categoria";
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
	        $("#cmnombre").val(result.nombre);
			$("#cmdescripcion").val(result.descripcion);
		

			$("#mid_categoria").val(result.id);
		
			$('#modal_area').modal('show');
	        $('#crear_area').val('1');
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
  	$('#example_area').DataTable( {
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
	    "ajax": "./api/categoria",
	    'columns':[


	    	{data: 'nombre'},
	    	{data: 'descripcion'},
	    


	    	{data: 'action'},
	    ]
	});

tableResposive("#example_area", 980);

  	$('#btn-addcategoria').click(function(){

  		var form=$('#form-categoria');
  		var url=form.attr('action');
  		var divresul = "notificaciones_result";
  		var dataString = new FormData(document.getElementById("form-categoria"));
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

            	$('#crear_area').val('0');
            	$('#form-categoria')[0].reset();
       	 		$('#example_area').DataTable().ajax.reload();
       	 		alert(user);
            }

        });
	});


		 });



//fin cate
@endsection
