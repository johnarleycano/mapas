<li>
<?php
// Recorrido de las clasificaciones de atención
foreach ($this->operaciones_model->obtener("eventos_dia", $fecha) as $evento) {
	?>
	<a href="#"><?php echo $evento->nombre; ?></a>
    <ul>
        <li><a href="#">- </i></a></li>
        <li><a href="#">- </i></a></li>
    </ul>

	<?php
}
?>
</li>
