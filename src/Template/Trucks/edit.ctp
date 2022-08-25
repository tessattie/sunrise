<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/trucks">
            Paquets
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <?= $this->Form->create($truck) ?>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Paquet : <?= $truck->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/trucks">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => 'Nom')); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('immatriculation', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Statut *")); ?></div>
                </div>
                 
                <hr>

                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('min_weight', array('class' => 'form-control', 'style' => "height:46px", "label" => "Poid Minimum *", 'placeholder' => "Poid Minimum")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('max_weight', array('class' => 'form-control', 'style' => "height:46px", "label" => "Poid Maximum *", 'placeholder' => "Poid Maximum")); ?></div>
                </div>
                        <?= $this->Form->control('volume', array('type' => 'hidden', "value" => 0)); ?>
                <hr>

                <div class="row">
                </div>  

            
        </div>
        
    </div>

    <div class="panel panel-default articles">
                <div class="panel-body articles-container" style="height:400px;overflow-y:scroll">       
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Station</th>
                                <th class="text-center">Prix (USD)</th>
                                <th class="text-right">Taxe (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($stations as $station) : ?>
                                <?php  
                                    $price = '';$taxe = '';
                                    foreach($station->trucks_stations as $ca){
                                        if($ca->station_id == $station->id){
                                            $price =$ca->price;
                                             $taxe =$ca->taxe;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?= h($station->name) ?></td>

                                    <td class="text-center">
                                        <?= $this->Form->control('station_id[]', array('type' => 'hidden', "value" => $station->id)); ?>
                                        <?= $this->Form->control('price[]', array('class' => 'form-control', "label" => false, "value" => $price, "style" => "width:100px;margin:auto")); ?>
                                    </td>

                                    <td class="text-right">
                                        <?= $this->Form->control('taxe[]', array('class' => 'form-control', "label" => false, "value" => $taxe, "style" => "width:100px;float:right")); ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                </div>
                <div class="panel-footer">
                    <div class="row">
                            <div class="col-md-12"><?= $this->Form->button(__('Sauvegarder'), array('class'=>'btn btn-success', "style"=>"float:right")) ?></div>
                        </div> 
                </div>
                
            </div>
            <?= $this->Form->end() ?>
</div><!--End .articles-->
