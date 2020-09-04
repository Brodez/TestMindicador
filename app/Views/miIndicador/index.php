<?=$this->extend('layouts/base', $title)?>

<?=$this->section('content')?>
<div class="container-fluid">

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Indicadores
		</div>
		<div class="card-body">
			<div class="row m-0">
				<form class="form-inline" id="indicadores">
					<label class="my-1 mr-2" for="tipo_indicador">Indicadores</label>
					<select class="custom-select my-1 mr-sm-2" id="tipo_indicador">
						<option value="uf" selected>UF</option>
						<option value="ivp"> IVP </option>
						<option value="dolar"> Dolar Observado</option>
						<option value="dolar_intercambio"> Dolar Acuerdo </option>
						<option value="euro"> Euro </option>
						<option value="ipc"> IPC </option>
						<option value="utm"> Unidad Tributaria Mensual </option>
						<option value="imacec"> Imacec </option>
						<option value="tpm"> Tasa Politica Monteria </option>
						<option value="libra_cobre"> Libra de Cobre </option>
						<option value="tasa_desempleo"> Tasa de Desempleo </option>
						<option value="bitcoin"> Bitcoin </option>
					</select>

					<label class="mx-2" for="fecha_inicio">Fecha Inicio</label>
					<div class="form-group">
						<div class="input-group date" id="fecha_inicio" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input" id="fecha_inicio_val" data-target="#fecha_inicio" />
							<div class="input-group-append" data-target="#fecha_inicio" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>

					<label class="mx-2" for="fecha_termino">Fecha Final</label>
					<div class="form-group">
						<div class="input-group date" id="fecha_termino" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input" id="fecha_termino_val"  data-target="#fecha_termino" />
							<div class="input-group-append" data-target="#fecha_termino" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary mx-2">Buscar</button>
				</form>
			</div>
			<canvas id="grafica" width="100%" height="30"></canvas>
		</div>
	</div>


</div>




<?=$this->endSection()?>

<?=$this->section('scripts')?>

<script type="text/javascript">

	//Carga Inicial de la UF

	var ctx = document.getElementById("grafica");
	var chartGrafica;


	var url = "https://mindicador.cl/api/uf/" + moment().format('DD-MM-Y');
	console.log(url);
	$.ajax({
			url : url,
			type : 'GET',
			async:false,
			dataType : 'json',
			success : function(json) {
				var labels = [];
				var data = [];
				labels.push(moment(json.serie[0].fecha).format('DD/MM/Y'));
				data.push(json.serie[0].valor);
				chartGrafica = new Chart(ctx, {
					type: 'line',
					data: {
						labels: labels,
						datasets: [{
							label: "Valor",
							lineTension: 0.3,
							backgroundColor: "rgba(2,117,216,0.2)",
							borderColor: "rgba(2,117,216,1)",
							pointRadius: 5,
							pointBackgroundColor: "rgba(2,117,216,1)",
							pointBorderColor: "rgba(255,255,255,0.8)",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "rgba(2,117,216,1)",
							pointHitRadius: 50,
							pointBorderWidth: 2,
							data: data
						}],
					},
					options: {
						legend: {
							display: false
						}
					}
				});

			},
			error : function(xhr, status) {
				console.log("error:" + url);
			},
	});



	$(function () {
		$('#fecha_inicio').datetimepicker({
			defaultDate: moment(),
			locale: 'es',
			format: 'L',
			maxDate:moment(),
		});
		$('#fecha_termino').datetimepicker({
				defaultDate: moment(),
				locale: 'es',
				format: 'L',
				useCurrent: false,
				maxDate: moment()
		});

		$("#fecha_inicio").on("change.datetimepicker", function (e) {
				$('#fecha_termino').datetimepicker('minDate', e.date);
		});
		$("#fecha_termino").on("change.datetimepicker", function (e) {
				$('#fecha_inicio').datetimepicker('maxDate', e.date);
		});


	});

	$( "#indicadores" ).submit(function( e ) {
		event.preventDefault();

		var tipo_indicador = $("#tipo_indicador option:selected" ).val();
		// var fecha_inicio = moment($("#fecha_inicio_val").val()).format('DD-MM-Y');
		var fecha_inicio = moment($("#fecha_inicio_val").val(),'DD/MM/Y');
		var fecha_termino =  moment($("#fecha_termino_val").val(),'DD/MM/Y');

		var dates = moment.range(fecha_inicio, fecha_termino);

		var dias = [];
		var valores = [];
		for (let day of dates.by('years')) {
			var day_formatted = day.format('Y');
			var url = "https://mindicador.cl/api/"+ tipo_indicador +"/"+day_formatted;
			$.ajax({
					url : url,
					type : 'GET',
					async:false,
					dataType : 'json',
					success : function(json) {
						json.serie.forEach(e => {
							var d = moment(e.fecha);
							var value = e.valor;
							if(d >= fecha_inicio && d <= fecha_termino){
								dias.push(d.format('DD-MM-Y'));
								valores.push(value);
							}
						});

					},
					error : function(xhr, status) {
						console.log("error:" + url);
					},
			});
		}
		// chartGrafica.destroy();
		resetGrafica(chartGrafica, dias, valores);


	});

	function resetGrafica(chart, dias,valores){

		chart.data.datasets.forEach((dataset) => {
			while(dataset.data.length > 0){
				dataset.data.pop();
				chart.data.labels.pop();
			}
		});

		chart.update(0);
		chart.data.labels = dias;
		chart.data.datasets[0].data = valores;
		chart.update();

	}



</script>

<?=$this->endSection()?>



