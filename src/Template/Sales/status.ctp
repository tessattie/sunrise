<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale[]|\Cake\Collection\CollectionInterface $sales
 */

$discounts = array(0 => "HTG", 1 => "%");
$ouinon = array(0=> "Non", 1 => "Oui");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Chargement / Sortie</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/status" target="_blank" style="float:right;
        margin-top: -34px;
        margin-right: 40px;
        padding: 3px 10px;
        background: black;
        color: white;text-decoration:none!important;cursor:pointer">Excel</a>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Chargement / Sortie
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Camion</th>

                    <th class="text-center">Produit</th>
                    <th class="text-center">Volume</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Heure</th>
                    <th class="text-center">Chargement</th>
                    <th class="text-center">Sortie</th>
                </thead>
            <tbody> 
        <?php $sous = 0; $reductions = 0; $total = 0; $sous_us = 0; $reductions_us = 0; $total_us = 0; $fiches = 0; foreach ($sales as $sale): ?>
        <?php $fiches = $fiches + 1; ?>
            <tr>
                <td class="text-center"><a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center"><?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>

                <td class="text-center"><?= $sale->products_sales[0]->product->name ?></td>
                    <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                    <?php $total = $total + $sale->products_sales[0]->quantity; ?>

                <td class="text-center"><?= date('Y-m-d', strtotime($sale->created)) ?></td>
                <td class="text-center"><?= date('h:i A', strtotime($sale->created)) ?></td>

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
                
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th class="text-center"><?= $total ?> M3</th>
                <th class="text-center"><?= $fiches ?> Fiches</th>
                <thcolspan="3"></th>
            </tr>
        </tfoot>
        </table>

            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pdf', 'print'
        ],
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
    });
});</script>

<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }
</style>
