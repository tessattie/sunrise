<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiving $receiving
 */
?>
<?= $this->Html->script("scanner/jquery.scannerdetection.js") ?>

<?php 
// set values to use in calculation for widths
echo "<script>";
echo "var items = " . json_encode($prices->toArray()); 
echo "</script>";
?>

<div id="nottoprint">
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="#">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/receivings">
            Receptions
        </a></li>
        <li class="active">Ajouter</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Nouvelle Réception
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/receivings">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>

    <div class="panel-body articles-container">       
            <?= $this->Form->create($receiving) ?>
                <div class="row">
                    <?= $this->Form->control('immatriculation', array('type' => "hidden", 'class' => 'form-control truckVerification', "type" => "hidden", "placeholder" => "Camion")); ?><?= $this->Form->control('truck_id', array('class' => 'form-control truckValidation', "type" => "hidden")); ?>
                    <div class="col-md-4"><?= $this->Form->control('supplier_id', array('type' => "hidden", 'class' => 'form-control', "label" => "Fournisseur *", "empty" => "-- Choisissez --", "options" => $suppliers)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('item', array('type' => "hidden", 'class' => 'form-control', "label" => "Produit *", "empty" => "-- Choisissez --", "options" => $items)); ?></div>
                    <div class="col-md-2"><?= $this->Form->control('quantity', array('type' => "hidden", 'class' => 'form-control', "label" => "Volume *", "placeholder" => "Volume")); ?></div>
                    <div class="col-md-2"><?= $this->Form->control('cost', array('type' => "hidden", 'class' => 'form-control', "label" => "Coût *", "placeholder" => "Coût")); ?></div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Camion</th>
                                    <th class="text-center">Fournisseur</th>
                                    <th class="text-center" style="width:210px">Produit</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-center">Coût</th>

                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center truck" style="vertical-align:middle"></th>
                                    <th class="text-center supplier" style="vertical-align:middle"></th>
                                    <th class="text-center product" style="vertical-align:middle"><?= $this->Form->control('item_id', array('class' => 'form-control', "label" => false, "empty" => "-- Choisissez --", "options" => $items, "style" => "width:200px")); ?></th>
                                    <th class="text-center volume" style="vertical-align:middle"></th>
                                    <th class="text-center" style="vertical-align:middle" style="vertical-align:middle"><span class="cost">0.00</span> HTG</th>
                                    <th class="text-center bg-info" style="vertical-align:middle"><span class="totalCost">0.00</span> HTG</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
</div>

<style type="text/css">
    select{
        height:45px!important;
    }
</style>

<script type="text/javascript">
$(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function(barcode, qty){ 
            var bc = barcode;
            alert(bc);
            // var bc = barcode.replace("123456", "");
            $('.truckVerification').val(bc);

            var token =  $('input[name="_csrfToken"]').val();
            $.ajax({
                type : 'POST',
                url : '/vfm/trucks/find',
                data : {
                    truck : bc
                },
                headers : {
                    'X-CSRF-Token': token 
                },
                success: function(data){
                    data = JSON.parse(data);
                    console.log(data);
                    if(data == "false"){
                        alert("Camion introuvable, vérifiez l'immatriculation");
                    }else{
                        // Selectionner le fournisseur en question
                        if(data.suppliers[0]){
                           $("#supplier-id").val(data.suppliers[0].id); 
                           $(".supplier").text(data.suppliers[0].name); 
                        }
                        
                        $('#quantity').val(data.volume);
                        $('.volume').text(data.volume);
                        $('#item-id').val(data.suppliers_trucks[0]['item_id']);
                        $('#item').val(data.suppliers_trucks[0]['item_id']);
                        $('#item-id').attr('readonly', true);
                        $('#item').attr('readonly', true);
                        $('.cost').text(data.suppliers_trucks[0]['item'].price);
                        $(".truck").text(data.immatriculation);
                        $(".truckValidation").val(data.id);
                        var supplier = $("#supplier-id").children("option:selected").html();
                        $("#ticketclientname").text(supplier);
                        $("#cost").val(data.suppliers[0]['item'].price);
                        $(".truckIMM").text(data.immatriculation);
                        $(".tvolume").text(data.volume);
                        var cost = parseFloat($("#cost").val());
                        var total = parseFloat(data.volume)*cost;
                        $('.totalCost').text(total);
                        $(".productprice").text($("#cost").val());
                    }
                },
                error: function() {
                  console.log('La requête n\'a pas abouti'); 
                }
            });   
        }
    });

    $(document).ready(function(){
        console.log(items[1]);
        $("#item-id").change(function(){
            var item = $(this).val();
            var volume = $('#quantity').val();
            $('#item').val(item);
            $("#cost").val(items[item]);
            $(".cost").text(items[item]);
            var total = parseFloat(volume)*parseFloat(items[item]);
            $('.totalCost').text(total);
        })
    });
</script>


<style type="text/css" media="print">
#nottoprint{
        display: none;
    }
#sectiontoprint{
        background-color:#FFF;
    }
</style>

<!-- CSS for the things we DO NOT want to print (web view) -->
<style type="text/css" media="screen">

   #sectiontoprint{
      display:none;
   }
</style>