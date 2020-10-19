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
                 
                 
                    <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div> 

            <?= $this->Form->end() ?>
        </div>
        
    </div>


    <div class="panel panel-default">
    <div class="panel-body tabs">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Camions</a></li>
            <li><a href="#tab2" data-toggle="tab">Contraventions</a></li>
            <li><a href="#tab3" data-toggle="tab">Réceptions</a></li>
            <li><a href="#tab4" data-toggle="tab">Paiements</a></li>
            <li><a href="#tab5" data-toggle="tab">Résumé</a></li>
        </ul>
        <div class="tab-content">

        <div class="tab-pane fade" id="tab4">
            <div class="modal fade" id="newPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
              <?= $this->Form->create('', array("url" => "/suppliers/newpayment")) ?>
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau paiement</h5>
                  </div>
                  <div class="modal-body">
                    <?php  
                        echo $this->Form->control('supplier_id', ['type' => 'hidden', 'value' => $supplier->id]);
                        echo $this->Form->control('amount', ['label' => "Montant", 'placeholder' => "Montant", "class" => "form-control", "style" => "margin-bottom:15px", "value" => ""]);
                        echo $this->Form->control('rate_id', ['options' => [1=>"HTG", 2=>"USD"], 'label' => "Devise", "empty" => "-- Choisissez --", "class" => "form-control", "style" => "margin-bottom:15px"]);
                        echo $this->Form->control('type', ['options' => [1=>"CASH", 2=>"CHEQUE"], 'label' => "Type", "empty" => "-- Choisissez --", "class" => "form-control", "style" => "margin-bottom:15px"]);
                        echo $this->Form->control('daily_rate', ['label' => "Taux du Jour", 'placeholder' => "Taux du Jour", "class" => "form-control", "style" => "margin-bottom:15px", "value" => ""]);
                        echo $this->Form->control('requisition_number', ['label' => "Réquisition", 'placeholder' => "Réquisition", "class" => "form-control", "style" => "margin-bottom:15px", "value" => ""]);
                    ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success')) ?>
                  </div>
                </div>
                <?= $this->Form->end() ?>
              </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr style="background:#F3F3F3">
                        <th class="text-center">#</th>
                        <th class="text-center">Réquisition</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Montant HTG</th>
                        <th class="text-center">Montant USD</th>
                        <th class="text-center">Taux</th>
                        <th class="text-center">Créé par</th>
                        <th class="text-center">Créé le</th>
                        <th class="text-center"><button class="btn btn-warning" data-toggle="modal" data-target='#newPayment'><span class="fa fa-plus" style="margin-top:3px!important"></span></button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $htg=0;$usd=0;$ptotal=0; foreach($supplier->payments as $payment) : ?>
                        <tr>
                            <td class="text-center"><?= $payment->id + 4000 ?></td>
                            <td class="text-center"><?= $payment->requisition_number ?></td>
                            <?php if($payment->type == 1) : ?>
                                <td class="text-center">CASH</td>
                            <?php else : ?>
                                <td class="text-center">CHEQUE</td>
                            <?php endif; ?>
                            <?php if($payment->rate_id == 1) : ?>
                                <?php $htg = $htg + $payment->amount ?>
                                <?php $ptotal = $ptotal + $payment->amount ?>
                                <td class="text-center"><?= number_format($payment->amount, 2, ".", ",") . " " . $payment->rate->name ?></td>
                                <td></td>
                            <?php else : ?>
                                <?php $usd = $usd + $payment->amount ?>
                                <?php $ptotal = $ptotal + $payment->amount*$payment->daily_rate ?>
                                <td></td>
                                <td class="text-center"><?= number_format($payment->amount, 2, ".", ",")." ".$payment->rate->name ?></td>
                            <?php endif; ?>
                            <td class="text-center"><?= number_format($payment->daily_rate, 2, ".", ",") ?> HTG</td>
                            <td class="text-center"><?= $payment->user->first_name." ".$payment->user->last_name ?></td>
                            <td class="text-center"><?= $payment->created ?></td>
                            <td class="text-center"><a href="<?= ROOT_DIREC ?>/spayments/delete/<?= $payment->id ?>" style="font-size:18px;color:red" onclick="return confirm('Etes-vous sur de vouloir supprimer le paiement?')"><span class="fa fa-trash" style="margin-top:3px!important"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>  
                <tfoot>
                    <tr>
                        <th colspan="3">TOTAL</th>
                        <th class="text-center"><?= number_format($htg,2) ?> HTG</th>
                        <th class="text-center"><?= number_format($usd,2) ?> HTG</th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="tab-pane fade" id="tab3">
            <table class="table table-bordered">
                <thead> 
                <tr style="background:#F3F3F3">
                    <th class="text-center">Numéro</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Produit</th>
                    <th class="text-center">Coût</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Zone</th>
                    <th class="text-center">Date de Réception</th>
                    <th class="text-center"></th></tr>
                </thead>
                
            <tbody> 
        <?php $volume=0;$rtotal=0; foreach($supplier->receivings as $receiving) : ?>
                <tr>
                    <td class="text-center"><?= $receiving->receiving_number ?></td>
                    <td class="text-center"><?= $receiving->truck->immatriculation ?></td>
                    <td class="text-center"><?= $receiving->item->name ?></td>
                    <td class="text-center"><?= number_format($receiving->cost,2,".",",") ?></td>
                    <td class="text-center"><?= $receiving->quantity ?></td>
                    <td class="text-center"><?= number_format($receiving->cost*$receiving->quantity,2,".",",") ?></td>
                    <?php if($receiving->status == 1) : ?>
                        <td class="text-center">  <span class="label label-info"> NOUVEAU</span></td>
                    <?php elseif($receiving->status == 2) : ?>
                        <td class="text-center">  <span class="label label-warning"> VALIDE</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success"> LIVRE</span></td>
                    <?php endif; ?>
                    <?php if($receiving->type == 1) : ?>
                        <td class="text-center"><span class="label label-info"><?= $types[$receiving->type] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-default"><?= $types[$receiving->type] ?></span></td>
                    <?php endif; ?>
                    
                    <td class="text-center"><?= $receiving->created ?></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/receivings/edit/<?= $receiving->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                    </td>
                </tr>
                <?php 
                    $volume = $volume + $receiving->quantity;
                    $rtotal = $rtotal + $receiving->cost*$receiving->quantity;
                ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">TOTAL</th>
                <th class="text-center"><?= $volume ?></th>
                <th class="text-center"><?= number_format($rtotal,2,".",",") ?></th>
                <th colspan="4"></th>
            </tr>
        </tfoot>
        </table>
                        </div>

                            <div class="tab-pane fade in active" id="tab1">
                                <div class="panel panel-default articles">


    <div class="panel-body articles-container">       
            

                <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3">
                                <th class="text-center" colspan="2">Immatriculation</th>
                                <th class="text-center">Code Barre</th>
                                <th class="text-center">Produit</th>
                                <th class="text-center" style="width:92px"></th>
                            </tr>
                            <?= $this->Form->create("", array('url' => '/trucks/save')) ?>
                            <tr style="background:#F3F3F3">
                                <th colspan="2"><?= $this->Form->control('supplier_id', array('type' => 'hidden', "label" =>false, "value" => $supplier->id)); ?><?= $this->Form->control('immatriculation', array('class' => 'form-control', "label" =>false, "placeholder" => "Immatriculation", 'required' => true)); ?></th>
                                <th><?= $this->Form->control('barcode', array('class' => 'form-control', "label" =>false, "placeholder" => "Code Barre", 'required' => true)); ?></th>
                                <th><?= $this->Form->control('item_id', array('class' => 'form-control', "label" =>false, "empty" => "-- Choisissez --", 'required' => true, 'options' => $products)); ?></th>
                                <th><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"")) ?></th>
                            </tr>
                            <?= $this->Form->end() ?>
                        </thead>
                        <tbody> 
                            <?php $trucks=[]; foreach($supplier->suppliers_trucks as $sp) : ?>
                            <?php $trucks[$sp->truck_id] = $sp->truck->immatriculation; ?>
                                <tr>
                                    <td style="width:30px"><a href="<?= ROOT_DIREC ?>/supplierstrucks/delete/<?= $sp->id ?>"><span class="glyphicon glyphicon-trash" style="color:red"></span></a></td>
                                    <td class="text-center"><?= $sp->truck->immatriculation ?></td>
                                    <td class="text-center"><?= $sp->code ?></td>
                                    <td class="text-center"><?= $sp->item->name ?></td>
                                    <td class="text-center"><a href="#" data-toggle="modal" data-target="#export_<?= $sp->id ?>"><span class="glyphicon glyphicon-export" style="color:blue"></span></a></td>
                                </tr>

                                <div class="modal fade" id="export_<?= $sp->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                  <?= $this->Form->create("", array('url' => '/suppliers/export')) ?>
                                  <?= $this->Form->control('supplier_id', array('type' => 'hidden', "value" =>$supplier->id)); ?>
                                  <?= $this->Form->control('id', array('type' => 'hidden', "value" =>$sp->id)); ?>
                                  <?= $this->Form->control('truck_id', array('type' => 'hidden', "value" =>$sp->truck->id)); ?>
                                    <div class="modal-content">
                                      <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel"><span class='glyphicon glyphicon-check'></span> Exporter</h4>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">   
                                            <div class="col-md-12">
                                                <?= $this->Form->control('type', array('class' => 'form-control', "label" =>"Type", "empty" => "-- Choisissez --", 'options' => array(1 => 'Vide', 2 => 'Rempli'))); ?>
                                            </div>
                                        </div> 
                                        <hr>    
                                        <div class="row">   
                                            <div class="col-md-12">
                                            <label>De :</label>
                                                <input value="<?= $filterto  ?>" class = "form-control" type="date" name="from" style="">
                                            </div>
                                        </div> 
                                        <div class="row" style="margin-top:10px">   
                                            <div class="col-md-12">
                                            <label>A :</label>
                                                <input value="<?= $filterto  ?>" type="date" name="to" class="form-control">
                                            </div>
                                        </div>  
                                      </div>
                                      <div class="modal-footer">
                                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"")) ?>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                      </div>
                                    </div>
                                    <?= $this->Form->end() ?>
                                  </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                    
                </div>  

            
        </div>
        
    </div>
