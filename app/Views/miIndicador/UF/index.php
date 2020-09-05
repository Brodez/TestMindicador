<?= $this->extend('layouts/base', $title) ?>

<?= $this->section('content') ?>
<div class="container-fluid">

	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Historico UF
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="historico_uf" width="100%" cellspacing="0">
				</table>
			</div>
		</div>
		<!-- <div class="card-footer small text-muted">
			Actualizado a
		</div> -->
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="EditUF" tabindex="-1" aria-labelledby="EditUFLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="EditUFLabel">Editar UF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="#" id="editForm" class="form-horizontal">
				<input type="hidden" id="id" name="uf_id" value="">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Valor</label>
							<div class="col-md-9">
								<input name="uf_valor" placeholder="Valor" class="form-control numeric" type="text">
							</div>
						</div>

					</div>
				</form>


			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
		</div>


	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
	$(document).ready(function() {
		$('#historico_uf').DataTable({

			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
			},
			"ajax": {
				url: "<?= route_to('get_ufs') ?>",
				type: 'GET'
			},
			columns: [{
					data: "fecha",
					'name': 'fecha',
					'title': 'Fecha'
				},
				{
					data: "valor",
					'name': "valor",
					'title': 'Valor'
				},
				{
					"title": "Acciones",
					render: function(data, type, row, meta) {
						return '<button type="button" onClick="editUF(' + row.id + ')" class="btn btn-warning">Editar</button>';
					}
				}
			]

		});
	});

	function editUF(id) {
		$('#editForm')[0].reset();
		<?php header('Content-type: application/json'); ?>
		var url = "<?php echo base_url('/api/uf/get')?>/" + id;
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$('[name="uf_id"]').val(data.id);
				$('[name="uf_valor"]').val(data.valor);
				$('#EditUF').modal('show');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				alert('Error de ajax');
			}
		});
	}

	// $('.numeric').on('keypress', function (event) { 
	// 	this.value = this.value.replace(/^[0-9]*\.?[0-9]*$/, '');
	// });

	$('.numeric').keypress(function (e) { 
		// console.log(e);

		// var regex = /^[0-9]*\.?[0-9]*$/;    // allow only numbers [0-9] 
		// const str=this.value;
		// const subs = '';
		// const result = str.replace(regex, subst);
		// this.value=result;

		var iKeyCode = (e.which) ? e.which : e.keyCode
		var DotIncluded = this.value.includes('.') ;
		console.log(iKeyCode);
		if(DotIncluded && iKeyCode == 46)
		return false;
		else if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
			return false;
		return true; 
	});


	function save() {
		url = "<?php echo base_url('api/uf/update') ?>";
		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: $('#editForm').serialize(),
			dataType: "JSON",
			success: function(data) {
				//if success close modal and reload ajax table
				$('#EditUF').modal('hide');
				// location.reload(); // for reload a page
				$('#historico_uf').DataTable().ajax.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error actualizando valor');
			}
		});
	}
</script>
<?= $this->endSection() ?>