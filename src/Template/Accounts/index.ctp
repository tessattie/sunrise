<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account[]|\Cake\Collection\CollectionInterface $accounts
 */
$rates= array(1 => "HTG", 2 => "USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Comptes</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Comptes
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/accounts/add">
                                    <em class="fa fa-plus"></em> Nouveau Compte 
                                </a></li>
                                <li><a href="<?= ROOT_DIREC ?>/accounts/refresh_all">
                                    <em class="fa fa-refresh"></em> Rafraichir les balances
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
                    <th>Numéro</th>
                    <th class="text-center">Devise</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Créé par</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-right">Balance</th>
                </thead>
            <tbody> 
        <?php foreach($accounts as $account) : ?>
            <?php if($account->id != 4 && $account->id != 3) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/accounts/view/<?= $account->id ?>" target="_blank"><?= $account->account_number ?></a></td>
                    <?php if($account->rate_id == 1) : ?>
                        <td class="text-center"><span class="label label-primary">HTG</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success">USD</span></td>
                    <?php endif; ?>
                    <?php if(!empty($account->customer)) : ?>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $account->customer->id ?>" target="_blank"><?= strtoupper($account->customer->last_name) . " " . ucfirst(strtolower($account->customer->first_name)) ?></a></td>
                    <?php else : ?>
                        <td class="text-center"><?= $account->name ?></td>
                    <?php endif; ?>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/users/view/<?= $account->user->id ?>" target="_blank"><?= strtoupper($account->user->last_name) . " " . ucfirst(strtolower($account->user->first_name)) ?></a></td>
                    <td class="text-center"><?= $account->created ?></td>
                    <?php if($account->balance >= 0 ) : ?>
                        <td class="text-right"><span class="label label-success"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php else : ?>
                        <td class="text-right"><span class="label label-danger"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
    </div>
</div><!--End .articles-->



<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        'ordering' : false,
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

