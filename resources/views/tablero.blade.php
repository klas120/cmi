@extends('app')

@section('content')

<h3>Tablero de Control</h3>


<div class="form-group">
	 <div class="col-lg-10">

	 
    {!! Form::open(array('class' => 'form-inline', 'url' => 'llamarTablero', 'method' => 'post' )) !!}
     
		<select class="form-control float: right;" id="select" name='tabla' onchange="this.form.submit()">
			<label for="select" class="col-lg-2 control-label">Tableros</label>
			<option>Seleccinar tablero</option>
 			@foreach($selectControlviews as $selectControlview)
		 		<option value="{{ $selectControlview }}" href="{!! URL::to('llamarTablero/'.$selectControlview) !!}" >
		 		{{ $selectControlview }}	
		 	    </option> 					
			@endforeach             
            	              
		</select>
	{!! Form::close() !!}

     </div>
	</div><br>

<br><br>
<div class="table-responsive">
	<table id="tablero" class="table table-striped table-hover">		

		<thead>
			<tr>				
				<th>Código</th>
				<th>Nombre</th>
				<th class="text-center">Categoría</th>
				<th class="text-center">Fecuencia de Alimentación</th>
				<th class="text-center">Nota Actual</th>
				<th class="text-center">Valor Actual</th>
				<th class="text-center">Unidad de Medida</th>
				<th class="text-center">Meta</th>
				<th class="text-center">Colorimetría</th>
				<th class="text-center" colspan="4">Última Alimentación<br>
				  I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
				  II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
				  IIV&nbsp;
			    </th>				
				<th class="text-center">Promedio</th>
				<th class="text-center">Colorimetría Promedio</th>
				<th class="text-center">Acciones</th>
			</tr>					
		</thead>
		<tbody>	

		@foreach($indicadores as $indicador)
			<tr>				
				<td>{{ $indicador['indicatorid'] }} </td>
				<td width="12%" align="left">{{ $indicador['indicatorname'] }}</td>
				<td class="text-center">{{ $indicador['categoryname'] }}</td>
				<td class="text-center">{{ $indicador['updatefrq'] }}</td>
				<td class="text-center">{{ $indicador['score'] }}</td>
				<td class="text-center">{{ $indicador['actualvalue'] }}</td>
				<td class="text-center">{{ $indicador['colometric'] }}</td>
				<td class="text-center">{{ $indicador['desirevalue'] }}</td>

				@if( $indicador['averageColor1']  == 'FF0000')	
				   <td class="text-center"><i style=" font-size: 20pt; color:red" class="mdi-av-stop"></i></td>
				@elseif($indicador['averageColor1'] == '0000CD')
					<td class="text-center"><i style=" font-size: 15pt; color:blue" class="mdi-toggle-check-box"></i></td>
				@elseif($indicador['averageColor1'] == '308014')
					<td class="text-center"><i style=" font-size: 15pt; color:green" class="mdi-image-lens"></i></td>
				@else
					<td class="text-center"><i style=" font-size: 15pt; color:#FFD700;" class="glyphicon glyphicon-triangle-top"></i></td>
				@endif	

				<td  class="text-center">{{ $indicador['lastsState_0_score'] }}</td>
				<td  class="text-center">{{ $indicador['lastsState_1_score'] }}</td>
				<td  class="text-center">{{ $indicador['lastsState_2_score'] }}</td>
				<td  class="text-center">{{ $indicador['lastsState_3_score'] }}</td>
				<td  class="text-center">{{ $indicador['colometricAverage']  }}</td>

				@if( $indicador['averageColor2']  == 'FF0000')	
				   <td class="text-center"><i style=" font-size: 15pt; color:red" class="mdi-image-brightness-1"></i></td>
				@elseif($indicador['averageColor2'] == '0000CD')
					<td class="text-center"><i style=" font-size: 15pt; color:blue" class="mdi-image-brightness-1"></i></td>
				@elseif($indicador['averageColor2'] == '308014')
					<td class="text-center"><i style=" font-size: 15pt; color:green" class="mdi-image-brightness-1"></i></td>
				@else
					<td class="text-center"><i style=" font-size: 15pt; color:#FFD700" class="mdi-image-brightness-1"></i></td>
				@endif
					
				<td>					
					<a data-target="#mostrar" data-toggle="tooltip" data-placement="top" title="Mostrar: {{ $indicador['indicatorid'] }}" href="#">
						<i style=" font-size: 15pt;" class="mdi-action-visibility"></i>
					</a> 

					<!-- Modal -->
					<div class="modal fade" id="mostrar" role="dialog">
					  <div class="modal-dialog modal-lg">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Modal Header</h4>
					      </div>
					      <div class="modal-body">
					        <p>This is a large modal.</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>

					<a href="#" data-toggle="tooltip" data-placement="top" title="Eliminar indicador: {{ $indicador['indicatorid'] }}">
						<i onclick="deleteIndicator('{!! $indicador['indicatorid'] !!}')" style=" font-size: 12pt;" class="glyphicon glyphicon-remove"></i>
					</a>						
					<a data-toggle="tooltip" data-placement="top" title="Alimentar indicador: {{ $indicador['indicatorid'] }}" 
					   	href="alimentar/{{ $indicador['indicatorid'] }}">
						<i style=" font-size: 15pt;" class="mdi-content-reply-all"></i>
					</a>
					            				
				</td>
			</tr>	

		@endforeach
		</tbody>		
	</table>
	
</div>	
<!-- Fin del container -->

@endsection
