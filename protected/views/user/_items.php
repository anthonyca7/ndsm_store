<?php foreach($items as $item): ?>
	<div>
		<div class="content">
		<?php 
		echo (CHtml::encode($item->name) . '<br>'); 
		echo (CHtml::encode($item->quantity) . ' reserved' . '<br>'); 
		?>
		</div>
		<hr>
	</div>
<?php endforeach; ?>
