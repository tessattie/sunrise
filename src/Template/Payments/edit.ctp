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
<input type="hidden" name="customer_id" value="<?= $customer->id ?>">
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edition Paiement : <label>Client : <?= (empty($payment->customer->last_name)) ? $payment->customer->first_name : $payment->customer->last_name ?></label>
            <?php if($payment->status == 0) : ?>
                <a onclick="return confirm('Etes-vous sur de vouloir réactiver ce paiement?')" href="<?= ROOT_DIREC ?>/payments/cancel/<?= $payment->id ?>" style="font-size:1.3em!important;float:right"><button type="button" class="btn btn-success">Réactiver</button></a>
            <?php else : ?>
                <a onclick="return confirm('Etes-vous sur de vouloir annuler ce paiement?')" href="<?= ROOT_DIREC ?>/payments/cancel/<?= $payment->id ?>" style="font-size:1.8em!important;float:right"><button type="button" class="btn btn-danger">Annuler</button></a>
            <?php endif; ?>
        </div>
        <div class="panel-body articles-container">
        
          
        <div class="row" style="padding-top:20px;padding-bottom:30px;border:1px solid #ddd;margin-bottom:20px;margin-top:10px">
            <div class="col-md-4">
                <?= $this->Form->control('amount', array('class' => 'form-control total_amount', "placeholder" => "Montant", "label" => "Montant", "style" => "margin-left:4px")); ?>
            </div>
            <div class="col-md-4">
                <?= $this->Form->control('method_id', array('class' => 'form-control', "empty" => "-- Méthode de paiement --", "options" => $methods, "label" => 'Méthode', "style" => "margin-left:4px;height:46px", "required" => true)); ?>
            </div>
            <div class="col-md-4">
                    <?= $this->Form->control('memo', array('class' => 'form-control', "placeholder" => "Mémo", "label" => 'Mémo', "style" => "margin-left:4px")); ?>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-4">
                    <label>Date</label><br>
                    <input value="<?= date("Y-m-d", strtotime($payment->created))  ?>" type="date" name="created" style="height: 45px;" class="form-control">
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

        choose();

        // when we change customers - if we come to add payment without having a customer
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

        $(".total_amount").change(function(){
            choose();
        });

        $("#rate-id").change(function(){
            choose();
        });

        $("#daily-rate").change(function(){
            choose();
        });

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

        $("#amount").focus(function(){
            $(this).select();
            $(this).data('val', $(this).val());
        }).change(function(){
            var previous = $(this).data('val');
            var element = $(this);
            calculate(previous,element);
        })

        $("#memo").focus(function(){
            $(this).select();
        })

        $("#daily-rate").focus(function(){
            $(this).select();
        })

        // this checks the icon if it isnt checked and needs to be checked
        function check_icon(element){
            element.find('.check').empty();
            element.find('.check').append(check);
        }

        // this calculates whats already been paid
        function calculate2(){
            var c_total = 0;

            $('.sale').each(function(){
                alert($(this).find('.amount').val());
                if($(this).find('.amount').val() != ""){
                   c_total = c_total + parseFloat($(this).find('.amount').val());  
                }
            })

            return c_total;
        }


        function verify(){
            var total = calculate2(); 
            // montant inputed by the user
            var total_amount = $('.total_amount').val();
            if(total_amount <= total){
                return false;
            }else{
                return true;
            }
        }


        function calculate(previous, element){
            // total amount that the customer paid and was inputed in the amount input above the table
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
