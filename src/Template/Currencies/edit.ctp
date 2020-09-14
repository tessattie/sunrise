<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Currency $currency
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Taux
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Taux : <?= $currency->name ?>
        </div>
    <div class="panel-body articles-container">       
           <?= $this->Form->create($currency) ?>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('rate_buy', array('class' => 'form-control', "label" => "Taux de Vente *", "placeholder" => "Taux de Vente")); ?></div>
                <div class="col-md-6"><?= $this->Form->control('rate_sale', array('class' => 'form-control', "label" => "Taux d'Achat *", "placeholder" => "Taux d'Achat")); ?></div>                
            </div>
  
            <div class="row">
                <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
            </div>  


        <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
