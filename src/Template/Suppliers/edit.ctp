<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="#">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/suppliers">
            Fournisseurs
        </a></li>
        <li class="active">Modifier</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Modifier Fournisseur : <?= $supplier->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/products">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>

    <div class="panel-body articles-container">       
            <?= $this->Form->create($supplier) ?>
                <div class="row">
                <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "label" => "Téléphone *", "placeholder" => "Téléphone")); ?></div>
                 <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "Email *", "placeholder" => "Email")); ?></div>   
                </div> 
                <hr>    
                <div class="row">
                <div class="col-md-4"><?= $this->Form->control('item_id', array('class' => 'form-control', "label" => "Produit", "empty" => "-- Choisissez --", "options" => $products)); ?></div>
                </div>
                 
                 
                    <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div> 

            <?= $this->Form->end() ?>
        </div>
        
    </div>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Ajouter des camions à ce fournisseur 
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/products">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>

    <div class="panel-body articles-container">       
            <?= $this->Form->create("", array('url' => '/trucks/save')) ?>

                <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th colspan="3">Camions</th></tr> 
                            <tr>
                                <th class="text-center">Immatriculation</th>
                                <th class="text-center">Code Barre</th>
                                <th class="text-center" style="width:92px"></th>
                            </tr>
                            <tr>
                                <th><?= $this->Form->control('supplier_id', array('type' => 'hidden', "label" =>false, "value" => $supplier->id)); ?><?= $this->Form->control('immatriculation', array('class' => 'form-control', "label" =>false, "placeholder" => "Immatriculation")); ?></th>
                                <th><?= $this->Form->control('barcode', array('class' => 'form-control', "label" =>false, "placeholder" => "Code Barre")); ?></th>
                                <th><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"")) ?></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($supplier->suppliers_trucks as $sp) : ?>
                                <tr>
                                    <td class="text-center"><?= $sp->truck->immatriculation ?></td>
                                    <td class="text-center"><?= $sp->code ?></td>
                                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/supplierstrucks/delete/<?= $sp->id ?>"><span class="glyphicon glyphicon-trash" style="color:red"></span></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                    
                </div>  

            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->


<style type="text/css">
    select{
        height:45px!important;
    }
</style>