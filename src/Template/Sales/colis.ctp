<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Paquets Attendus</li>
    </ol>
</div>
<?= $this->Flash->render() ?>

<div class="container-fluid"> 
    <?php foreach($stations as $station) : ?>
        <?php if($station->sales->count() > 0) : ?>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Paquets Attendus : <?= $station->name ?>
        </div>
    <div class="panel-body articles-container">
        
            <table class="table table-stripped">
                <thead> 
                    <th>Paquet</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Destinataire</th>
                    <th class="text-center">Poid (KG)</th>
                    <th class="text-center">Point de Départ</th>
                    <th class="text-center">Destination</th>
                    <th class="text-center">En route</th>
                    <th class="text-center">Livré</th>
                    <th class="text-center">Date de création</th>
                </thead>
                <tbody> 
                    <?php foreach($station->sales as $sale) : ?>
                        <tr>
                            <td><?= $sale->sale_number ?></td>
                            
                            <td class="text-center"><?= substr($sale->customer->first_name." ".$sale->customer->last_name, 0, 15) ?></td>
                            <td class="text-center"><?= substr($sale->receiver->name, 0, 15) ?></td>
                            <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                            <td class="text-center"><?= $sale->station->name ?></td>
                            <td class="text-center"><?= $station->name ?></td>
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
                            <td class="text-center"><?= $sale->created ?></td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        
    </div>
<?php endif; ?>
    <?php endforeach; ?>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
    } );
} );</script>

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
