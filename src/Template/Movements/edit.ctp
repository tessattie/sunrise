<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement $movement
 */
$validations = array(1 => "OUI", 0 => "NON")
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li>
            <em class="fa fa-home"></em>
        </li>
        <li><a href="<?= ROOT_DIREC ?>/movements">
            Mouvements
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Mouvement : <?= $movement->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/movements">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($movement) ?>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('with_flight', array('class' => 'form-control', "label" => "Associé à un Vol *", 'options' => $validations)); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('customer_validation', array('class' => 'form-control', "label" => "Validation Client *", 'options' => $validations)); ?></div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->