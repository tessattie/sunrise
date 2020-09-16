<table class="table table-striped datatable" style="width:100%!important">
                <thead> 
                    <th>Numéro</th>
                    <th>Type</th>
                    <th class="text-center">Caissier</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Chargé</th>
                    <th class="text-center">Sortie</th>
                    <th class="text-center">Produit</th>
                    <th class="text-center">Volume</th>
                    <th class="text-center">Total HTG</th>
                    <th class="text-center">Total USD</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Heure</th>
                    <th class="text-center">Transport</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php $sous = 0; $reductions = 0; $total = 0; $sous_us = 0; $reductions_us = 0; $total_us = 0; $volume=0; foreach ($sales as $sale): ?>
            <tr <?php if($sale->status == 0 || $sale->status == 4 || $sale->status == 6 || $sale->status == 7) : ?> style="background:#d9edf7" <?php endif; ?>>
                <td class="text-center"> <a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center">
                    <?php if($sale->status == 0 || $sale->status == 7) : ?>
                        <span class="label label-info">CR</span>
                    <?php endif; ?>
                    <?php if($sale->status == 1) : ?>
                        <span span class="label label-primary"> CASH</span>
                    <?php endif; ?>
                    <?php if($sale->status == 4 || $sale->status == 6) : ?>
                        <span class="label label-warning"> CH</span>
                    <?php endif; ?>
                    <?php if($sale->status == 0 || $sale->status == 3 || $sale->status == 6 || $sale->status == 9) : ?>
                        <span class= "label label-success">USD</span>
                    <?php endif; ?>
                    <?php if($sale->status == 4 || $sale->status == 5 || $sale->status == 7 || $sale->status == 8) : ?>
                        <span class= "label label-primary">HTG</span>
                    <?php endif; ?>
                    <?php if($sale->status == 2 || $sale->status == 3 || $sale->status == 5 || $sale->status == 8 || $sale->status == 9) : ?>
                        <span class= "label label-danger">X</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?= $sale->has('user') ? $this->Html->link(substr($sale->user->last_name, 0,1).substr($sale->user->first_name, 0,1), ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('customer') ? $this->Html->link(substr($sale->customer->first_name." ".$sale->customer->last_name, 0, 15), ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>

                <?php if($sale->charged == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($sale->charged_time)) ?></label></td>
                <?php endif; ?>

                <?php if($sale->sortie == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($sale->sortie_time)) ?></label></td>
                <?php endif; ?>

                <?php if($sale->status == 0 || $sale->status == 6) : ?>

                    <?php 
                        $total_us = $total_us + $sale->total;
                    ?>

                    
                    <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
                    <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                    <td class="text-center">-</td>
                    <td class="text-center"><?= number_format($sale->total, 2, ".", ",") ?></td>
                <?php else : ?>
                    <?php
                        $total = $total + $sale->total;
                    ?>
                    <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
                    <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                    <td class="text-center"><?= number_format($sale->total, 2, ".", ",") ?></td>
                    <td class="text-center">-</td>
                <?php endif; ?>
                
                <?php $volume = $volume + $sale->products_sales[0]->quantity; ?>
                <td class="text-center"><?= date('Y-m-d', strtotime($sale->created)) ?></td>
                <td class="text-center"><?= date('h:i A', strtotime($sale->created)) ?></td>
                <?php if($sale->transport == 0) : ?>
                    <td class="text-center"><span class="label label-default">Non</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-primary">Oui</span></td>
                <?php endif; ?>
                <td class="text-right"><a href="<?= ROOT_DIREC ?>/sales/edit/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <th>Total</th>
            <th colspan="7"></th>
            <th class="text-center"><?= number_format($volume, 2, ".", ",") ?></th>
            <th class="text-center"><?= number_format($total, 2, ".", ",") ?></th>
            <th class="text-center"><?= number_format($total_us, 2, ".", ",") ?></th>
            <th></th>
    	    <th></th>
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
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
        scrollY: "400px",
        scrollX: "1700px",
        scrollCollapse: true,
        paging: false,
    });
});</script>