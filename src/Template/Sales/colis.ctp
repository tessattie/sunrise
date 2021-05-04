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
        <li class="active">Manifest</li>
    </ol>
</div>
<?= $this->Flash->render() ?>

<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Manifest
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-15px;margin-top:25px">
                    <div class="col-md-3">
                        <?= $this->Form->control('station_id', array("class" => 'form-control', "options" => $stations, "empty" => "-- Choisissez --")) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $this->Form->control('destination_station_id', array("class" => 'form-control', "options" => $stations, "empty" => "-- Choisissez --")) ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left;height:32px;margin-top:43px")) ?>
                    </div>
                    <div class="col-md-8"></div>
                </div>
            <?= $this->Form->end() ?>
            <hr>
        </div>
    <div class="panel-body articles-container">
        <?php if(!empty($sales)) : ?>

            <table class="table table-stripped">
                <thead> 
                    <th>Paquet</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Destinataire</th>
                    <th class="text-center">Vol</th>
                    <th class="text-center">Poid</th>
                    <th class="text-center">Point de Départ</th>
                    <th class="text-center">Destination</th>
                    <th class="text-center">En route</th>
                    <th class="text-center">Arrivé</th>
                    <th class="text-center">Livré</th>
                    <th class="text-center">Date de création</th>
                </thead>
                <tbody> 
                    <?php foreach($sales as $sale) : ?>
                        <?php foreach($sale->products_sales as $ps) : ?>
                        <tr>
                            <td><?= $ps->barcode ?></td>
                            
                            <td class="text-center"><?= substr($sale->customer->first_name." ".$sale->customer->last_name, 0, 15) ?></td>
                            <td class="text-center"><?= substr($sale->receiver->name, 0, 15) ?></td>
                            <td class="text-center"><?= $ps->flight->name ?></td>
                            <td class="text-center"><?= $ps->quantity ?></td>
                            <td class="text-center"><?= $sale->station->name ?></td>
                            <td class="text-center"><?= $sale->destination_station->name ?></td>
                            <?php if($ps->is_loaded == 0) : ?>
                                <td class="text-center"><label class="label label-danger">Non</label></td>
                            <?php else : ?>
                                <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($ps->loaded)) ?></label></td>
                            <?php endif; ?>

                            <?php if($ps->is_landed == 0) : ?>
                                <td class="text-center"><label class="label label-danger">Non</label></td>
                            <?php else : ?>
                                <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($ps->landed)) ?></label></td>
                            <?php endif; ?>

                            <?php if($ps->is_delivered == 0) : ?>
                                <td class="text-center"><label class="label label-danger">Non</label></td>
                            <?php else : ?>
                                <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($ps->delivered)) ?></label></td>
                            <?php endif; ?>
                            <td class="text-center"><?= $sale->created ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
        
    </div>
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
