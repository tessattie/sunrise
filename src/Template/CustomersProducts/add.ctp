<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersProduct $customersProduct
 */
$rates = array(1 => "HTG", 2 => "USD");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/customersProducts">
            Spécials Clients
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Prix Spécial
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/customersProducts">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($customersProduct) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Client *", "empty" => "-- Choisissez --", 'options' => $customers)); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('product_id', array('class' => 'form-control', "label" => "Produit *", "empty" => "-- Choisissez --", 'options' => $products)); ?></div>
                </div>  
                <div class="row" style="margin-top:15px">
                    <div class="col-md-3"><?= $this->Form->control('price', array('class' => 'form-control', 'placeholder' => "Prix USD", "label" => "Prix *")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('rate_id', array('class' => 'form-control', "label" => "Devise *", "options" => $rates)); ?></div>
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->