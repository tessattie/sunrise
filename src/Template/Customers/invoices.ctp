

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?= $this->Form->create("", array('url' => "/exports/invoices_pdf")) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Exporter en PDF</h5>
      </div>
      <div class="modal-body">
      <label>Pour envoyer par e-mail, indiquez l'adresse du client ci-dessous. Pour exporter sans envoyez, laissez le champ ci-dessous vide.</label>
      <hr>
        <?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail", "placeholder" => "E-mail : abc@exemple.com", 'value' => (!empty($customer->email)) ? $customer->email : "")); ?>
        <?= $this->Form->control('customer_id', array("type" => "hidden",'value' => (!empty($customer->id)) ? $customer->id : "")); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:right")) ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Clients</li>
    </ol>
    <?php if(!empty($customer)) : ?>
    <a href="<?= (!empty($customer) ? ROOT_DIREC.'/exports/invoices/'.$customer->id.'/'.$month.'/'.$year : '#') ?>" target="_blank" style="float:right;
    margin-top: -34px;
    margin-right: 40px;
    padding: 3px 10px;
    background: black;
    color: white;text-decoration:none!important;cursor:pointer">Excel</a>
    <a href="<?= "#" ?>" target="_blank" data-toggle="modal" data-target="#exampleModal" style="float:right;
    margin-top: -34px;
    margin-right: 100px;
    padding: 3px 10px;
    background: black;
    color: white;text-decoration:none!important;cursor:pointer">PDF</a>
<?php endif; ?>
</div>
<?= $this->Flash->render() ?>

<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Factures <br>
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-20px;margin-top:25px">
                    <div class="col-md-3">
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2', "empty" => "-- Client --", "options" => $customers, "label" => false, "style" => "width:100%")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                    <div class="col-md-8"></div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container" style="padding-top:75px">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Heure</th>
                <th class="text-center">Vente #</th>
                <th class="text-center">Camion</th>
                <th class="text-center">Produit</th>
                <th class="text-center">Volume</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($sales)) : ?>
                <tr><td colspan="7" class="text-center">Choisissez le client et le mois correspondant...</td></tr>
            <?php else : ?>
                <?php $product_name = "ab"; $total_prod = 0; $total = 0; $volume=0;$volume_prod=0; $increment = 0;$increment_prod=0;?>
                <?php foreach($sales as $sale) : ?>
                    <?php $total = $total + $sale['total']; $volume = $volume + $sale['quantity']; $increment = $increment + 1;  ?>
                    <?php if($product_name != $sale['name'] && $product_name != "ab") : ?>
                        <tr style="background:#F2F2F2"><th colspan="4">TOTAL</th><th class="text-center"><?= $increment_prod ?></th><th class="text-center"><?= $volume_prod ?> M3</th><th class="text-center"><?= number_format($total_prod, 2, ".", ",") ?> <?= $customer->rate->name ?></th></tr>
                        <?php $total_prod = 0;$volume_prod = 0; $increment_prod=0; ?>
                    <?php endif; ?>
                    <?php if($product_name != $sale['name']) : ?>
                        <tr style="background:#ddd"><th colspan="7"><?= $sale['name'] ?></th></tr>
                        <?php $product_name = $sale['name'] ?>
                    <?php endif; ?>
                    
                    
                    <?php $total_prod = $total_prod + $sale['total']; $increment_prod = $increment_prod + 1; $volume_prod = $volume_prod + $sale['quantity']; ?>
                    <tr>
                        <td class="text-center"><?= date("d/m/Y", strtotime($sale['created'])) ?></td>
                        <td class="text-center"><?= date("g:i A", strtotime($sale['created'])) ?></td>
                        <td class="text-center"><?= $sale['sale_number'] ?></td>
                        <td class="text-center"><?= $sale['immatriculation'] ?></td>
                        <td class="text-center"><?= $sale['abbreviation'] ?></td>
                        <td class="text-center"><?= $sale['quantity'] ?> M3</td>
                        <td class="text-center"><?= number_format($sale['total'], 2, ".", ",") ?> <?= $customer->rate->name ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="background:#F2F2F2"><th colspan="4">TOTAL</th><th class="text-center"><?= $increment_prod ?></th><th class="text-center"><?= $volume_prod ?> M3</th><th class="text-center"><?= number_format($total_prod, 2, ".", ",") ?> <?= $customer->rate->name ?></th></tr>
                <tr style="background:#DC143C;color:white"><th colspan="4">TOTAL</th><th class="text-center"><?= $increment ?></th><th class="text-center"><?= $volume ?> M3</th><th class="text-center"><?= number_format($total, 2, ".", ",") ?> <?= $customer->rate->name ?></th></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
} );</script>

<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }
</style>
