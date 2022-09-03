<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
$currency = 1;
$discounts = array(0 => $currency, 1 => "%");
if($sale->status == 0 || $sale->status == 2 || $sale->status == 6 || $sale->status == 10 || $sale->status == 11){
    $currency = 2;
}
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/sales">
            Ventes
        </a></li>
        <li class="active">Fiche #<?= $sale->sale_number ?></li>
    </ol>
</div>
<div id="invoice">

<div class="invoice overflow-auto">
    
<?php if($sale->type == 2) : ?>
    <p class= "bg bg-info" style="padding:10px;text-align:center"> Fiche Crédit</p>
<?php endif; ?>
<?php if($sale->type == 1) : ?>
    <p class= "bg bg-primary" style="padding:10px;text-align:center"> Fiche Cash</p>
<?php endif; ?>
<?php if($sale->status == 2) : ?>
    <p class= "bg bg-danger" style="padding:10px;text-align:center"> Fiche Annulée</p>
<?php endif; ?>
        <div style="min-width: 600px">
            <main>
                <div class="row contacts">
                    <div class="col-md-6 invoice-to">
                        <div class="text-gray-light">FICHE #<?= $sale->sale_number ?></div>
                        <div class="text-gray-light">Client (Expéditeur) : <?= strtoupper($sale->customer->last_name)." ".$sale->customer->first_name . " - ".$sale->customer->phone ?></div>
                        <div class="text-gray-light">Agent : <?= $sale->user->first_name." ".$sale->user->last_name ?></div>
                    </div>
                    <div class="col-md-6 invoice-details">
                    <?php if($sale->status == 0 || $sale->status == 1 || $sale->status == 4|| $sale->status == 6 || $sale->status == 7) : ?>
                    <button class="btn btn-danger" style="margin-bottom:10px"><a href="<?= ROOT_DIREC ?>/sales/cancel/<?= $sale->id ?>" style="color:white">Annuler</a></button>
                <?php endif; ?>
                        <div class="date">Date : <?= $sale->created ?></div>

                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">Colis</th>
                            <th class="text-right">Poid</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sale->products_sales as $sp) : ?>
                        <tr>
                            <td class="text-center"><?= $this->Html->image('sales/'.$sp->image_path, ['style' => 'height:100px']); ?></td>
                            <td class="text-left">
                                <?= $sp->barcode." - ".$sp->truck->immatriculation ?>
                            </td>
                            <td class="text-right"><?= $sp->quantity ?> LBS</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2">SOUS-TOTAL</td>
                            <td class="text-right"><?= number_format($sale->subtotal,2, ".", ",") ?> USD</td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">REDUCTION (<?= $sale->discount.$discounts[$sale->discount_type] ?>)</td>
                            <?php if($sale->discount_type == 0) : ?>
                                <td class="text-right"><?= number_format($sale->discount, 2, ".", ",") ?></td>
                            <?php else : ?>
                                <td class="text-right"><?= number_format(($sale->subtotal*$sale->discount/100), 2, ".", ",") ?></td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">Taxe</td>
                            <td class="text-right"><?= number_format($sale->taxe,2, ".", ",") ?>  USD</td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">TOTAL</td>
                            <td class="text-right"><?= number_format($sale->total,2, ".", ",") ?>  USD</td>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <table class="table table-striped"> 
                    <thead> 
                        <tr>
                            <th colspan="3">Paiements</th>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <th class="text-center">Devise</th>
                            <th class="text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sale->payments as $payment) : ?>
                            <tr>
                             <td><?= $payment->method->name ?></td>
                              <td class="text-center"><?= $payment->rate->name ?></td>
                               <td class="text-right"><?= $payment->amount ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                             <td>Monnaie</td>
                             <?php
                             $rate_name = 'USD';
                             foreach($rates as $id => $name){
                                if($id == $sale->change_rate_id){
                                    $rate_name = $name;
                                }
                             } 
                             ?>
                              <td class="text-center"><?= $rate_name ?></td>
                              <?php if($sale->change_rate_id != 2) : ?>
                                <td class="text-right"><?= number_format($sale->monnaie*$sale->change_rate, 2, ".", ",") ?></td>
                              <?php else : ?>
                                <td class="text-right"><?= $sale->monnaie ?></td>
                              <?php endif; ?>
                               
                            </tr>
                    </tbody>
                </table>

                
                        <?php foreach($sale->products_sales as $ps) : ?>
                            <hr>
                <table class="table table-bordered"> 
                    <thead> 
                        <tr>
                            <th colspan="9" style="vertical-align:middle">Tracking - <?= $ps->barcode ?>
                                <button class="btn btn-default" style="float:right;margin-left:5px;padding:0px 10px 5px 10px" data-toggle="modal" data-target="#new_tracking_<?= $ps->id ?>"><span class="fa fa-plus"></span></button></th>
                        </tr>
                        <tr>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Station</th>
                            <th class="text-center">Vol</th>
                            <th class="text-center">Agent</th>
                            <th class="text-center">Commentaire</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Heure</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach($ps->trackings as $tracking) : ?>
                            <tr>
                                <td><?= $tracking->movement->name ?></td>
                                <?php   if(!empty($tracking->station)) : ?>
                                    <td class="text-center"><?= $tracking->station->name ?></td>
                                <?php   else : ?>
                                    <td class="text-center"></td>
                                <?php   endif; ?>

                                <?php   if(!empty($tracking->flight)) : ?>
                                    <td class="text-center"><?= $tracking->flight->name ?></td>
                                <?php   else : ?>
                                    <td class="text-center"></td>
                                <?php   endif; ?>

                                <?php   if(!empty($tracking->user)) : ?>
                                    <td class="text-center"><?= $tracking->user->first_name." ".$tracking->user->last_name ?></td>
                                <?php   else : ?>
                                    <td class="text-center"></td>
                                <?php   endif; ?>
                                
                                <td class="text-center"><?= $tracking->comment ?></td>
                                <td class="text-center"><?= date('Y-m-d', strtotime($tracking->created)) ?></td>
                                <td class="text-center"><?= date('H:i A', strtotime($tracking->created)) ?></td>
                                <td class="text-center"><a href="<?= ROOT_DIREC ?>/trackings/edit/<?= $tracking->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> <a href="<?= ROOT_DIREC ?>/trackings/delete/<?= $tracking->id ?>" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                </table>
                        <?php endforeach; ?>

                    
        </div>

    </div>
