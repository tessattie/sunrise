<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
$ouinon = array(0=> "Non", 1 => "Oui");
?>

<style type="text/css">
    select.form-control{
        height:46px;
    }
</style>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/sales">
            Ventes
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid">
<?= $this->Form->create($sale) ?>
    <div class="row" style="padding-bottom:80px">
        <div class="col-md-8"><div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-8">
                                <h4 style="color:white">Produits</h4>
                            </div>
                            <div class="col-xs-4">
                                <?= $this->Form->control('truck_id', array('class' => 'form-control truckVerification', "type" => "text", "label" => false, "placeholder" => "Immatriculation Camion", "style" => "margin-top:-3px", "required" => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="height:480px;overflow-y:scroll">
                <?php foreach($products as $product) : ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="product-name"><input type="radio" class="productIDChange" name="product_id" value="<?= $product->id ?>" style="margin-top:2px" required> <strong><?= $product->name ?></strong></h5>
                        </div>
                        <div class="col-xs-6">
                            <div class="col-xs-6 text-right">
                                <h6><strong><span class="label label-success"><?= number_format($product->cash_price, 2, ".", ",") ?> HTG</span></strong></h6>
                            </div>
                            <div class="col-xs-6 text-right">
                                <h6><strong><span class="label label-primary"><?= number_format($product->credit_price, 2, ".", ",") ?> USD</span></strong></h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
                 
                </div>
            </div>
            
            </div>
        <div class="col-md-4">
            <div class="panel panel-default articles">
        <div class="panel-heading">
            Détails
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/sales">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">     
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->control('customer_id', array('class' => 'form-control customerChange select2', "value" => 1, 'label' => "Client")); ?></div>
                    <div class="col-md-12 customerDataInsert"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('discount', array('class' => 'form-control discount', "value" => 0, 'label' => "Réduction")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('discount_type', array('class' => 'form-control discount_type', "value" => 1, "options" => [1=> "%", 0 => "HTG / USD"], "label" => "", "style" => "margin-top:4px")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('charged', array('class' => 'form-control', "value" => 0, 'label' => "Chargé", "options" => $ouinon)); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('sortie', array('class' => 'form-control', "value" => 0, "options" => $ouinon , "label" => "Sortie")); ?></div>
                </div>

            <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>
        </div>
        
    </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
<div class="all" style = "height:85px;width:85%;background:#f9243f;position:fixed;bottom:0px;margin-left:-15px">
    <div class="row">

        <div class="col-md-3" style="border-right:2px solid white;height:77px;margin-top:4px;padding:10px 30px">
            <label style="color:white">Camion</label><br>
            <small style="color:white" id="appendCamionInfo"></small>
        </div>

        <div class="col-md-3" style="border-right:2px solid white;height:77px;margin-top:4px;padding:10px 20px">
            <label style="color:white">Produit</label><br>
            <small style="color:white" id="appendProduit"></small>
        </div>

        <div class="col-md-3" style="border-right:2px solid white;height:77px;margin-top:4px;padding:10px 20px">
            <label style="color:white">Réduction</label><br>
            <small style="color:white"><span id="redVal">0</span><span id="redType">%</span></small>
        </div>

        <div class="col-md-3" style="border-right:2px solid white;height:77px;margin-top:4px;padding:10px 20px">
            <label style="color:white">Total</label><br>
            <small style="color:white" id="totalChange"></small>
        </div>
        

    </div>
</div>


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable();

    $(".discount").change(function(){
        $("#redVal").html($(this).val());
        var truck = $('.truckVerification').val();
        var product = $(".productIDChange:checked").val();
        if(truck && product){
            var volume = parseFloat($("#truckVolume").text());
            var cash_price = volume * parseFloat($("#cash_price").text());
            var credit_price = volume * parseFloat($("#credit_price").text());
            var discount = $(this).val();
            var discount_type = $(".discount_type").val();
            if(discount_type == 0){
                cash_price = cash_price - discount;
                credit_price = credit_price - discount;
            }else{
                cash_price = cash_price - cash_price * discount/100;
                credit_price = credit_price - credit_price * discount/100;
            }

            $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
        }
    })

    $(".discount_type").change(function(){
        var types = [" HTG / USD", " %"];
        $("#redType").html(types[$(this).val()]) ;
        var truck = $('.truckVerification').val();
        var product = $(".productIDChange:checked").val();
        if(truck && product){
            var volume = parseFloat($("#truckVolume").text());
            var cash_price = volume * parseFloat($("#cash_price").text());
            var credit_price = volume * parseFloat($("#credit_price").text());
            var discount = $(".discount").val();
            var discount_type = $(this).val();
            if(discount_type == 0){
                cash_price = cash_price - discount;
                credit_price = credit_price - discount;
            }else{
                cash_price = cash_price - cash_price * discount/100;
                credit_price = credit_price - credit_price * discount/100;
            }

            $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
        }
    })

    $(".productIDChange").change(function(){
        var truck = $('.truckVerification').val();
        $("#appendProduit").empty();
        var token =  $('input[name="_csrfToken"]').val();
        $.ajax({
            type : 'POST',
            url : '/vfm/products/find',
            data : {
                id : $(this).val()
            },
            headers : {
                'X-CSRF-Token': token 
            },
            success: function(data) {
                data = JSON.parse(data);
                
                if(data == "false"){

                    alert("Produit introuvable, revérifiez");
                    $("#appendProduit").empty();

                }else{
                    $("#appendProduit").append(data[0].name+" - <span id='cash_price'>"+data[0].cash_price.toFixed(2)+"</span> HTG ou <span id='credit_price'>"+data[0].credit_price.toFixed(2)+"</span> USD");
                    if(truck){
                        var volume = parseFloat($("#truckVolume").text());
                        var cash_price = volume * parseFloat(data[0].cash_price);
                        var credit_price = volume * parseFloat(data[0].credit_price);
                        var discount = $(".discount").val();
                        var discount_type = $(".discount_type").val();
                        if(discount_type == 0){
                            cash_price = cash_price - discount;
                            credit_price = credit_price - discount;
                        }else{
                            cash_price = cash_price - cash_price * discount/100;
                            credit_price = credit_price - credit_price * discount/100;
                        }
                        $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
                        // Change Total Value
                    }
                }
            },
            error: function() {
              console.log('La requête n\'a pas abouti'); 
            }
        });   
    })

    // $(".currencyP").change(function(){
    //     var amount = $(".amountP").val();
    //     var total = $("#totalChange").text().split(" HTG")[0];
    //     if($(this).val() == 1){
    //         if(parseFloat(amount) >= parseFloat(total)){
                
    //         }else{
    //             $(".amountP").val("");
    //             $(".currencyP").val("");
    //             alert("Le montant du paiement doit être supérieur ou égal au montant total de la facture");
    //         }
    //     }else{
    //         var token =  $('input[name="_csrfToken"]').val();
    //         $.ajax({
    //             type : 'POST',
    //             url : '/app/rates/find',
    //             data : {
    //                 id : 2
    //             },
    //             headers : {
    //                 'X-CSRF-Token': token 
    //             },
    //             success: function(data) {
    //                 data = JSON.parse(data);
                    
    //                 if(data == "false"){
    //                     alert("Cette devise n'existe pas")
    //                 }else{
    //                     var total2 = parseFloat(amount)*parseFloat(data[0].amount);
    //                     if(total2 >= parseFloat(total)){

    //                     }else{
    //                         $(".amountP").val("");
    //                         $(".currencyP").val("");
    //                         alert("Le montant du paiement doit être supérieur ou égal au montant total de la facture");
    //                     }
    //                 }
    //             },
    //             error: function() {
    //               console.log('La requête n\'a pas abouti'); 
    //             }
    //           });  
    //     }
    // })


    $(".customerChange").change(function(){

        $(".customerDataInsert").empty();
        // alert($(".productIDChange").val());

        if($(this).val() != 1){
            var token =  $('input[name="_csrfToken"]').val();
            $.ajax({
                type : 'POST',
                url : '/vfm/customers/find',
                data : {
                    id : $(this).val(), 
                },
                headers : {
                    'X-CSRF-Token': token 
                },
                success: function(data) {
                    data = JSON.parse(data);
                    
                    if(data == "false"){

                        alert("Client introuvable, revérifiez");
                        $(".customerDataInsert").empty();

                    }else{
                        console.log(data);
                        $(".discount").val(data[0].discount);
                        $(".discount_type").val(data[0].discount_type);

                        $("#redVal").html(data[0].discount);
                        var types = [" HTG / USD", " %"];
                        $("#redType").html(types[data[0].discount_type]) ;
                        var truck = $('.truckVerification').val();
                        var product = $(".productIDChange:checked").val();
                        if(truck && product){
                            var volume = parseFloat($("#truckVolume").text());
                            var cash_price = volume * parseFloat($("#cash_price").text());
                            var credit_price = volume * parseFloat($("#credit_price").text());
                            var discount = data[0].discount;
                            var discount_type = data[0].discount_type;
                            if(discount_type == 0){
                                cash_price = cash_price - discount;
                                credit_price = credit_price - discount;
                            }else{
                                cash_price = cash_price - cash_price * discount/100;
                                credit_price = credit_price - credit_price * discount/100;
                            }

                            $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
                        }

                        $(".customerDataInsert").append("<hr><div><label>Numéro Client : </label> "+data[0].customer_number+"<br><label>Crédit Disponible : </label> "+data[0].credit_available.toFixed(2)+" USD<hr><input type='checkbox' name='is_credit_sale'> Fiche Crédit</div>");

                        $(".customerDataInsert").append("<hr><label>Réquisition</label><br><select class='form-control requisitions' name='requisition_id'><option value=''>-- Choisissez --</option></select>");
                        for (var i = data[0].requisitions.length - 1; i >= 0; i--) {
                            for (var j = 0; j < data[0].requisitions[i].requisitions_products.length; j++) {
                                if(data[0].requisitions[i].requisitions_products[j].product_id == $(".productIDChange:checked").val()){
                                    var available = data[0].requisitions[i].requisitions_products[j].quantity - data[0].requisitions[i].requisitions_products[j].used;
                                    if(available > 0){
                                        $('.requisitions').append("<option value='"+data[0].requisitions[i].id+"'>"+data[0].requisitions[i].uid+"</option>");
                                    }
                                }
                            }
                            data[0].requisitions[i]
                        }
                    }
                },
                error: function() {
                  console.log('La requête n\'a pas abouti'); 
                }
              });   
        }else{
            $(".customerDataInsert").empty();
            $(".discount").val(0);
            $(".discount_type").val(1);

            $("#redVal").html(0);
            var types = [" HTG / USD", " %"];
            $("#redType").html(types[1]) ;
            var truck = $('.truckVerification').val();
            var product = $(".productIDChange:checked").val();
            if(truck && product){
                var volume = parseFloat($("#truckVolume").text());
                var cash_price = volume * parseFloat($("#cash_price").text());
                var credit_price = volume * parseFloat($("#credit_price").text());
                var discount = 0;
                var discount_type = 1;
                if(discount_type == 0){
                    cash_price = cash_price - discount;
                    credit_price = credit_price - discount;
                }else{
                    cash_price = cash_price - cash_price * discount/100;
                    credit_price = credit_price - credit_price * discount/100;
                }

                $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
            }
        }
    })

    $('.truckVerification').change(function(){
        var product = $(".productIDChange:checked").val();
        
        $("#appendCamionInfo").empty();
        var token =  $('input[name="_csrfToken"]').val();
        $.ajax({
            type : 'POST',
            url : '/vfm/trucks/find',
            data : {
                truck : $(this).val()
            },
            headers : {
                'X-CSRF-Token': token 
            },
            success: function(data){
                data = JSON.parse(data);
                if(data == "false"){
                    $("#totalChange").html("");
                    $("#appendCamionInfo").empty();
                    alert("Camion introuvable, vérifiez l'immatriculation");
                }else{
                    $("#appendCamionInfo").append("Imm : "+data[0].immatriculation+" - Vol : <span id='truckVolume'>"+data[0].volume+"</span> M3");
                    if(product){

                        $.ajax({
                            type : 'POST',
                            url : '/vfm/products/find',
                            data : {
                                id : product
                            },
                            headers : {
                                'X-CSRF-Token': token 
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                
                                if(data == "false"){

                                    $("#appendProduit").empty();

                                }else{
                                        var volume = parseFloat($("#truckVolume").text());
                                        var cash_price = volume * parseFloat(data[0].cash_price);
                                        var credit_price = volume * parseFloat(data[0].credit_price);
                                        var discount = $(".discount").val();
                                        var discount_type = $(".discount_type").val();
                                        if(discount_type == 0){
                                            cash_price = cash_price - discount;
                                            credit_price = credit_price - discount;
                                        }else{
                                            cash_price = cash_price - cash_price * discount/100;
                                            credit_price = credit_price - credit_price * discount/100;
                                        }
                                        $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
                                        // Change Total Value
                                }
                            },
                            error: function() {
                              console.log('La requête n\'a pas abouti'); 
                            }
                        });  

                        var volume = parseFloat($("#truckVolume").text());
                        var cash_price = volume * parseFloat(data[0].cash_price);
                        var credit_price = volume * parseFloat(data[0].credit_price);
                        var discount = $(".discount").val();
                        var discount_type = $(".discount_type").val();
                        if(discount_type == 0){
                            cash_price = cash_price - discount;
                            credit_price = credit_price - discount;
                        }else{
                            cash_price = cash_price - cash_price * discount/100;
                            credit_price = credit_price - credit_price * discount/100;
                        }
                        $("#totalChange").html(cash_price+" HTG ou "+credit_price+" USD");
                    }else{
                        $("#totalChange").html("");
                    }
                }
            },
            error: function() {
              console.log('La requête n\'a pas abouti'); 
            }
          });   
    })
} );</script>
