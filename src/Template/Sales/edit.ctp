<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/sales">
            Ventes
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Vente : <?= $sale->sale_number ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-cog"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/customers">
                                     Retour
                                </a></li>
                                <li><a href="<?= ROOT_DIREC ?>/sales/add">
                                   Nouvelle Vente
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
           <?= $this->Form->create($sale) ?>

            <div class="row" style="margin-top:15px">
                <div class="col-md-6"><?= $this->Form->control('charged', array('class' => 'form-control', "label" => "Chargement", "options" => array(0 => "Non", 1 => "Oui"))); ?></div>
                <div class="col-md-6"><?= $this->Form->control('sortie', array('class' => 'form-control', "label" => "Sortie", "options" => array(0 => "Non", 1 => "Oui"))); ?></div>

            </div> 
            <?php if($sale->status == 0 || $sale->status == 4) : ?>
            <div class="row" style="margin-top:15px">
                <div class="col-md-3"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Client", "options" => $customers, "value" => $sale->customer_id)); ?></div>
                <div class="col-md-3"><?= $this->Form->control('status', array('class' => 'form-control', "label" => "Devise", "options" => array(0 => "Crédit USD", 4 => "Crédit HTG"), "value" => $sale->status)); ?></div>

            </div>  
            <?php endif; ?> 
            <div class="row">
                <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
            </div>  

        <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
