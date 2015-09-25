@extends('app')

@section('content')

<div class="container">
  <h2>Alimentar indicador: {!! $id !!}</h2>
  <br><br>

  <table>
    <thead>
      <tr>
        <th>Datos actuales del indicador</th>
        <th>&nbsp;&nbsp;</th>
        <th>&nbsp;&nbsp;</th>
        <th>&nbsp;&nbsp;</th>
        <th>&nbsp;&nbsp;</th>
        <th>&nbsp;&nbsp;</th>
        <th>&nbsp;&nbsp;</th>
        <th>Alimentación del Indicador</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="col-lg-4">
            <div class="form-group" >    
              <span class="label label-defaul">Estado actual: &nbsp;&nbsp; {{ $callDatasIndicators[0]->actualvalue }}</span>
              <br> <span class="label label-defaul">Nota:&nbsp;&nbsp; {{ $callDatasIndicators[0]->score }}</span>     
              <br> <span class="label label-defaul">Valor esperado: &nbsp;&nbsp; {{ $callDatasIndicators[0]->desirevalue }}</span>
               <br> <span class="label label-defaul">Frecuencia: &nbsp;&nbsp; {{ $callDatasIndicators[0]->updatefrq }} días</span>
            </div>
          </div>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <div class="col-lg-4">
            <div class="form-group" >    
              <span class="label label-defaul">Último periodo alimentado: &nbsp;&nbsp; {{ @date('d M Y', strtotime($callDatasIndicators[0]->updatetime)) }}</span>
              <br> <span class="label label-defaul">Fecha del próximo periodo: &nbsp;&nbsp; {{ @date('d M Y', strtotime($callDatasIndicators[0]->lastupdate)) }}</span>     
           </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  
  <br>


    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Periodo</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Acciones</th>                
            </tr>
        </thead>

        @foreach ($callStatesIndicators as $callStatesIndicator)
        <tbody>
            <tr>
                <td class="text-center">{{ @date('d M Y', strtotime($callStatesIndicator->perioddate)) }}</td>                                      
                <td width="8%" align="center">
                  @if((!@empty($callStatesIndicator->actualvalue)) || ($callStatesIndicator->actualvalue == 0) )

                    @if( @strcmp($callStatesIndicator->perioddate, $callDatasIndicators[0]->updatetime) == 0)
                     <div class="form-group">
                         <input type="number" class="form-control" id="inputId{{$callStatesIndicator->stateid}}" 
                                value="{{ $callStatesIndicator->actualvalue }}" 
                                autofocus
                                placeholder="number"
                                >
                     </div>
                     @else
                      <div class="form-group">
                         <input type="number" class="form-control" id="inputId{{$callStatesIndicator->stateid}}" 
                                value="{{ $callStatesIndicator->actualvalue }}" disabled>
                     </div>
                     @endif

                  @else
                    @if( @strcmp($callStatesIndicator->perioddate, $callDatasIndicators[0]->updatetime) == 0)
                     <div class="form-group">
                         <input 
                            type="number" 
                            class="form-control" 
                            id="inputId{{$callStatesIndicator->stateid}}" 
                            value="0" 
                            autofocus
                            placeholder="number"
                         >
                     </div>
                     @else
                      <div class="form-group">
                         <input type="number" class="form-control" id="disabledInput" 
                                value="0" disabled>
                     </div>
                     @endif
                    
                  @endif
                </td>
                <td class="text-center"> 
                    @if( $callStatesIndicator->perioddate < $callDatasIndicators[0]->updatetime)
                      <button 
                          class="btn btn-fab btn-fab-mini btn-raised btn-sm btn-success"                          
                          data-toggle="tooltip" 
                          data-placement="top" 
                          title="Editar valor"
                          onclick="habilitar({{$callStatesIndicator->stateid}})"
                          >
                        <i style=" font-size: 12pt;" class="mdi-editor-mode-edit" ></i>
                      </button>
                    @endif

                     @if( @strcmp($callStatesIndicator->perioddate, $callDatasIndicators[0]->updatetime) == 0)
                        <button 
                             class="btn btn-fab btn-fab-mini btn-raised btn-sm btn-success"  
                             id="editar{{$callStatesIndicator->stateid}}" 
                             data-toggle="tooltip" 
                             data-placement="top" 
                             title="Alimentar estado" 
                             onClick="nuevoValor({{$callStatesIndicator->stateid}})" >
                          <i style=" font-size: 15pt;" class="mdi-content-reply-all"></i>
                        </button>
                     @else  
                        <button 
                             class="btn btn-fab btn-fab-mini btn-raised btn-sm btn-success hidden"  
                             id="editar{{$callStatesIndicator->stateid}}" 
                             data-toggle="tooltip" 
                             data-placement="top" 
                             title="Alimentar estado" 
                             onClick="nuevoValor({{$callStatesIndicator->stateid}})" 
                             disabled>                     
                          <i style=" font-size: 15pt;" class="mdi-content-reply-all"  ></i>
                        </button>
                     @endif        
                    
                  
                </td>                
            </tr>
            
        </tbody>
        @endforeach
    </table>
  </div>

 




  <h2>Modal Example</h2>
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">


            <p>Some text in the modal.</p>

            <br>


              <h2>Dynamic Tabs</h2>
            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
              <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
              <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
              <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
            </ul>

            <div class="tab-content">
              <div id="home" class="tab-pane fade in active">
                <h3>HOME</h3>


                <table class="table table-striped table-hover" style="width:100%">
                  <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>   
                    <th>Points</th>
                  </tr>
                  <tr>
                    <td>Jill</td>
                    <td>Smith</td>    
                    <td>50</td>
                  </tr>
                  <tr>
                    <td>Eve</td>
                    <td>Jackson</td>    
                    <td>94</td>
                  </tr>
                  <tr>
                    <td>John</td>
                    <td>Doe</td>    
                    <td>80</td>
                  </tr>
                </table>



              </div>
              <div id="menu1" class="tab-pane fade">
                <h3>Menu 1</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div id="menu2" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
              </div>
              <div id="menu3" class="tab-pane fade">
                <h3>Menu 3</h3>


                <table style="width:100%; border-spacing: 15px;">
                  <tr>
                    <td style=" padding: 5px; border: 1px solid black;">Jill</td>
                    <td style=" padding: 5px; border: 1px solid black;">Smith</td>    
                    <td style=" padding: 5px; border: 1px solid black;">50</td>
                  </tr>
                  <tr>
                    <td style=" padding: 5px; border: 1px solid black;">Eve</td>
                    <td style=" padding: 5px; border: 1px solid black;">Jackson</td>    
                    <td style=" padding: 5px; border: 1px solid black;">94</td>
                  </tr>
                  <tr>
                    <td style=" padding: 5px; border: 1px solid black;">John</td>
                    <td style=" padding: 5px; border: 1px solid black;">Doe</td>    
                    <td style=" padding: 5px; border: 1px solid black;">80</td>
                  </tr>
                </table>


              </div>
            </div>


   



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>

    <br><br>


    <h2>Dynamic Tabs</h2>
  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
















 <script type="text/javascript">

  function nuevoValor(idPeriodo){

    var newVal=$('#inputId'+idPeriodo).val();
    //alert(newVal);  


    if (!(newVal.length)) {

      swal("Error", "Ingrese un valor numerico", "error");
    } else{
      $.get("estado/"+idPeriodo+"/"+newVal+"/lnunez");
        swal({   
          title: "Valor actualizado correctamente!",   
          text: "Nuevo estado "+newVal,   
          type: "success",   
          //showCancelButton: true,   
          //closeOnConfirm: false,   
          showLoaderOnConfirm: true, }, 
          function(){   
            setTimeout(function(){     
              swal("Ajax request finished!");   
            }, location.reload()); 

          }); 
    }; 


/*    $.get("estado/"+idPeriodo+"/"+newVal+"/lnunez");

    swal({   
      title: "Valor actualizado correctamente!",   
      text: "Nuevo estado "+newVal,   
      type: "success",   
      //showCancelButton: true,   
      //closeOnConfirm: false,   
      showLoaderOnConfirm: true, }, 
      function(){   
        setTimeout(function(){     
          swal("Ajax request finished!");   
        }, location.reload()); 

      }); */
  }


  function habilitar(id){
    var idinput = "#inputId"+id;
    var editarboton = "#editar"+id;
     console.log(idinput);
     console.log(editarboton);
     
    $(idinput).removeAttr('disabled');    
    $(editarboton).removeClass("hidden");
    $(editarboton).removeAttr('disabled');

  }

</script>

@endsection
