<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Edition Paiement</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<?= $this->Form->create($payment, array('id' => "customerform")) ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edition Paiement
        </div>
        <div class="panel-body articles-container">
        <label>Client : <?= $customer->last_name ?></label>
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
                <?= $this->Form->control('daily_rate', array('class' => 'form-control', "label" => false, "style" => "margin-left:4px;height:46px", "required" => true, 'placeholder' => "Taux du Jour", 'value' => $payment->daily_rate)); ?>
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
        <?php $total = 0; $due = 0; $paid = 0; $in_array = array();  ?>
        <?php foreach($sales as $sale) : ?>
            <?php if(!in_array($sale->id, $in_array)) : ?>
            <?php 
                if(!in_array($sale->id, $in_array)){
                    array_push($in_array, $sale->id);
                }
            ?>
            
            <?php $already=0; $already_paid = 0; ?>
            <?php foreach($sale->payments_sales as $ps) : ?>
                <?php $already = $already + $ps->amount ?>
                <?php if($ps->payment_id == $payment->id) : ?>
                    <?php $already_paid = $already_paid + $ps->amount; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php $total = $total + $sale->total ?>
            <?php $due = $due + ($sale->total - $already) ?>
            <?php $paid = $paid + $already_paid ?>
            <tr class="sale">
                <th style="color:#8ad919;" class="check text-center">
                    <?php if(($sale->total - $already) <= 0) : ?>
                        <span class="fa fa-check"></span>
                    <?php endif; ?>
                </th>
                <td class="text-center"><?= date("d/m/Y", strtotime($sale['created'])) ?> <?= date("g:i A", strtotime($sale['created'])) ?></td>
                <td class="text-center"><?= $sale->sale_number ?></td>
                <td class="text-center">
                    <span class="sale_total"><?= number_format($sale->total, 2, ".", ",") ?></span> <?= $customer->rate->name ?>
                </td>
                <td class="text-center">
                    <span class="sale_due"><?= number_format(($sale->total - $already), 2, ".", ",") ?></span> <?= $customer->rate->name ?> <input type="hidden" name="sale_id[]" value="<?= $sale->id ?>">
                    <input type="hidden" class="due" name="due" value="<?= ($sale->total - $already) ?>">
                </td>
                <td class="text-right clickoninput" style="cursor:pointer">
                    <input step="any" type="number" class="amount" name="amounts[]" value="<?= $already_paid ?>" style="width:130px;cursor:pointer">
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php foreach($sales2 as $sale) : ?>
            <?php if(!in_array($sale->id, $in_array)) : ?>
            <?php 
                if(!in_array($sale->id, $in_array)){
                    array_push($in_array, $sale->id);
                }
            ?>
            
            <?php $already_paid = 0; $already=0;   ?>
            <?php foreach($sale->payments_sales as $ps) : ?>
                <?php $already = $already + $ps->amount ?>
            <?php endforeach; ?>
            <?php $total = $total + $sale->total ?>
            <?php $due = $due + ($sale->total - $already) ?>
            <?php $paid = $paid + $already_paid ?>
            <tr class="sale">
                <th style="color:#8ad919;" class="check text-center">
                    <?php if(($sale->total - $already) <= 0) : ?>
                        <span class="fa fa-check"></span>
                    <?php endif; ?>
                </th>
                <td class="text-center"><?= date("d/m/Y", strtotime($sale['created'])) ?> <?= date("g:i A", strtotime($sale['created'])) ?></td>
                <td class="text-center"><?= $sale->sale_number ?></td>
                <td class="text-center">
                    <span class="sale_total"><?= number_format($sale->total, 2, ".", ",") ?></span> <?= $customer->rate->name ?>
                </td>
                <td class="text-center">
                    <span class="sale_due"><?= number_format(($sale->total - $already), 2, ".", ",") ?></span> <?= $customer->rate->name ?> <input type="hidden" name="sale_id[]" value="<?= $sale->id ?>">
                    <input type="hidden" class="due" name="due" value="<?= ($sale->total - $already) ?>">
                </td>
                <td class="text-right clickoninput" style="cursor:pointer">
                    <input step="any" type="number" class="amount" name="amounts[]" value="<?= $already_paid ?>" style="width:130px;cursor:pointer">
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot class="todisplay">
            <tr>
                <th></th><th></th><th></th>
                <th class="text-center"><?= number_format($total, 2, ".", ",") ?> <?= $customer->rate->name ?></th>
                <th class="text-center" ><span class="dueall"><?= number_format($due, 2, ".", ",") ?></span> <?= $customer->rate->name ?></th>
                <th class="text-right paid"><span class="paidall"><?= number_format($paid, 2, ".", ",") ?></span> <?= $customer->rate->name ?></th>
            </tr>
        </tfoot>
        </table>
         <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style" => "height: 46px;border-radius: 0px;margin-top:20px;margin-right:15px;float:right")) ?>
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
.dataTables_scrollHeadInner, table{
    width:100%!important;
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
    .check{
        cursor:pointer;
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

        $('.check').click(function(){
            var total = $(this).parent().find('.due').val(); 
            total_amount = $('.total_amount').val()
            var paid = calculate2();
            var total2 = parseFloat(total) + parseFloat(paid);
            if(total2 <= total_amount){
                //continue
                alert('here')
            }else{
                alert('vous devez augmenter le montant total pour selectionner ce paiement');
            }
        })

        $(".amount").focus(function(){
            $(this).select();
            $(this).data('val', $(this).val());
        }).change(function(){
            var previous = $(this).data('val');
            var element = $(this);
            calculate(previous,element);
        })

        function check_icon(element){
            element.find('.check').empty();
            element.find('.check').append(check);
        }

        function calculate2(){
            var c_total = 0;

            $('.sale').each(function(){
                if($(this).find('.amount').val() != ""){
                   c_total = c_total + parseFloat($(this).find('.amount').val());  
                }
            })

            return c_total;
        }


        function verify(){
            var total = calculate2(); 
            var total_amount = $('.total_amount').val();
            if(total_amount <= total){
                return false;
            }else{
                return true;
            }
        }


        function calculate(previous, element){
            var total = $('.total_amount').val();
            var c_total = 0;

            $('.sale').each(function(){
                if($(this).find('.amount').val() != ""){
                   c_total = c_total + parseFloat($(this).find('.amount').val());  
                }
            })
            if(c_total > total){
                alert("Montants supérieurs au montant total. Veuillez augmenter la valeur totale du paiement pour continuer.");
                element.val(previous);
            }else{
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
                $('.paid').text(c_total.toFixed(2));
            }
        }

        // disable()
        $("#DataTables_Table_0 tfoot").find(".paid").removeClass("paid")

        function choose(){
            var total = parseFloat($('.total_amount').val()); //45942.5
            // var already_paid = calculate();
            var payment = total
            $('.sale').each(function(){
                duee = 0;
                var amount = $(this).find('.amount').val();
                if(amount > 0){
                    var duee = $(this).find('.due').val();
                    duee = parseFloat(duee) + parseFloat(amount);

                    $(this).find('.due').val((duee));
                    $(this).find(".sale_due").text(duee.toFixed(2));
                    $(this).find('.amount').val(0);
                    $(this).find('.check').empty();
                }else{

                }
                // alert(duee);
                
            });
            
            $('.sale').each(function(){
                if(payment < 0){
                    $(this).find('.amount').val("");
                    check_icon($(this));
                } // continue
                var due = parseFloat($(this).find('.due').val()); 
                var paid = $(this).find('.amount').val(); 

                if(paid == ""){
                    paid = 0;
                }else{
                    paid = parseFloat(paid);
                }
                var realdue = due - paid;
                if(realdue > 0){
                    if(payment >= realdue){
                        $(this).find('.amount').val(due);
                        payment = payment - realdue;
                        $(this).find('.due').val(0);
                        $(this).find(".sale_due").text("0.00");
                        $(this).find('.check').empty();
                        $(this).find('.check').append(check);

                    }else{
                        $(this).find('.amount').val(payment);
                        $(this).find('.due').val((due - payment));
                        $(this).find(".sale_due").text((due - payment).toFixed(2));
                        payment = 0;
                        // payment < realdue
                    }
                }else{
                    payment = payment - paid;
                    // nothing is due so no action
                }
            })

            var c_total = 0;

            $('.sale').each(function(){
                if($(this).find('.amount').val() != ""){
                   c_total = c_total + parseFloat($(this).find('.amount').val());  
                }
            })

            $('.paid').text(c_total.toFixed(2));
        }
    })
</script>
