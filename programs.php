<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<div class="grid_12">
	<div class="block-3 box-shadow">
		<h2 class="p4">
			<span class="color-1">Yapım</span> aşamasında
		</h2>
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>