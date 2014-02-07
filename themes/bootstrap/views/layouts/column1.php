<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span12">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>


<?php if (isset($_GET['tag'])): ?>
    <?php $page = Store::model()->findByAttributes(array('unique_identifier'=>$_GET['tag'])); ?>
    <?php if ($page): ?>
        <script type="text/javascript">
        var title = "<?php echo ucwords($page->name); ?>";
        $(document).ready(function  () {
            $("#myModalLabel").html("Register to " + title);
            $(".brand").html(title);
            $(".brand").attr("href", '<?php echo $this->createUrl("store/view", array("tag"=>$_GET["tag"])); ?>');

        });
        </script> 
    <?php endif ?>
    
<?php endif ?>