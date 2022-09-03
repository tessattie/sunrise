<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Etat de Compte</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading" style="padding-bottom:130px">
            Etat de Compte<br>
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-20px;margin-top:25px">
                    <div class="col-md-3">
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2', "empty" => "-- Client --", "options" => $customers, "label" => false, "style" => "width:100%")); ?>
                    </div>

                    <div class="col-md-3">
                        <?= $this->Form->control('export', array('class' => 'form-control', "empty" => "-- Export --", "options" => array(1 => "PDF"), "label" => false, "style" => "width:100%")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                    <div class="col-md-8"></div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <?php  if(!empty($customer)) : ?>
                    <?php $balance = $customer_balance_before; ?>

                    <input type="hidden" id ="customer_balance_before" value="<?= $customer_balance_before ?>">
                    <input type="hidden" id ="customer_rate" value="USD">
                <?php endif; ?>
                    <tr>
                        <th>Date</th>
                        <th class="text-center">#</th>
                        <th class="text-center">Mémo</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Balance Avant</th>
                        <th class="text-right">Balance Après</th>
                    </tr> 
                </thead>
            <tbody> 
                <?php $balance = 0; foreach($sales as $sale) : ?>
                    <tr class="statement_row">
                        <td><?= date("Y-m-d H:i", strtotime($sale['created'])) ?></td>
                        <td class="text-center"><?= $sale['number'] ?></td>
                        <td class="text-center"><?= $sale['memo'] ?></td>
                        <th class="text-center"><span class="row_debit"><?= number_format($sale['amount'], 2, ".", ",") ?></span></th>
                        
                        
                        <th class="text-center balance_before"><?= number_format($balance, 2, ".", ",") ?></th>
                        <?php $balance = $balance + $sale['amount'] ?>
                        <th class="text-right balance_after"><?= number_format($balance, 2, ".", ",") ?></th>
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


