    @extends('principal.index')
    @section('titulo')
        Dashboard
    @endsection
    @section('estilo')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:600" rel="stylesheet">
        <style>
              .active{
                 background:#2196F3;
                 color:white;
               }
        </style>
    @endsection
@section('content')

<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

<!-- <div class="panel panel-default">
    <div class="panel-heading panel-color hidden" style="background: #3985B2; color:white; font-weight: bold; font-size:18px;">

    </div>
    <div class="panel-body">
        <div class="col-xs-2">
           <select id='tipo_dia' class="form-control" onchange="cambiargrafico();">
            <option value="Hoy">Hoy</option>
            <option selected="selected" value="Semana">Semana</option>
            <option value="Mes">Mes</option>
           </select>
        </div>
    </div>
</div>
 -->


<div class="panel panel-default">
    <div class="panel-heading panel-color">
        <h3 class="panel-title"> PRESTAMOS/DEVOLUCIONES</h3>
    </div>
    <div class="panel-body">

    <div class="panel panel-default">
      <div class="panel-body">

          <div class="row-mod">
            <div class="faturacion_date width-all">
              <select id='tipo_dia' class="form-control width-margin" onchange="cambiargrafico();">
                <option value="Hoy">Hoy</option>
                <option selected="selected" value="Semana">Semana</option>
                <option value="Mes">Mes</option>
              </select>
            </div>
      </div>
    </div>
        <div class="col-xs-12">
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading panel-color" >
        <h3 class="panel-title"> PRESTAMOS REALIZADOS </h3>
    </div>
    <div class="panel-body table-number">
        <div class="table-data table-responsive">
            <table border="1" id="example" class="table table-striped table-data table-result width-all">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Descripcion Bibliotecario</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading panel-color">
        <h3 class="panel-title"> DEVOLUCIONES  </h3>
    </div>
    <div class="panel-body table-number">
      <div class="  table-data  table-responsive">
            <table border="1" id="example1" class="table table-striped table-data table-result width-all">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Libro</th>
                    <th>Descripcion alumno</th>
                </tr>
                </thead>
            </table>
          </div>
    </div>
</div>

<br><br><br>
@endsection

@section('script')

     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" ></script>

  <script type="text/javascript">
    $(document).ready(function(){
        bloquear();
        google.charts.load('current', {'packages':['corechart']});
        cambiargrafico();
        datatableprestamo();
        datatabledevolucion();

    });


    /*Para la grafica*/


function cambiargrafico(){
        var tipo_dia=$('#tipo_dia').val()
        var route="dashboard/"+tipo_dia;
            var token=$("#token").val();
             $.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url:route,

            type:'GET',
                    success: function(result) {


                    graficar(result);

                    }

                });

}
function bloquear()
{
    var tipo_reporte=$('#tipo_reporte').val();
    if(tipo_reporte==3)
    {
        $('#div_tiendas').hide();

        $('#div_usuarios').hide();
    }
    else if(tipo_reporte==2)
    {
        $('#div_tiendas').show();

        $('#div_usuarios').hide();
    }
    else
    {
        $('#div_tiendas').hide();

        $('#div_usuarios').show();
    }

    cambiargrafico();
}
function graficar(datos){
    var tipo_dia=$('#tipo_dia').val();
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
          var data = new google.visualization.DataTable([
          ]);
                data.addColumn('string','Fecha');
                data.addColumn('number','Prestamos');
                data.addColumn('number','Devoluciones ');
                $.each(datos,function(key,value){

                data.addRow([key,value[1],value[0]]);
                });

             var options = {
              title: 'Prestamo/Devolucion',
              hAxis: {title: tipo_dia,  titleTextStyle: {color: '#333'}},
              vAxis: {minValue: 0},
              backgroundColor: { fill:'transparent'},
              height: 400

            };


            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);

              function resizeHandler () {
                  chart.draw(data, options);
              }
              if (window.addEventListener) {
                  window.addEventListener('resize', resizeHandler, false);
              }
              else if (window.attachEvent) {
                  window.attachEvent('onresize', resizeHandler);
              }
          }

          datatableprestamo();
          datatabledevolucion();

}


/*Datatables*/
function datatableprestamo()
        {
        var tipo_dia=$('#tipo_dia').val();


            $('#example').dataTable().fnDestroy();

            $('#example').DataTable
            ({  "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                'bFilter':true,

                "oLanguage":
                {
                        "oPaginate":
                        {
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior",
                        },
                        "sSearch": "Buscar" ,
                        "sInfo": " Mostrando _START_ a _END_ de _TOTAL_ entidades",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sInfoFiltered": " - filtrando de _MAX_ resultados"
                 },
                "ajax": "apidashboard/prestamo/"+tipo_dia,
                'columns':
                [
                    {data: 'fecha_prestamo'},
                    {data: 'id_usuario'},
                    {data: 'id_libro'},
                    {data: 'descripcion_prestamo'},

                ]
            });

        }

function datatabledevolucion()
{
    var tipo_dia=$('#tipo_dia').val();

    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable
    ({  "order": [[ 0, 'desc' ]],
        "processing": true,
        "serverSide": true,
        'bFilter':true,
        "oLanguage":
                {
                    "oPaginate":
                    {
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior",
                    },
                    "sSearch": "Buscar" ,
                    "sInfo": " Mostrando _START_ a _END_ de _TOTAL_ entidades",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sInfoFiltered": " - filtrando de _MAX_ resultados"
                 },
                "ajax": "apidashboard/devolucion/"+tipo_dia,
                'columns':
                [
                    {data: 'fecha_devolucion'},
                    {data: 'id_usuario'},
                    {data: 'id_libro'},
                    {data: 'descripcion_usuario'},

                ]
            });

}




  </script>

  @endsection
