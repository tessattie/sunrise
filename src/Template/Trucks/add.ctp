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
            Camions
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Camion
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
                    <div class="col-md-4"><?= $this->Form->control('immatriculation', array('class' => 'form-control', "label" => "Immatriculation *", "placeholder" => "Immatriculation")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Statut *")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label>Benne : </label>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-4"><?= $this->Form->control('length', array('class' => 'form-control', "label" => "Longueur *", "placeholder" => 'Longueur')); ?></div>
                            <div class="col-md-4"><?= $this->Form->control('width', array('class' => 'form-control', "label" => "Largeur *", "placeholder" => 'Largeur')); ?></div>
                            <div class="col-md-4"><?= $this->Form->control('height', array('class' => 'form-control', "label" => "Hauteur *", "placeholder" => 'Hauteur')); ?></div>
                        </div> 
                    </div>

                    <div class="col-md-6">
                        <label>Verrin : </label>
                        <div class="row" style="margin-top:15px">
                        <div class="col-md-4"><?= $this->Form->control('lengthv', array('class' => 'form-control', "label" => "Longueur *", "placeholder" => 'Longueur')); ?></div>
                            <div class="col-md-4"><?= $this->Form->control('widthv', array('class' => 'form-control', "label" => "Largeur *", "placeholder" => 'Largeur')); ?></div>
                            <div class="col-md-4"><?= $this->Form->control('heightv', array('class' => 'form-control', "label" => "Hauteur *", "placeholder" => 'Hauteur')); ?></div>
                            
                        </div> 
                    </div>
                </div>
                 
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->control('volume', array('class' => 'form-control', "label" => "Volume *", "placeholder" => 'Volume')); ?>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-6"><?= $this->Form->control('photo', array('class' => 'form-control', "type" => 'file', "required" => false)); ?></div>
                </div> 

                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  

            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
