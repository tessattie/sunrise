<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */

?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Nouveau Paiement</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<?= $this->Form->create("", array('id' => "customerform")) ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Paiement
        </div>
        <div class="panel-body articles-container">
        <div class="row" style="margin-left:5px">
            <div class="col-m-12">
                <div class="row">
                    <div class="col-md-4">
                    <?php   if(!empty($customer)) : ?>
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2 customer_id', "label" => "Choisissez un client", "options" => $customers, 'style' => "margin-left:17px", "empty" => "-- Choisissez --", 'value' => $customer->id)); ?>
                    <?php else : ?>
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2 customer_id', "label" => "Choisissez un client", "options" => $customers, 'style' => "margin-left:17px", "empty" => "-- Choisissez --")); ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php   if(!empty($customer)) : ?>
        <hr>    
        <div class="row">
            <div class="col-md-3">
                <?= $this->Form->control('amount', array('class' => 'form-control total_amount', "placeholder" => "Montant", "label" => false, "style" => "margin-left:4px")); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('method_id', array('class' => 'form-control', "empty" => "-- Méthode de paiement --", "options" => $methods, "label" => false, "style" => "margin-left:4px;height:46px", "required" => true)); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('memo', array('class' => 'form-control', "placeholder" => "Mémo", "label" => false, "style" => "margin-left:4px")); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('daily_rate', array('class' => 'form-control', "label" => false, "style" => "margin-left:4px;height:46px", "required" => true, 'placeholder' => "Taux du Jour", 'value' => $customer->rate->amount)); ?>
            </div>
        </div>
        <hr>    

    <table class="datatable">
        <thead> 
            <tr>
            <th></th>
            <th class="text-center">DATE</th>
            <th class="text-center">VENTE</th>
            <th class="text-center">TOTAL</th>
            <th class="text-center">DUE</th>
            <th class="text-right">PAIEMENT</th>
            </tr>
        </thead>
        <tbody> 
        <?php $total = 0; $due = 0; $paid = 0; ?>
        <?php foreach($sales as $sale) : ?>

            <?php $already_paid = 0; foreach($sale->payments_sales as $ps) : ?>
                <?php $already_paid = $already_paid + $ps->amount; ?>
            <?php endforeach; ?>
            <?php if($already_paid  < $sale->total) : ?>
                <?php $total = $total + $sale->total ?>
                <?php $due = $due + ($sale->total - $already_paid) ?>
                <tr class="sale">
                    <th style="color:#8ad919;" class="check text-center"></th>
                    <td class="text-center"><?= date("d/m/Y", strtotime($sale['created'])) ?> <?= date("g:i A", strtotime($sale['created'])) ?></td>
                    <td class="text-center"><?= $sale->sale_number ?></td>
                    <td class="text-center">
                        <span class="sale_total"><?= number_format($sale->total, 2, ".", ",") ?></span> <?= $customer->rate->name ?>
                    </td>
                    <td class="text-center">
                        <span class="sale_due"><?= number_format(($sale->total - $already_paid), 2, ".", ",") ?></span> <?= $customer->rate->name ?> <input type="hidden" name="sale_id[]" value="<?= $sale->id ?>">
                        <input type="hidden" class="due" name="due" value="<?= ($sale->total - $already_paid) ?>">
                    </td>
                    <td class="text-right clickoninput" style="cursor:pointer">
                        <input step="any" max="<?= $due ?>" type="number" class="amount" name="amounts[]" value="0.00" style="width:130px;cursor:pointer">
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th><th></th><th></th>
                <th class="text-center"><?= number_format($total, 2, ".", ",") ?></th>
                <th class="text-center" ><?= number_format($due, 2, ".", ",") ?></th>
                <th class="text-right paid"><?= number_format($paid, 2, ".", ",") ?></th>
            </tr>
        </tfoot>
        </table>
         <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style" => "height: 46px;border-radius: 0px;margin-top:20px;margin-right:15px;float:right")) ?>
        <?php   endif; ?>
        </div>
        
    </div>
</div><!--End .articles-->
<?= $this->Form->end() ?>
<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering" : false,
        scrollY: "300px",
        scrollCollapse: true,
        paging: false,
        "searching": false
    });
    });
</script>

<style>
.table-bordered>tbody>tr>td{
    font-size:12px!important;
    padding:8px!important;
}
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
    .dataTables_info{
        display:none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var check = '<span class="fa fa-check"></span>';
        $(".customer_id").change(function(){
            $("#customerform").submit();
        }); 

        $(".total_amount").change(function(){
            choose();
        })

        $(".amount").change(function(){
            calculate();
        })

        $("#DataTables_Table_0 tfoot").find(".paid").removeClass("paid")

        function check_icon(element){
            element.find('.check').empty();
            element.find('.check').append(check);
        }

        function calculate(){
            var total = $('.total_amount').val();
            var c_total = 0;
            $('.sale').each(function(){
                if($(this).find('.amount').val() != ""){
                   c_total = c_total + parseFloat($(this).find('.amount').val());  
                }
                if(parseFloat($(this).find('.amount').val()) >= parseFloat($(this).find('.due').val())){
                    check_icon($(this));
                }else{
                    $(this).find('.check').empty();
                }
            })
            $('.total_amount').val(c_total.toFixed(2));
            $('.paid').text(c_total.toFixed(2));

        }

        function choose(){
            var total = parseFloat($('.total_amount').val()); //45942.5
            // var already_paid = calculate();
            var payment = total
            $('.sale').each(function(){
                $(this).find('.amount').val(0);
                $(this).find('.check').empty();
            });

            
            $('.sale').each(function(){
                if(payment < 0){
                    $(this).find('.amount').val("");
                    check_icon($(this));
                } // continue
                var due = parseFloat($(this).find('.due').val()); // 15980
                var paid = $(this).find('.amount').val(); // 14057.5

                if(paid == ""){
                    paid = 0;
                }else{
                    paid = parseFloat(paid);
                }
                var realdue = due - paid; // 1922.5
                if(realdue > 0){
                    if(payment >= realdue){
                        $(this).find('.amount').val(due);
                        payment = payment - realdue;
                        $(this).find('.check').empty();
                        $(this).find('.check').append(check);

                    }else{
                        $(this).find('.amount').val(payment);
                        payment = 0;
                        // payment < realdue
                        
                    }
                }else{
                    payment = payment - paid;
                    // nothing is due so no action
                }
            })
            $('.paid').text(total.toFixed(2));
            // calculate();
        }

        
    })
</script>
