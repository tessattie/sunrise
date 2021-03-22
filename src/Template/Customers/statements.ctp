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
                    <?php $balance = $customer_balance_before; ?>
                    <input type="hidden" id ="customer_balance_before" value="<?= $customer_balance_before ?>">
                    <input type="hidden" id ="customer_rate" value="<?= $customer->rate->name ?>">
                    <tr>
                        <th>Date</th>
                        <th class="text-center">#</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Taux</th>
                        <th class="text-center">Débit</th>
                        <th class="text-center">Crédit</th>
                        <th class="text-center">Balance Avant</th>
                        <th class="text-right">Balance Après</th>
                    </tr> 
                </thead>
            <tbody> 
                <?php foreach($sales as $sale) : ?>
                    
                    <tr class="statement_row">
                        <td><?= date("Y-m-d H:i", strtotime($sale->created)) ?></td>
                        <td class="text-center"><?= $sale->sale_number ?></td>
                        
                        <td class="text-center"><span class="row_amount"><?= number_format($sale->total, 2, ".", "") ?> </span>
                         <span class="row_currency"><?= $sale->customer->rate->name ?></span> </td>
                        <td class="text-center">-</td>
                        <th class="text-center" style="color:red"><span class="row_debit"><?= number_format($sale->total, 2, ".", "") ?></span> <?= $sale->customer->rate->name ?></th>
                        <th class="text-center"></th>
                        <th class="text-center balance_before"></th>
                        <th class="text-right balance_after"></th>
                    </tr>
                <?php endforeach; ?>
                <?php foreach($payments as $payment) : ?>
                    <tr class="statement_row">
                        <td><?= date("Y-m-d H:i", strtotime($payment->created)) ?></td>
                        <td class="text-center">10<?= $payment->id ?></td>
                        
                        <td class="text-center"><span class="row_amount"><?= number_format($payment->amount, 2, ".", "") ?> </span>
                         <span class="row_currency"><?= $payment->rate->name ?></span> </td>
                        <td class="text-center"><span class="row_daily_rate"><?= number_format($payment->daily_rate, 2, ".", "") ?></span></td>
                        <td class="text-center"></td>
                        <?php if($payment->rate_id != $customer->rate_id) : ?>
                            <?php if($payment->rate_id == 1) : ?>
                                <th class="text-center" style="color:green"><span class="row_credit"><?= number_format($payment->amount/$payment->daily_rate, 2, ".", "") ?></span>  <?= $customer->rate->name ?></th>
                            <?php else : ?>
                                <th class="text-center" style="color:green"><span class="row_credit"><?= number_format($payment->amount*$payment->daily_rate, 2, ".", "") ?></span>  <?= $customer->rate->name ?></th>
                            <?php endif; ?>
                        <?php else : ?>
                            <th class="text-center" style="color:green"><span class="row_credit"><?= number_format($payment->amount, 2, ".", "") ?> </span> <?= $customer->rate->name ?></th>
                        <?php endif; ?>
                        <th class="text-center balance_before"></th>
                        <th class="text-right balance_after"></th>
                    </tr>
                <?php endforeach; ?>
                
        </tbody>
        <tfoot>
            <tr><th colspan = "7">Balance courante</th><th class="text-right"><?= number_format($customer_balance, 2, ".", ",") ?>  <?= $customer->rate->name ?></th></tr>
        </tfoot>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {

    var rates = ["", "HTG", "USD"];
        function setBalance(){

            var balance_before = parseFloat($("#customer_balance_before").val());

            $(".statement_row").each(function(){
                $(this).find(".balance_before").text(balance_before.toFixed(2)+ ' ' +$("#customer_rate").val());
                var credit = parseFloat($(this).find(".row_credit").text());
                var debit = parseFloat($(this).find(".row_debit").text());
                // alert(isNaN(credit));
                if(!isNaN(credit)){
                    balance_before = balance_before - credit;
                }

                if(!isNaN(debit)){
                    balance_before = balance_before + debit;
                }
                $(this).find(".balance_after").text(balance_before.toFixed(2)+ ' ' +$("#customer_rate").val());
            });

        }
        setBalance();

    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
    } );
    setBalance();
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


