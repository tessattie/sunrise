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
            <?= $this->Form->create() ?>
            <div class="row" style="margin-left:-15px;">
            <div class="col-md-5">Manifest</div>
            
                
                    <div class="col-md-2">
                        <?= $this->Form->control('station_id', array("class" => 'form-control', "options" => $stations, "empty" => "-- Station --", "label" => false)) ?>
                    </div>

                    <div class="col-md-2">
                        <?= $this->Form->control('flight_id', array("class" => 'form-control', "options" => $flights, "empty" => "-- Vol --", "label" => false)) ?>
                    </div>

                    <div class="col-md-2">
                        <?= $this->Form->control('movement_id', array("class" => 'form-control', "options" => $movements, "empty" => "-- Statut --", "label" => false)) ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left;height:32px;")) ?>
                    </div>
                    
                </div>
            
            <?= $this->Form->end() ?>
        </div>
        
    <div class="panel-body articles-container">
        <?php if(!empty($sales)) : ?>

            <table class="table table-stripped datatable">
                <thead> 
                    <th>Paquet</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Destinataire</th>
                    <th class="text-center">Vol</th>
                    <th class="text-center">Poid</th>
                    <th class="text-center">Point de Départ</th>
                    <th class="text-center">Destination</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Date de Création</th>
                    <th></th>
                </thead>
                <tbody> 
                    <?php $weight = 0; foreach($sales as $sale) : ?>
                            <?php 
                            $weight = $weight + $sale->products_sale->quantity;
                            ?>
                        <tr>
                            <td><?= $sale->products_sale->barcode ?></td>
                            
                            <td class="text-center"><?= substr($sale->products_sale->sale->customer->first_name." ".$sale->products_sale->sale->customer->last_name, 0, 15) ?></td>
                            <td class="text-center"><?= substr($sale->products_sale->sale->receiver->name, 0, 15) ?></td>
                            <?php if(!empty($sale->flight_id)) : ?>
                            <td class="text-center"><?= $sale->flight->name ?></td>
                            <?php else : ?>
                                <td></td>
                            <?php endif; ?>
                            <td class="text-center"><?= $sale->products_sale->quantity ?></td>
                            <td class="text-center"><?= $sale->station->name ?></td>
                            <td class="text-center"><?= $sale->products_sale->sale->destination_station->name ?></td>
                            
                            <td class="text-center" style="color:red"><?= $sale->movement->name ?></td>
                            
                            <td class="text-center"><?= date("Y-m-d H:i", strtotime($sale->created)) ?></td>
                            <td class="text-right"><a href="<?= ROOT_DIREC ?>/trackings/edit/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Poid Total</th>
                    <th class="text-center"><?= number_format($weight, 2, ".", ",") ?></th>
                    <th colspan="5"></th>
                </tr>
            </tfoot>
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

