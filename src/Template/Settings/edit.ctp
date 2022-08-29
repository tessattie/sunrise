<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li>
            <em class="fa fa-home"></em>
        </li>
        <li>
            Configurations
        </li>
        <li class="active">Editer</li>
        <li class="active">Code PIN Superviseur</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Code PIN Superviseur
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/stations">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($setting) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('value', array('class' => 'form-control', "label" => "PIN *", "placeholder" => "PIN", "min" => '1000', "max" => '9999', "type" => "number")); ?></div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->