</div>
<div class="tab-pane fade" id="tab2">
    <div class="panel panel-default articles">


    <div class="panel-body articles-container">       
            

                <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3">
                                <th class="text-center">Contravention</th>
                                <th class="text-center">Camion</th>
                                <th class="text-center">Prix (HTG)</th>
                                <th class="text-center">Créé Par</th>
                                <th class="text-center">Date</th>
                                <th class="text-center" style="width:92px"></th>
                            </tr>
                            <?= $this->Form->create("", array('url' => '/violations/save')) ?>
                            <tr style="background:#F3F3F3">
                                <th colspan="3"><?= $this->Form->control('supplier_id', array('type' => 'hidden', "label" =>false, "value" => $supplier->id)); ?><?= $this->Form->control('violation_id', array('class' => 'form-control', "options" => $violations, "label" =>false, "empty" => "-- Choisissez --")); ?></th>
                                <th colspan="2"><?= $this->Form->control('truck_id', array('class' => 'form-control', "options" => $trucks, "label" =>false, "empty" => "-- Choisissez --")); ?></th>
                                <th><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"")) ?></th>
                            </tr>
                            <?= $this->Form->end() ?>
                        </thead>
                        <tbody> 
                            <?php $ctotal = 0; foreach($supplier->violations as $violation) : ?>
                                <tr>
                                <td class="text-center"><?= $violation->violation->name ?></td>
                                <td class="text-center"><?= $violation->truck->immatriculation ?></td>
                                <td class="text-center"><?= number_format($violation->price,0,".",",") ?> HTG</td>
                                <td class="text-center"><?= $violation->user->first_name." ".$violation->user->last_name ?></td>
                                <td class="text-center"><?= $violation->created ?></td>
                                <td class="text-center"><a href="<?= ROOT_DIREC ?>/suppliers/deleteviolation/<?= $violation->id ?>"><span class="glyphicon glyphicon-trash" style="color:red"></span></a></td>
                                <?php $ctotal = $ctotal + $violation->price; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="2">TOTAL</th>
                                <th class="text-center"><?= number_format($ctotal,0,".",",") ?> HTG</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                    
                </div>  

            
        </div>
        
    </div>
                            </div>





<div class="tab-pane fade" id="tab5">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Réceptions</th>
                <th class="text-center">Contraventions</th>
                <th class="text-center">Payé</th>
                <th class="text-center">Différence</th>
            </tr>
        </thead>
        <tbody> 
            <tr>
                <td class="text-center"><?= number_format($rtotal, 2, ".", ",") ?> HTG</td>
                <td class="text-center"><?= number_format($ctotal, 2, ".", ",") ?> HTG</td>
                <td class="text-center"><?= number_format($ptotal, 2, ".", ",") ?> HTG</td>
                <td class="text-center"><?= number_format(($rtotal-$ctotal-$ptotal), 2, ".", ",") ?> HTG</td>
            </tr>
        </tbody>
    </table>
</div>



                        </div>
                    </div>
                </div><!--/.panel-->

    
</div><!--End .articles-->


<style type="text/css">
    select{
        height:45px!important;
    }
</style>