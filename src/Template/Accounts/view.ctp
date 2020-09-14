<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 */
$rates= array(1 => "HTG", 2 => "USD");
$types = [1=>"Débit", 2=>"Crédit"];
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/accounts">
            Comptes
        </a></li>
        <li class="active"><?= $account->account_number ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
        <?php if(!empty($account->customer)) : ?>
            Compte #<?= $account->account_number ?> : <?= $account->customer->first_name." ".$account->customer->last_name ?>
        <?php else : ?>
            Compte #<?= $account->account_number ?> : <?= $account->name ?>
        <?php endif; ?>
            
        </div>
    <div class="panel-body articles-container">

    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
           <table class="table table-bordered" style="margin-bottom:60px">
               <thead>
                   <tr>
                       <th class="text-center">Numéro</th>
                       <th class="text-center">Devise</th>
                       <th class="text-center">Client</th>
                       <th class="text-center">Créé par</th>
                       <th class="text-center">Créé le</th>
                       <th class="text-center">Dernière Modification</th>
                       <th class="text-center" style="vertical-align:middle">Balance <button type="button" class="btn btn-success" style="float:right;">
  <a href="<?= ROOT_DIREC ?>/accounts/refresh/<?= $account->id ?>" style="color:white"><em class="fa fa-refresh"></em></a>
</button></th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                    <td><?= $account->account_number ?></td>
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
                    <td class="text-center"><?= $account->modified ?></td>
                    <?php if($account->balance >= 0 ) : ?>
                        <td class="text-center"><span class="label label-success"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php endif; ?>
                </tr>
               </tbody>
           </table>
        <hr>
        <h4 style="text-align:left"><strong>Transactions</strong>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#newTransaction" style="float:right;margin-top:-8px">
  <em class="fa fa-plus"></em>
</button></h4>
        <hr>
        <table class="table table-stripped datatable">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Utilisateur</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Vente</th>
                    <th class="text-right">Montant</th>
                </thead>
            <tbody> 
            <?php foreach($account->transactions as $transaction) : ?>
                <tr>
                    <td class="text-left"><?= $transaction->transaction_number ?></td>
                    <td class="text-center"><?= strtoupper($transaction->user->last_name) . " " . ucfirst(strtolower($transaction->user->first_name)) ?></td>
                    <td class="text-center"><?= $transaction->description ?></td>
                    <td class="text-center"><?= $transaction->created ?></td>
                    <td class="text-center"><?= $types[$transaction->type] ?></td>
                    <td class="text-center">
                      <?php if(!empty($transaction->sale_id)) : ?>
                       <a href="<?= ROOT_DIREC ?>/sales/view/<?= $transaction->sale->id ?>" target="_blank"><?= $transaction->sale->sale_number ?></a> 
                      <?php else : ?>
                        -
                      <?php endif; ?>
                    </td>
                    <?php if($transaction->type == 1) : ?>
                        <td style="color:red;font-weight:bold;text-align:right">-<?= number_format($transaction->amount, 2, ".", ",")." ".$rates[$account->rate_id] ?></td>
                    <?php else : ?>
                        <td style="color:green;font-weight:bold;text-align:right"><?= number_format($transaction->amount, 2, ".", ",")." ".$rates[$account->rate_id] ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->



<!-- Modal -->
<div class="modal fade" id="newTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <?= $this->Form->create($transaction, array("url" => "/transactions/add")) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouvelle Transaction</h5>
      </div>
      <div class="modal-body">
        <?php  
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $account->customer_id]);
            echo $this->Form->control('account_id', ['type' => 'hidden', 'value' => $account->id]);
            echo $this->Form->control('amount', ['label' => "Montant", 'placeholder' => "Montant", "class" => "form-control", "style" => "margin-bottom:15px", "value" => ""]);
            echo $this->Form->control('type', ['options' => [1=>"Débit", 2=>"Crédit"], 'label' => "Type", "empty" => "-- Choisissez --", "class" => "form-control", "style" => "margin-bottom:15px"]);
            echo $this->Form->control('description', ['label' => "Description", "placeholder" => "Ex : Ajustement Balance", "class" => "form-control", "style" => "margin-bottom:15px", "value" => "Dépôt sur Compte"]);
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

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering": false,
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
        text-align:left!important;
    }
</style>