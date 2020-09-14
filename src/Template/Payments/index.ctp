<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
$rates = array(1=>"HTG", 2=>"USD")
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Paiements</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Clients
        </div>
    <div class="panel-body articles-container">
             <table class="datatable">
                 <thead>
                     <tr><th>Clients</th></tr>
                 </thead>
                 <tbody>
                     <?php foreach($customers as $key => $value) : ?>
                        <?php if($key != 1) : ?>
                            <?php 
                                if($customer == $key){
                                    $class = "class='boldcustomer'";
                                }else{
                                    $class="";
                                }
                            ?>
                        <tr <?= $class ?>>
                            <td><a <?= $class ?> style="color:black;text-decoration:none" href="<?= ROOT_DIREC ?>/payments/index/<?= $key ?>"><?= $value ?></a></td>
                        </tr>
                    <?php endif; ?>
                     <?php endforeach; ?>
                 </tbody>
             </table>
        </div>
    </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Paiements : <?= (!empty($cust)) ? $cust->last_name : "" ?> <span class="label label-info"><?= (!empty($cust)) ? number_format($cust->balance, 2, ".", ",")." ".$rates[$cust->rate_id] : "" ?></span>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                        <?php if(!empty($customer)) : ?>
                                            <li><a href="<?= ROOT_DIREC ?>/payments/add/<?= $customer ?>">
                                                <em class="fa fa-plus"></em> Nouveau Paiement
                                            </a></li>
                                        <?php else : ?>
                                            <li><a href="<?= ROOT_DIREC ?>/payments/add">
                                                <em class="fa fa-plus"></em> Nouveau Paiement
                                            </a></li>
                                        <?php endif; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
    <table class="table datable table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Montant</th>
                <th class="text-center">Ventes</th>
                <th class="text-center">Payé</th>
                <th class="text-center">Restant</th>
                <th class="text-center">Méthode</th>
                <th class="text-center">Mémo</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($payments as $payment) : ?>
                <?php 
                $used = 0; 
                foreach($payment->payments_sales as $ps){
                    $used = $used + $ps->amount;
                }
                ?>
                <tr>
                    <td><?= $payment->id ?></td>
                    <td class="text-center"><?= number_format($payment->amount, 2, ".", ",") . " " . $payment->rate->name ?></td>
                    <td class="text-center"><span class="label label-warning"><?= count($payment->payments_sales) ?></span></td>
                    <td class="text-center"><?= number_format($used, 2, ".", ",") . " " . $payment->rate->name ?></td>
                    <td class="text-center"><?= number_format(($payment->amount - $used), 2, ".", ",") . " " . $payment->rate->name ?></td>
                    <td class="text-center"><?= $payment->method->name ?></td>
                    <td class="text-center"><?= $payment->memo ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/payments/edit/<?= $payment->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a><a target="_blank" href="<?= ROOT_DIREC ?>/payments/receipt/<?= $payment->id ?>" style="font-size:1.3em!important;color:green"> <span class="fa fa-xl fa-eye color-yellow"></span></a><a target="_blank" href="#" style="font-size:1.3em!important;color:red" data-toggle="modal" data-target="#exampleModal<?= $payment->id ?>" > <span class="fa fa-xl fa-envelope color-yellow"></span></a></td>

                    <div class="modal fade" id="exampleModal<?= $payment->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <?= $this->Form->create("", array('url' => "/payments/receipt/".$payment->id)) ?>
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Envoyer par email</h5>
                          </div>
                          <div class="modal-body">
                          <label>Pour envoyer par e-mail, indiquez l'adresse du client ci-dessous.</label>
                          <hr>
                            <?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail", "placeholder" => "E-mail : abc@exemple.com", 'value' => (!empty($payment->customer->email)) ? $payment->customer->email : "")); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:right")) ?>
                          </div>
                          <?= $this->Form->end() ?>
                        </div>
                      </div>
                    </div>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            <!--End .article-->
        </div>
    </div>
    </div>
</div>
    
</div><!--End .articles-->



<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
        "language": {
            "search": "",
            "searchPlaceholder": "Recherche"
        }
    });
} );</script>

<style type="text/css">
    #DataTables_Table_0_filter, #DataTables_Table_0_filter label, #DataTables_Table_0_filter input{
        width:100%;
        margin-right:9px;
    }
    #DataTables_Table_0_filter input{
        border: 1px solid #ddd;
    padding: 10px;
    }
    a:hover{
        font-weight:bold;
    }
    .boldcustomer{
        font-weight:bold;
        background:#f2f2f2!important;
    }
</style>