</div>

<?php foreach($sale->products_sales as $ps) : ?>
<div class="modal fade" id="new_tracking_<?= $ps->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouveau Tracking</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/trackings/add')) ?>
      <?= $this->Form->control('products_sale_id', array('type' => 'hidden', "value" => $ps->id)); ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('movement_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $movements, "label" => "Statut *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                <div class="col-md-6"><?= $this->Form->control('station_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $stations, "label" => "Station *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 

            </div>
            <hr>    
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('flight_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $flights, "label" => "Vol *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 

            </div>

            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('comment', array('class' => 'form-control', "label" => "Commentaire *", "placeholder" => "Commentaire")); ?></div>
            </div>
           

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endforeach; ?>
<style type="text/css">
    #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 45px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice #editedTable {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice #editedTable td,.invoice #editedTable th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice #editedTable th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice #editedTable td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice #editedTable .total,.invoice #editedTable .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice #editedTable .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice #editedTable .unit {
    background: #ddd
}

.invoice #editedTable .total {
    background: #3989c6;
    color: #fff
}

.invoice #editedTable tbody tr:last-child td {
    border: none
}

.invoice #editedTable tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice #editedTable tfoot tr:first-child td {
    border-top: none
}

.invoice #editedTable tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice #editedTable tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
