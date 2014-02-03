<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>

<script type="text/javascript">
    var title = "<?php echo ucwords($_GET['tag']); ?>";
    $(document).ready(function  () {
        $("#myModalLabel").html("Register to " + title);
        $(".brand").html(title);
        $(".brand").attr("href", '<?php echo $this->createUrl("store/view", array("tag"=>$_GET["tag"])); ?>');

    });

</script>