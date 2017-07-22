 <div id="modal_area" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridModalLabel">Categoria</h4>
            </div>
            {!! Form::open(['route'=>'categoria.store', 'method'=>'POST','id'=>'form-categoria']) !!}
                <div class="modal-body">          

                    <div class="container-fluid bd-example-row">
                        <div class="row">                   
                            <div class="form-group col-xs-11 col-margins">
                                <div class="inner-addon right-addon">                    
                                    <label for="">Nombre</label>

                                    {!!Form::text('nombre', null,array('class'=>'form-control','id'=>'cmnombre', 'placeholder'=>'Nombre(**)'))!!}                                    
                                </div>
                            </div> 
                            <div class="form-group col-xs-11 col-margins">
                                <div class="inner-addon right-addon">                    
                                    <label for="">Descripcion</label>

                                    {!!Form::text('descripcion', null,array('class'=>'form-control','id'=>'cmdescripcion', 'placeholder'=>'Descripcion(*)'))!!}                                    
                                </div>
                            </div>  
                       
                        </div>
                    </div>
                </div>
                 <input type="hidden" name="id_categoria" id='mid_categoria'>
                <input type="hidden" id='crear_area' name="crear_area" value='0'>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-addcategoria"  class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div> 
 
