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
<input type="hidden" name="customer_id" value="<?= $customer->id ?>">
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouveau Paiement : <label><?= (empty($customer->last_name)) ? $customer->first_name : $customer->last_name ?></label>
            <input type="hidden" name="customer_rate_id" id="customer_rate_id" value="<?= $customer->rate_id ?>">
        </div>
        <div class="panel-body articles-container">
        
        <div class="row" style="padding-top:20px;padding-bottom:30px;border:1px solid #ddd;margin-bottom:20px;margin-top:10px">
            <div class="col-md-4">
                <?= $this->Form->control('amount', array('class' => 'form-control total_amount', "placeholder" => "Montant", "label" => "Montant", "style" => "margin-left:4px")); ?>
            </div>
            <div class="col-md-4">
                <?= $this->Form->control('rate_id', array('class' => 'form-control', "empty" => "-- Devise --", "options" => $rates, "label" => 'Devise', "style" => "margin-left:4px;height:46px", "required" => true, 'value' => 1)); ?>
            </div>
            <div class="col-md-4">
                <?= $this->Form->control('method_id', array('class' => 'form-control', "empty" => "-- Méthode de paiement --", "options" => $methods, "label" => 'Méthode', "style" => "margin-left:4px;height:46px", "required" => true)); ?>
            </div>
            </div>   
            <div class="row">
               <div class="col-md-4">
                    <?= $this->Form->control('memo', array('class' => 'form-control', "placeholder" => "Mémo", "label" => 'Mémo', "style" => "margin-left:4px")); ?>
                </div>
                <div class="col-md-4">
                    <?= $this->Form->control('daily_rate', array('class' => 'form-control', "label" => 'Taux du Jour', "style" => "margin-left:4px;height:46px", "required" => true, 'placeholder' => "Taux du Jour", 'value' => $daily_rate)); ?>
                </div>
                <div class="col-md-4">
                    <label>Date</label><br>
                    <input value="<?= date("Y-m-d")  ?>" type="date" name="created" style="height: 45px;">
                </div> 
            </div>
            

        
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


        $("#rate-id").change(function(){
            choose();
        })


        $("#daily-rate").change(function(){
            choose();
        })
       

        $("#amount").focus(function(){
            $(this).select();
            $(this).data('val', $(this).val());
        })


        $("#memo").focus(function(){
            $(this).select();
        })


        $("#daily-rate").focus(function(){
            $(this).select();
        })


        $("#DataTables_Table_0 tfoot").find(".paid").removeClass("paid")

        function check_icon(element){
            element.find('.check').empty();
            element.find('.check').append(check);
        }

        // function calculate(){
        //     var total = $('.total_amount').val();
        //     var c_total = 0;
        //     $('.sale').each(function(){
        //         if($(this).find('.amount').val() != ""){
        //            c_total = c_total + parseFloat($(this).find('.amount').val());  
        //         }
        //         if(parseFloat($(this).find('.amount').val()) >= parseFloat($(this).find('.due').val())){
        //             check_icon($(this));
        //         }else{
        //             $(this).find('.check').empty();
        //         }
        //     })
        //     $('.total_amount').val(c_total.toFixed(2));
        //     $('.paid').text(c_total.toFixed(2));

        // }

        function choose(){
            var total = parseFloat($('.total_amount').val()); //45942.5
            var daily_rate = parseFloat($("#daily-rate").val());
            var payment_rate_id = $("#rate-id").val();

            var customer_rate_id = $("#customer_rate_id").val();
            
            if(payment_rate_id != customer_rate_id){
                if(payment_rate_id == 1){
                    total = total/daily_rate;
                }else{
                    total = total*daily_rate;
                }
            }
            // var already_paid = calculate();
            var payment = total;
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
