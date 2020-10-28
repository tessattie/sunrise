<table class="table table-striped datatable" style="width:100%!important">
    <thead> 
        <th style="width:120px">Numéro</th>
        <th class="text-center" style="width:120px">Caissier</th>
        <th class="text-center">Client</th>
        <th class="text-center">Camion</th>
        <th class="text-center">Produit</th>
        <th class="text-center">Volume</th>
        <th class="text-center">Date</th>
        <th class="text-center">Transport</th>
        <th></th>
    </thead>
    <tbody> 
    <?php $increment=0; $sous = 0; $reductions = 0; $total = 0; $sous_us = 0; $reductions_us = 0; $total_us = 0; $volume=0; foreach ($sales as $sale): ?>
    <tr <?php if($sale->status == 0 || $sale->status == 4 || $sale->status == 6 || $sale->status == 7) : ?> style="background:#d9edf7" <?php endif; ?>>
        <td class="text-left"> <a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
        <td class="text-center"><?= $sale->has('user') ? $this->Html->link(substr($sale->user->last_name, 0,1).substr($sale->user->first_name, 0,1), ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
        <td class="text-center"><?= $sale->has('customer') ? $this->Html->link(substr($sale->customer->first_name." ".$sale->customer->last_name, 0, 15), ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
        <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>

        <?php if($sale->status == 0 || $sale->status == 6 || $sale->status == 10) : ?>

            <?php 
                $total_us = $total_us + $sale->total;
                $increment = $increment + 1;
            ?>
            <?php $volume = $volume + $sale->products_sales[0]->quantity; ?>            
            <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
            <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
        <?php elseif($sale->status == 1 || $sale->status == 4 || $sale->status == 7) : ?>
            <?php
                $total = $total + $sale->total;
                $increment = $increment + 1;
            ?>
            <?php $volume = $volume + $sale->products_sales[0]->quantity; ?>
            <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
            <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
        <?php else : ?>
            <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
            <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
            
        <?php endif; ?>
        
        
        <td class="text-center"><?= date('Y-m-d', strtotime($sale->created)) ?></td>
        <td class="text-center"><span class="label label-default"><?= number_format($sale->transport_fee,2, ".", ",") ?></span></td>
        <td class="text-right"><a href="<?= ROOT_DIREC ?>/sales/edit/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th>Total (<?= $increment ?> VOYAGES - <?= number_format($volume, 2, ".", ",") ?> M3)</th>
        <th colspan="4"></th>
        <th class="text-center"></th>
        <th></th>
        <th></th>
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
        scrollX: "100px",
        scrollCollapse: true,
        paging: false,
    });
});</script>