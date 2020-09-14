<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement[]|\Cake\Collection\CollectionInterface $movements
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Coffre</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Transactions de Coffre<br>
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-20px;margin-top:25px">
                    
                    <div class="col-md-3">
                        <?= $this->Form->control('currency_id', array('class' => 'form-control select2', "empty" => "-- Devise --", "options" => $currencies, "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('type', array('class' => 'form-control',"options" => $types, "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('user_id', array('class' => 'form-control',"options" => $users, "label" => false, "style" => "width:100%", "empty"=>"-- Utilisateur --")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?><br>   
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Type</th>
                    <th class="text-center">Montant</th>
                    <th class="text-center">Utilisateur</th>
                    <th class="text-center">Mémo</th>
                    <th class="text-center">Date</th>
                </thead>
            <tbody> 
        <?php foreach($movements as $movement) : ?>
                <tr>
                    <?php if($movement->type == 1) : ?>
                        <td><span class="label label-info">CREDIT</span></td>
                    <?php else : ?>
                        <td><span class="label label-warning">DEBIT</span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= number_format($movement->montant, 2, ".", ",") ?> <?= $movement->currency->abbr ?></td>
                    <td class="text-center"><?= $movement->user->first_name." ".$movement->user->last_name ?></td>
                    <td class="text-center"><?= $movement->description ?></td>
                    <td class="text-center"><?= date("Y-m-d H:i", strtotime($movement->created)) ?></td>
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
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
           'pdf', 'print'
        ],
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
    });
});
</script>

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
    #DataTables_Table_0_wrapper{
        margin-top:57px;
    }
</style>

