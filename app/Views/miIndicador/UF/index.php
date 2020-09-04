<?=$this->extend('layouts/base', $title)?>

<?=$this->section('content')?>
<div class="container-fluid">

	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Historico UF
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table
					class="table table-bordered"
					id="historico_uf"
					width="100%"
					cellspacing="0"
				>
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Fecha</th>
							<th>Valor</th>
						</tr>
					</tfoot>
					<tbody>


					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer small text-muted">
			Updated yesterday at 11:59 PM
		</div>
	</div>
</div>

<?=$this->endSection()?>

<?=$this->section('scripts')?>
<script>
	$(document).ready(function() {
		$('#historico_uf').DataTable({
			"language": {
					"url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
			}
		});
	});
</script>
<?=$this->endSection()?>


