 <div id="modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridModalLabel">Libro</h4>
            </div>
            {!! Form::open(['route'=>'escuela.store', 'method'=>'POST','id'=>'form-escuela']) !!}
                <div class="modal-body">

                    <div class="container-fluid bd-example-row">
                        <div class="row">
                                <div class="inner-addon right-addon">
                                    <label for="">Nombre</label>

                                    {!!Form::text('nombre', null,array('class'=>'form-control','id'=>'mnombre', 'placeholder'=>'Nombre(**)'))!!}
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Descripcion</label>

                                    {!!Form::text('facultad', null,array('class'=>'form-control','id'=>'mfacultad', 'placeholder'=>'Facultad(*)'))!!}
                                </div>

                        </div>
                    </div>
                </div>
                 <input type="hidden" name="id_escuela" id='mid_escuela'>
                <input type="hidden" id='crear' name="crear" value='0'>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-addescuela"  class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
