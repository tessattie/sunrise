<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/sales/colis">
            Manifest
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Statut Paquet : <?= $productsSale->barcode ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-cog"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/customers">
                                     Retour
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
           <?= $this->Form->create($productsSale) ?>

            <div class="row" style="margin-top:15px">
                <div class="col-md-2"><?= $this->Form->control('flight_id', array('class' => 'form-control', "label" => "Vol", "options" => $flights, 'empty' => "-- Choisissez --")); ?></div>
                <div class="col-md-3"><?= $this->Form->control('is_loaded', array('class' => 'form-control', "label" => "En Route", "options" => array(0 => "Non", 1 => "Oui"))); ?></div>
                <div class="col-md-3"><?= $this->Form->control('is_landed', array('class' => 'form-control', "label" => "Arrivé", "options" => array(0 => "Non", 1 => "Oui"))); ?></div>
                <div class="col-md-3"><?= $this->Form->control('is_delivered', array('class' => 'form-control', "label" => "Livré", "options" => array(0 => "Non", 1 => "Oui"))); ?></div>

            </div> 
            <div class="row">
                <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
            </div>  

        <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
