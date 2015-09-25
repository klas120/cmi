<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@section('title') CMI @show</title>

	{!! Html::style('bower_components/bootstrap/css/bootstrap.min2.css') !!}
	{!! Html::style('bower_components/bootstrap-material-design-master/dist/css/material.min.css') !!}
	{!! Html::style('bower_components/bootstrap-material-design-master/dist/css/ripples.min.css') !!}
	<!-- RIPPLES.CSS MANEJA LAS OPCIONES DEL FOOTER -->
	<!-- {!! Html::style('bower_components/bootstrap-material-design/dist/css/ripples.css') !!} -->
	{!! Html::style('bower_components/bootstrap-material-design-master/dist/css/material-wfont.min.css') !!}	
	{!! Html::style('bower_components/bootstrap-material-design-master/dist/css/fonts-google.css') !!}	
	{!! Html::style('bower_components/sweetalert/dist/sweetalert.css') !!}	

	<!-- DataTables CSS -->
	<!-- <link rel="stylesheet" type="text/css" href="bower_components/DataTables/media/css/jquery.dataTables.css"> -->
	  {!! Html::style('bower_components/DataTables/media/css/jquery.dataTables.css') !!}  


	  <!-- tabs -->
	  <!-- {!! Html::style('bower_components/tabs/bootstrap.min.css') !!} -->
	

	<!--{!! Html::style('bower_components/bootstrap-sweetalert/assets/docs.css') !!}-->
	<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->

	<!-- Fonts -->
	<!-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-primary">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="http://www.avantica.net/es/">
						<img width="75" height="20" src="bower_components/sweetalert/example/images/avanticalogo.png">
					</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					
					@if (Auth::check())

						<ul class="nav navbar-nav">
							<li><a href="{{ url('/tablero') }}">Tablero de Control</a></li>						
						</ul>

						<ul class="nav navbar-nav">						
							<li><a href="{{ url('/estrategico') }}">Plan Estratégico</a></li>
						</ul>

					@endif					

					<ul class="nav navbar-nav">
						<li><a href="{{ url('/tablero') }}">Tablero de Control</a></li>						
					</ul>

					<ul class="nav navbar-nav">
						<li><a href="{{ url('/estrategico') }}">Plan Estratégico</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="#">Loguearse</a></li>						
						@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Auth::user()->name }} <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{!! url('/auth/logout') !!}">Cerrar Sesión</a></li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

			<div class="container-fluid">
				@yield('content')
			</div>		


			<!-- Scripts -->
			
			{!! Html::script('bower_components/jquery/dist/jquery.min.js') !!}
			{!! Html::script('bower_components/jquery/dist/js/bootstrap.min.js') !!}
			{!! Html::script('bower_components/bootstrap-material-design-master/dist/js/ripples.min.js') !!}
			{!! Html::script('bower_components/bootstrap-material-design-master/dist/js/material.min.js') !!}	
			{!! Html::script('bower_components/sweetalert/dist/sweetalert.min.js') !!}

			<!-- datatables -->	
			{!! Html::script('bower_components/DataTables/media/js/jquery.js') !!}
			{!! Html::script('bower_components/DataTables/media/js/jquery.dataTables.js') !!}

			<!-- Tabs -->
			<!-- {!! Html::script('bower_components/tabs/jquery.min.js') !!} -->
			{!! Html::script('bower_components/tabs/bootstrap.min.js') !!}
			

			{!! Html::script('C:bower_components/bootstrap/js/jquery-tooltip.min') !!}
			{!! Html::script('C:bower_components/bootstrap/js/bootstrap.min.js') !!}


			<!-- jQuery -->
			<!-- <script type="text/javascript" charset="utf8" src="bower_components/DataTables/media/js/jquery.js"></script> -->				  
			<!-- DataTables -->
			<!-- <script type="text/javascript" charset="utf8" src="bower_components/DataTables/media/js/jquery.dataTables.js"></script> -->



	<!--
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    -->

<!-- INICIALIZA VARIAS FUNCIONES DEL PROYECTO CMI -->
<script type="text/javascript">

//FUNCION PARA QUE INICIALIZA BOOTSTRAP-MATERIAL-DESIGN.
$(document).on('ready', function(){
	$.material.init();
});

</script>

  <script>
  //FUNCION PARA EL USO DE TOGGLE.
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
  });
</script>



<script >

	$(document).ready(function() {
	    // Setup - add a text input to each footer cell
	    $('#tablero tfoot th').each( function () {
	        var title = $('#tablero thead th').eq( $(this).index() ).text();
	        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	    } );
	 
	    // DataTable
	    var table = $('#tablero').DataTable();
	 
	    // Apply the search
	    table.columns().every( function () {
	        var that = this;
	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            that
	                .search( this.value )
	                .draw();
	        } );
	    } );
	} );		

</script>

<!-- FUNCIONES Y VARIABLES PARA SWEET-ALERT -->
<script>	

function deleteIndicator(id) { 
	
	swal({

		title: "¿Eliminar el indicador: "+ id +"?",   
		text: "¡El indicador será eliminado del tablero!",
		timer: 60000, 
		imageUrl: "bower_components/sweetalert/example/images/logo.jpg",
		imageSize: "300x100",    
		//type: "warning",
		
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "¡Si, eliminar indicador!",   
		cancelButtonText: "Cancelar!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 

		function(isConfirm){   
			if (isConfirm) {     
				swal("¡Eliminado!", "El indicador: "+ id +" fue eliminado.", "success"); 
				//timer: 1000000
				//location.href='terceros/'+id+'/delete';  
			} else {     
				swal("Cancelado", "El indicador no fue eliminado!", "error");   
		      } 
		});
};	


</script>

	<br><br><br><br>
	
	<footer class="alert alert-dismissable alert-primary"  >
		<p class="text-center" id="copyright">Copyright © 2015 Avantica San Carlos. All Rights Reserved</p>
	</footer>

	</body>
</html>
