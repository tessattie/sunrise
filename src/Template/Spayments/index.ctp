<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Spayment[]|\Cake\Collection\CollectionInterface $spayments
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="#">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Fournisseurs</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Paiements
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/spayments/add">
                                                <em class="fa fa-plus"></em> Nouveau Paiement
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Fournisseur</th>
                    <th class="text-center">Réquisition</th>
                    <th class="text-center">Montant</th>
                    <th class="text-center">Taux</th>
                    <th class="text-center">Créé par</th>
                    <th class="text-center">Date</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($spayments as $payment) : ?>
            <tr>
                <td><?= $payment->payment_number ?></td>
                <td class="text-center"><?= $payment->supplier->name ?></td>
                <td class="text-center"><?= $payment->requisistion_number ?></td>
                <td class="text-center"><?= $payment->amount." ".$payment->rate->name ?></td>
                <td class="text-center"><?= $payment->daily_rate ?></td>
                <td class="text-center"><?= $payment->user->first_name." ".$payment->user->last_name ?></td>
                <td class="text-center"><?= $payment->created ?></td>
                <td class="text-center"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<script type="text/javascript">$(document).ready( function () {
$('.datatable').DataTable({
        iDisplayLength: 25,
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