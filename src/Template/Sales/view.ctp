<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */

$currency = $sale->customer->rate->name;
$discounts = array(0 => $currency, 1 => "%");
if($sale->status == 0){
    $currency = " USD";
}
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/ventes">
            Ventes
        </a></li>
        <li class="active">Fiche #<?= $sale->sale_number ?></li>
    </ol>
</div>
<div id="invoice">

<div class="invoice overflow-auto">
    
<?php if($sale->status == 0 || $sale->status == 3 || $sale->status == 7 || $sale->status == 8) : ?>
    <p class= "bg bg-info" style="padding:10px;text-align:center"> Fiche Crédit</p>
<?php endif; ?>
<?php if($sale->status == 1 || $sale->status == 2) : ?>
    <p class= "bg bg-primary" style="padding:10px;text-align:center"> Fiche Cash</p>
<?php endif; ?>
<?php if($sale->status == 4 || $sale->status == 5 || $sale->status == 6 || $sale->status == 9) : ?>
    <p class= "bg bg-warning" style="padding:10px;text-align:center"> Fiche Chèque</p>
<?php endif; ?>
<?php if($sale->status == 2 || $sale->status == 3 || $sale->status == 5 || $sale->status == 8 || $sale->status == 9) : ?>
    <p class= "bg bg-danger" style="padding:10px;text-align:center"> Fiche Annulée</p>
<?php endif; ?>
        <div style="min-width: 600px">
            <main>
                <div class="row contacts">
                    <div class="col-md-6 invoice-to">
                        <div class="text-gray-light">FICHE #<?= $sale->sale_number ?></div>
                        <div class="text-gray-light">Client (Expéditeur) : <?= $sale->has('customer') ? $this->Html->link(strtoupper($sale->customer->last_name)." ".$sale->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></div>
                        <div class="text-gray-light">Produit : <?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></div>
                        <div class="text-gray-light">Agent : <?= $sale->has('user') ? $this->Html->link($sale->user->first_name." ".$sale->user->last_name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></div>
                    </div>
                    <div class="col-md-6 invoice-details">
                    <?php if($sale->status == 0 || $sale->status == 1 || $sale->status == 4|| $sale->status == 6 || $sale->status == 7) : ?>
                    <button class="btn btn-danger" style="margin-bottom:10px"><a href="<?= ROOT_DIREC ?>/sales/cancel/<?= $sale->id ?>" style="color:white">Annuler</a></button>
                <?php endif; ?>
                        <div class="date">Date : <?= $sale->created ?></div>
                        <div class="date">En route : <?= ($sale->charged == 0) ? "<label class='label label-danger'>Non</label>" : "<label class='label label-success'>Oui</label>" ?></div>
                        <div class="date">Livré : <?= ($sale->sortie == 0) ? "<label class='label label-danger'>Non</label>" : "<label class='label label-success'>Oui</label>" ?></div>

                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0" id="editedTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">PRODUIT</th>
                            <th class="text-center">PRIX (M3)</th>
                            <th class="text-center">POID</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sale->products_sales as $sp) : ?>
                        <tr>
                            <td class="no text-center">1</td>
                            <td class="text-left"><h3>
                                <a href="<?= ROOT_DIREC ?>/products/view/<?= $sp->id ?>" target="_blank">
                                <?= $sp->product->name ?>
                                </a>
                                </h3>
                            </td>
                            <td class="unit text-center"><?= number_format($sp->price,2, ".", ",") ?> <?= $currency ?></td>
                            <td class="qty text-center"><?= $sp->quantity ?> LBS</td>
                            <td class="total"><?= number_format($sp->price*$sp->quantity,2, ".", ",") ?><?= $currency ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SOUS-TOTAL</td>
                            <td><?= number_format($sale->subtotal,2, ".", ",") ?> <?= $currency ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">REDUCTION (<?= $sale->discount.$discounts[$sale->discount_type] ?>)</td>
                            <?php if($sale->discount_type == 0) : ?>
                                <td><?= number_format($sale->discount, 2, ".", ",") ?></td>
                            <?php else : ?>
                                <td><?= number_format(($sale->subtotal*$sale->discount/100), 2, ".", ",") ?></td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TOTAL</td>
                            <td><?= number_format($sale->total,2, ".", ",") ?> <?= $currency ?></td>
                        </tr>
                    </tfoot>
                </table>
                <?php if($sale->status != 0) : ?>
            <?php endif; ?>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div class="row" style="margin-bottom:25px">
        <div class="col-md-4">
        <label>Photo du colis :</label><br>
            <?= $this->Html->image('load/truck.jpg', ['alt' => 'CakePHP']); ?>
        </div>
    </div>
    </div>
</div>
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
