<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
$customer_number = rand(1000, 9999);
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Clients
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Client
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/customers">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
        <?= $this->Form->create($customer) ?>
            <div class="row">
                <div class="col-md-3"><?= $this->Form->control('customer_number', array('class' => 'form-control', "label" => "Numéro Client *", "placeholder" => "Numéro Client ", 'value' => $customer_number)); ?></div>
                <div class="col-md-3"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Compagnie *", "placeholder" => "Compagnie")); ?></div>
                <div class="col-md-3"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "Représentant *", "placeholder" => "Représentant")); ?></div>
                <div class="col-md-3"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "Email ", "placeholder" => "Email")); ?></div>                    
            </div>

            <div class="row" style="margin-top:15px">
                <div class="col-md-4"><?= $this->Form->control('credit_limit', array('class' => 'form-control', "label" => "Limite de Crédit *", "placeholder" => "Limite de Crédit (USD)")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('discount', array('class' => 'form-control', "type" => "text", "label" => "Réduction *", "placeholder" => "Réduction (USD)")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('discount_type', array('class' => 'form-control', "options" => $types_reductions, 'style' => "height:46px", "label" => "Type de Réduction *")); ?></div>

            </div>  

            <div class="row" style="margin-top:15px">
                <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "label" => "Téléphone", "placeholder" => "Téléphone")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('type', array('class' => 'form-control', "label" => "Type", "options" => array(1 => "Crédit", 2 => "Chèque"))); ?></div>
                <div class="col-md-2"><?= $this->Form->control('status', array('class' => 'form-control', "label" => "Type", "options" => array(1 => "Actif", 0 => "Bloqué"))); ?></div>
                <div class="col-md-2"><?= $this->Form->control('rate_id', array('class' => 'form-control', "label" => "Devise", "options" => array(1 => "HTG", 2 => "USD"))); ?></div>

            </div>   
            <div class="row">
                <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
            </div>  


        <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->