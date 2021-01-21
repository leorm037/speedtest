<?php $v->layout("base"); ?>

<div class="main_graph">
    <canvas id="graphCanvas"></canvas>
</div>

<?php $v->start("script"); ?>
<script src="<?= theme("/assets/js/graph.js"); ?>"></script>
<script type="text/javascript">
    $(function () {
        showGraph("<?= url("json/dias/" . $urlJson); ?>");
    });
</script>
<?php $v->end(); ?>