<?php 
 
session_start();
include("mensajeros.php");

$menj = new Mensajeros();
$mensajeros = (json_decode($menj->listarMensajero()));

?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>AdminLTE 3 | Top Navigation</title>
	<link rel="stylesheet" href="/proyecto/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/proyecto/dist/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
			<div class="container">
				<a href="#" class="navbar-brand">
					<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"	style="opacity: .8">
					<span class="brand-text font-weight-light">Asignar Envíos</span>
				</a>
			</div>
		</nav>
		<div class="content-wrapper">
			<div class="content-header">
				<div class="container">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"></h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Asignación Mensajeros</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Asignación Mensajeros</h3>
								</div>
								<div class="text-center">
									<img class="img-fluid rounded mx-auto d-block logo" src="dist/logos/LogoDomina.png"
										alt="User profile picture">
								</div>
									<div class="card-body">
										<div class="form-group">
											<label for="mensajero">Mensajero</label>
											<select name="mensajero" id="mensajero"
												class="form-control select2 select2-hidden-accessible"
												placeholder="Seleccione el mensajero">
												<option value="">Seleccione el Mensajero</option>
												<?php foreach ($mensajeros as $mensajero) {echo "<option value='".$mensajero->id."'>".$mensajero->name."</option>";}?>
											</select>
										</div>
										<div class="form-group">
											<label for="idguia">Guías</label>
											<input type="text" name="guia" class="form-control" id="idguia"
												placeholder="Ingresa el numero de la guia" />
										</div>
									</div>
									<div class="card-footer">
										<button type="button" onclick='guardarguia()' class="btn btn-primary">Asignar</button>
										<button type="button" onclick='limpiardata()' class="btn btn-danger">Limpiar</button>
									</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Total Envíos Asignados</h3>
								</div>
								<form>
									<div class="card-body">
										<p id='mensajeRespuesta'></p>
									</div>
									<div class="card-footer" id='divcontenedor'>
										<button type="button" id='botonreporte' class="btn btn-primary" onclick='generartxt()'>Generar Reporte</button>										
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="main-footer">
			<div class="float-right d-none d-sm-inline">
				Anything you want
			</div>
			<strong>Copyright &copy; <?php echo date('Y')?> <a href="https://adminlte.io">Proyecto Escuela TI</a>.</strong> All
			rights reserved.
		</footer>
	</div>
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
</body>
<script>
	function guardarguia() {
		var ruta = 'guiasmensajeros.php?op=1'
		let idguia = document.getElementById('idguia').value
		if(idguia == '' || idguia == undefined){
			alert('Debe Ingresar un Número de Guía!')
			return;
		}
		ruta+='&idguia='+idguia;
		const option = document.querySelector('#mensajero');
		console.log(option.text);
    	idmensajero = option.value;
		if(idmensajero == '' || idmensajero == undefined){
			alert('Debe Seleccionar un Mensajero');
			return;
		}
		ruta+='&idmensajero='+idmensajero;		
		envio_ajax(ruta);
		limpiardata();
	}

	function envio_ajax(ruta){
		var requestOptions = {
		method: 'GET',
		redirect: 'follow',
		'Content-Type': 'application/json',
		};

		fetch(ruta,requestOptions)
		.then(response => response.text())
		.then((result)=>{
			data = JSON.parse(result)
			console.log(data);
			console.log(result);
			let mensajero = '';
			let totalguias = data.totalguias??0;
			document.getElementById('mensajeRespuesta').innerHTML = `El Mensajero ${mensajero}tiene ${totalguias} Guías Asignadas`;
			if(data.rutaArchivo!=''){			
				document.getElementById("divcontenedor").innerHTML = `<a href='${data.rutaArchivo}' class="btn btn-success" target="_blank" download>Descargar</a>`;
			}else{
				document.getElementById("divcontenedor").innerHTML = `<button type="button" id='botonreporte' class="btn btn-primary" onclick='generartxt()'>Generar reporte</button>	`;

			}
		})
		.catch(error => console.log('error', error));
	}

	function generartxt(){
		var ruta = 'guiasmensajeros.php?op=0'
		const option = document.querySelector('#mensajero');
		console.log(option.text);
		idmensajero = option.value;
		if(idmensajero == '' || idmensajero == undefined){
			alert('Debe seleccionar un mensajero');
			return;
		}
		ruta+='&idmensajero='+idmensajero;		
		envio_ajax(ruta)
	}

	function limpiardata(){
		document.getElementById('mensajero'). value = "";
		document.getElementById('idguia'). value = "";
	}

</script>
</html>
