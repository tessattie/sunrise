<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate $rate
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/rates">
            Taux du jour
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Taux du Jour : <?= $rate->name ?>
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($rate) ?>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('amount', array('class' => 'form-control', "label" => "Taux *", "placeholder" => "1 USD =")); ?></div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
