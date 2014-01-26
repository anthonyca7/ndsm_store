<h1>Register</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<script type="text/javascript">
	$('#email').keyup(function (event) {
	var email = $("#email").val();
	var parts = email.split('@');
	$('#username').val(parts[0]);
	//alert('works');
});
</script>