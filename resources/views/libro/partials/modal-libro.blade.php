 <div id="modal_libro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridModalLabel">Libro</h4>
            </div>
            {!! Form::open(['route'=>'libro.store', 'method'=>'POST','id'=>'form-libro']) !!}
                <div class="modal-body">

                    <div class="container-fluid bd-example-row">
                        <div class="row">
                                <div class="inner-addon right-addon">
                                    <label for="">Nombre</label>

                                    {!!Form::text('nombre', null,array('class'=>'form-control','id'=>'lmnombre', 'placeholder'=>'Nombre(**)'))!!}
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Descripcion</label>

                                    {!!Form::text('descripcion', null,array('class'=>'form-control','id'=>'lmdescripcion', 'placeholder'=>'Descripcion(*)'))!!}
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Autor</label>
                                    <select name="autor" id="lmautor" class="form-control">
                                        @foreach($autores as $autor)
                                        <option value="{{$autor->id}}">{{$autor->nombre}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <br>

                                <div class="inner-addon right-addon">
                                    <label for="">Fecha publicacion</label>
                                    <input type='date' class="form-control" id='lmfecha_publicacion' name='fecha_publicacion' ></input>
                                </div>
                                <br>

                                <div class="inner-addon right-addon">
                                    <label for="">Fecha adquisicion</label>
                                    <input type='date' class="form-control" id='lmfecha_adquisicion' name='fecha_adquisicion' ></input>
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for=""># Ejemplares</label>
                                    <input type='text' class="form-control" id='lmejemplares' name='ejemplares' ></input>
                                </div>
                                <br>
                                <div class="inner-addon right-addon">
                                    <label for="">Estado</label>
                                    <select name="estado_libro" id="lmestado_libro" class="form-control">

                                        <option value="1">Nuevo</option>
                                        <option value="2">Usado</option>


                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                 <input type="hidden" name="id_libro" id='mid_libro'>
                <input type="hidden" id='crear_libro' name="crear_libro" value='0'>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-addlibro"  class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
