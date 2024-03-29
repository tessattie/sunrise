<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li>
            <em class="fa fa-home"></em>
        </li>
        <li><a href="<?= ROOT_DIREC ?>/stations">
            Stations
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Station : <?= $station->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/stations">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($station) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('abbreviation', array('class' => 'form-control', "label" => "Abréviation *", "placeholder" => "Abréviation")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('taxe', array('class' => 'form-control', "label" => "Taxe *", "placeholder" => "Taxe")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('address', array('class' => 'form-control', "label" => "Adresse *", "placeholder" => "Adresse")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "label" => "Téléphone *", "placeholder" => "Téléphone")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail *", "placeholder" => "E-mail")); ?></div>
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
