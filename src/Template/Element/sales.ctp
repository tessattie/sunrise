<table class="table table-striped datatable" style="width:100%!important">
    <thead> 
        <th>Numéro</th>
        <th class="text-center">Type</th>
        <th class="text-center">Agent</th>
        <th class="text-center">Client</th>
        <th class="text-center">Destinataire</th>
        <th class="text-center">Total (USD)</th>
        <th class="text-center">Date</th>
        <th class="text-center">Heure</th>
        <th></th>
    </thead>
    <tbody> 
    <?php $total=0; $increment=0; foreach ($sales as $sale): ?>
    <tr>
        <td class="text-left"><?= $sale->sale_number ?></td>
        <td class="text-center">
            <?php if($sale->type == 1) : ?>
                <span class="label label-info">CASH</span>
            <?php endif; ?>

            <?php if($sale->type == 2) : ?>
                <span span class="label label-primary"> CREDIT</span>
            <?php endif; ?>
        </td>

        <td class="text-center"><?= substr($sale->user->last_name, 0,1).substr($sale->user->first_name, 0,1) ?></td>

        <td class="text-center"><?= substr($sale->customer->first_name." ".$sale->customer->last_name, 0, 15) ?></td>

        <td class="text-center"><?= substr($sale->receiver->name, 0, 15) ?></td>
        
        <?php if($sale->status == 1) : ?>

            <?php 
                $total = $total + $sale->total;
                $increment = $increment + 1;
            ?>
            <td class="text-center"><?= number_format($sale->total, 2, ".", ",") ?></td>
        <?php else : ?>
            <td class="text-center"><?= number_format($sale->total, 2, ".", ",") ?></td>
            
        <?php endif; ?>
        
        
        <td class="text-center"><?= date('Y-m-d', strtotime($sale->created)) ?></td>
        <td class="text-center"><?= date('h:i A', strtotime($sale->created)) ?></td>
        <td class="text-right"><a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th colspan="9">Total (<?= $increment ?> Fiches) - (<?= number_format($total, 2, ".", ",") ?> USD)</th>
    </tfoot>
</table>

        <style type="text/css">
    .dataTables_scrollFootInner, table{
        width:1700px!important;
    }
</style>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering": false,
        scrollY: "400px",
        scrollX: "1700px",
        scrollCollapse: true,
        paging: false,
    });
});</script>