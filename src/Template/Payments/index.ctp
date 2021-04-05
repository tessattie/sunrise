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
                <th></th>
                <th>#</th>
                <th class="text-center">Date</th>
                <th class="text-center">Montant</th>
                <th class="text-center">Taux</th>
                <th class="text-center">Méthode</th>
                <th class="text-center">Mémo</th>
                <th class="text-center">Statut</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($payments as $payment) : ?>
                <tr>
                    <?php if($payment->status == 0) : ?>
                        <td><a onclick="return confirm('Etes-vous sur de vouloir réactiver ce paiement?')" href="<?= ROOT_DIREC ?>/payments/cancel/<?= $payment->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-check color-green" style="color:green"></span></a></td>
                    <?php else : ?>
                        <td><a onclick="return confirm('Etes-vous sur de vouloir annuler ce paiement?')" href="<?= ROOT_DIREC ?>/payments/cancel/<?= $payment->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-remove color-red"></span></a></td>
                    <?php endif; ?>
                    
                    <td>10<?= $payment->id ?></td>
                    <td class="text-center"><?= date("d M Y", strtotime($payment->created)) ?></td>
                    <td class="text-center"><?= number_format($payment->amount, 2, ".", ",") . " " . $payment->rate->name ?></td>
                    <td class="text-center"><?= $payment->daily_rate ?></td>
                    <td class="text-center"><?= $payment->method->name ?></td>
                    <td class="text-center"><?= $payment->memo ?></td>
                    <?php if($payment->status == 0) : ?>
                        <td class="text-center"><span class="label label-danger">Annulé</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success">Actif</span></td>
                    <?php endif; ?>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/payments/edit/<?= $payment->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> <a target="_blank" href="<?= ROOT_DIREC ?>/payments/receipt/<?= $payment->id ?>" style="font-size:1.3em!important;color:green"> <span class="fa fa-xl fa-eye color-yellow"></span></a></td>
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
