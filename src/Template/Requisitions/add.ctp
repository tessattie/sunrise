<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisition
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/requisitions">
            Réquisitions
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouvelle Réquisition
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/requisitions">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($requisition, array('enctype' => 'multipart/form-data')) ?>
                <div class="row">
                <div class="col-md-6"><?= $this->Form->control('uid', array('class' => 'form-control', "label" => "Numéro de Réquisition *", "placeholder" => "Numéro de Réquisition")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Client *", "options" => $customers, "style" => "height:46px", "empty" => "-- Choisissez --")); ?></div>
                    
                </div>  
                <hr>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-6"><?= $this->Form->control('photo', array('class' => 'form-control', "type" => 'file')); ?></div>
                </div>    
                <hr>
                <div class="row">
                    
                    <div class="col-md-12">
                        <table class="table table-stripped datatable">
                            <thead> 
                                <th>Produit</th>
                                <th class="text-right">Quantité</th>
                            </thead>
                            <tbody> 
                                <?php $h=0; foreach($products as $key => $value) : ?>
                                        <tr>
                                            <td><?= $value ?></td>
                                            <td class="text-right">
                                                <?= $this->Form->control('quantity.'.$h, array('class' => 'form-control', "label" => false, "placeholder" => "Quantité", "style" => "width:100px;float:right")); ?>
                                                <?= $this->Form->control('product_id.'.$h, array('value' => $key,"type" => "hidden")); ?>
                                            </td>
                                            <?php $h=$h+1 ?>
                                        </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                                </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div> 

            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
