<?php $v->layout("base"); ?>

<div class="main_graph">
    <canvas id="chart-area"></canvas>
</div>

<?php $v->start("script"); ?>
<script src="<?= theme("/assets/js/statistics.js"); ?>"></script>
<script type="text/javascript">
    $(function () {
        showGraph("<?= url("json/estatisticas"); ?>");
    });
</script>
<?php $v->end(); ?>
