<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/flights">
            Vols
        </a></li>
        <li class="active">Editer</li>
        <li class="active"><?= $flight->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Vol : <?= $flight->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/flights">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($flight) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('station_id', array('class' => 'form-control', "label" => "Station", "options" => $stations, 'style' => 'height:46px')); ?></div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
