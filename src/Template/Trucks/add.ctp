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
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Paquet
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/trucks">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($truck, array('enctype' => 'multipart/form-data')) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => 'Nom')); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('immatriculation', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Statut *", 'value' => 0)); ?></div>
                </div>
                 
                <hr>

                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('min_weight', array('class' => 'form-control', 'style' => "height:46px", "label" => "Poid Minimum *", 'placeholder' => "Poid Minimum")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('max_weight', array('class' => 'form-control', 'style' => "height:46px", "label" => "Poid Maximum *", 'placeholder' => "Poid Maximum")); ?></div>
                </div>
                        <?= $this->Form->control('volume', array('type' => 'hidden', "value" => 0)); ?>
                <hr>

                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  

            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
