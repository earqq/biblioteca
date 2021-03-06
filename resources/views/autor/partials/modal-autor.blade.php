 <div id="modal_autor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridModalLabel">Autor</h4>
            </div>
            {!! Form::open(['route'=>'autor.store', 'method'=>'POST','id'=>'form-autor']) !!}
                <div class="modal-body">

                    <div class="container-fluid bd-example-row">
                        <div class="row">
                                <div class="inner-addon right-addon">
                                    <label for="">Nombre</label>

                                    {!!Form::text('nombre', null,array('class'=>'form-control','id'=>'amnombre', 'placeholder'=>'Nombre(**)'))!!}
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Apellidos</label>

                                    {!!Form::text('apellidos', null,array('class'=>'form-control','id'=>'amapellidos', 'placeholder'=>'Apellidos(*)'))!!}
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Nacionalidad</label>

                                    {!!Form::text('nacionalidad', null,array('class'=>'form-control','id'=>'amnacionalidad', 'placeholder'=>'Nacionalidad(*)'))!!}
                                </div>

                        </div>
                    </div>
                </div>
                 <input type="hidden" name="id_autor" id='mid_autor'>
                <input type="hidden" id='crear_autor' name="crear_autor" value='0'>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-addautor"  class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
