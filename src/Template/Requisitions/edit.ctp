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
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer la Réquisition : <?= $requisition->uid ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cog"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/requisitions">
                                                 Retour
                                            </a></li>
                                            <li><?= $this->Form->postLink(
                                                     __('Supprimer'),
                                                    ['action' => 'delete', $requisition->id],
                                                    ['confirm' => __('Etes-vous sûr de vouloir supprimer la réquisition {0}?', $requisition->name)]
                                                )       
                                            ?></li>
                                            <li><a href="<?= ROOT_DIREC ?>/requisitions/add">
                                               Nouvelle Réquisition
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
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
                                <th class="text-right">Utilisé</th>
                            </thead>
                            <tbody> 
                                <?php $h=0; foreach($products as $key => $value) : ?>
                                        <tr>
                                            <td><?= $value ?></td>
                                            <td class="text-center">
                                            <?php $condition=false; 
                                            foreach($requisition->products as $product){
                                                if($key == $product->id){
                                                    $condition =true;
                                                    $quantity = $product->get('_joinData')['quantity'];
                                                    $used = $product->get('_joinData')['used'];
                                                }
                                            }

                                            ?>
                                            <?php if($condition) : ?>
                                                <?= $this->Form->control('quantity.'.$h, array('class' => 'form-control', "label" => false, "placeholder" => "Quantité", "style" => "width:100px;float:right", 'value' => $quantity)); ?>
                                            <?php else : ?>
                                                <?= $this->Form->control('quantity.'.$h, array('class' => 'form-control', "label" => false, "placeholder" => "Quantité", "style" => "width:100px;float:right")); ?>
                                            <?php endif; ?>


                                                
                                                <?= $this->Form->control('product_id.'.$h, array('value' => $key,"type" => "hidden")); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php if($condition) : ?>
                                                    <?= $this->Form->control('used.'.$h, array('class' => 'form-control', "label" => false, "placeholder" => "Utilisé", "style" => "width:100px;float:right", 'value' => $used)); ?>
                                                <?php else : ?>
                                                    <?= $this->Form->control('used.'.$h, array('class' => 'form-control', "label" => false, "placeholder" => "Utilisé", "style" => "width:100px;float:right")); ?>
                                                <?php endif; ?>
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
