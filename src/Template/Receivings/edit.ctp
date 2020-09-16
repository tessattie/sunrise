<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiving $receiving
 */
?>
<?= $this->Html->script("JsBarcode.all.min.js") ?>

<?= $this->Html->script("scanner/jquery.scannerdetection.js") ?>

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
            Edition Réception : <?= $receiving->receiving_number ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/receivings">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>

    <div class="panel-body articles-container">       
            <?= $this->Form->create($receiving) ?>
            <?= $this->Form->control('receiving_number', array('id' => 'receiving_number', "type" => "hidden", "value" => $receiving->receiving_number)); ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('immatriculation', array('type' => "hidden", 'class' => 'form-control truckVerification', "label" => "Camion *", "placeholder" => "Camion", "value" => $receiving->truck->immatriculation)); ?><?= $this->Form->control('truck_id', array('class' => 'form-control truckValidation', "type" => "hidden", "value" => $receiving->truck->id)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('supplier_id', array('type' => "hidden", 'class' => 'form-control', "label" => "Fournisseur *", "empty" => "-- Choisissez --", "options" => $suppliers)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('item', array('type' => "hidden", 'class' => 'form-control', "label" => "Produit *", "empty" => "-- Choisissez --", "options" => $items)); ?></div>
                </div> 
                <div class="row">
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
                                    <th class="text-center" style="width:210px">Livraison</th>
                                    <th class="text-center" style="width:210px">Produit</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-center">Coût</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center truck" style="vertical-align:middle"><?= $receiving->truck->immatriculation ?></th>
                                    <th class="text-center supplier" style="vertical-align:middle"><?= $receiving->supplier->name ?></th>
                                    <th class="text-center delivery"><?= $this->Form->control('type', array( "label" => false, "options" => $types, "empty" => "-- Choisissez --", "value" => "", "required" => true, "style" => "width:200px", 'class' => "form-control", 'value' => $receiving->type)); ?></th>
                                    <th class="text-center product" style="vertical-align:middle"><?= $receiving->item->name ?></th>
                                    <th class="text-center volume" style="vertical-align:middle"><?= $receiving->quantity ?></th>
                                    <th class="text-center" style="vertical-align:middle" style="vertical-align:middle"><span class="cost"><?= number_format($receiving->cost,2,".",",") ?></span> HTG</th>
                                    <th class="text-center bg-info" style="vertical-align:middle"><span class="totalCost"><?= number_format($receiving->cost*$receiving->quantity,2,".",",") ?></span> HTG</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success printReceipt', "style"=>"margin-top:25px;float:right", "onclick" => "window.print()")) ?></div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
</div>
<div id = "sectiontoprint" style="text-align:center;width:350px;">
  <img src="<?= ROOT_DIREC ?>/img/Logo_VFM_Horizontal-01.png" style="width:80%">
  <h2 class="trans_type_ticket" style="text-align:center;margin-top:35px;margin-bottom:35px;margin-right:40px;font-family: 'Courier New'">RECU</h2>
  
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Ticket </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span><?= $receiving->receiving_number ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Compagnie </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span id="ticketclientname"><?= strtoupper($receiving->supplier->name) ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Camion</label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="truckIMM"><?= $receiving->truck->immatriculation ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Volume </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="tvolume"><?= $receiving->truck->volume ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Produit </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="productname"><?= $receiving->item->name ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Coût (HTG)</label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="productprice"><?= number_format($receiving->item->price, 2, ".", ",") ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Destination </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="tdelivery"><?= $types[$receiving->type] ?></span></div>
  </div>
  <div style="width:100%" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Agent</label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span><?= strtoupper($receiving->user->last_name) . " " . ucfirst(strtolower($receiving->user->first_name)) ?></span></div>
  </div>
  <div style="width:100%;" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>Date </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span><?= date("j M Y H:i", strtotime($receiving->created)) ?></span></div>
  </div>
  <div style="width:100%;border-top:2px dashed black;padding-top:10px;padding-bottom:15px" class="row">
    <div style="float:left;font-size: 19px;font-family: 'Courier New'"><label>TOTAL (HTG) </label></div>
    <div style="float:right;font-size: 19px;margin-right:20px;font-family: 'Courier New'"><span class="total"><?= number_format(($receiving->truck->volume*$receiving->item->price), 2, ".", ",") ?></span></div>
  </div>
  <div class="row" style="margin-top:40px;margin-bottom:40px;margin-right:0px!important;margin-left:-45px!important">
      <div class="col-md-12 text-center" style="font-family: 'Courier New'"><label style="font-family: 'Courier New'"> +(509)-2813-0700 </label><br><label style="font-family: 'Courier New'"> info@vfmateriaux.com </label><br><label style="font-family: 'Courier New'">Route de Tabarre, Tabarre, Haïti</label></div>
      <div class="col-md-12 text-center"><h3>MERCI !</h3></div>
    </div>
    <div class="row" style="margin-right:0px!important;margin-left:-45px!important">
      <div class="col-md-12">
        <svg id="recnumber"
          jsbarcode-value="<?= $receiving->receiving_number ?>"
          jsbarcode-textmargin="0"
          jsbarcode-fontoptions="bold">
        </svg>
      </div>
    </div>
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
            var bc = barcode.replace("123456", "");
            $('.truckVerification').val(bc);

            var token =  $('input[name="_csrfToken"]').val();
            $.ajax({
                type : 'POST',
                url : '/trucks/find',
                data : {
                    truck : bc
                },
                headers : {
                    'X-CSRF-Token': token 
                },
                success: function(data){
                    data = JSON.parse(data);
                    if(data == "false"){
                        alert("Camion introuvable, vérifiez l'immatriculation");
                    }else{
                        // Selectionner le fournisseur en question
                        if(data.suppliers[0]){
                           $("#supplier-id").val(data.suppliers[0].id); 
                        }
                        
                        console.log(data.suppliers[0].type);
                        // Remplir le volume automatiquement
                        $('#quantity').val(data.volume);
                        $('#item').val(data.suppliers[0]['type']);
                        $(".truckValidation").val(data.id);
                        var supplier = $("#supplier-id").children("option:selected").html();
                        $("#ticketclientname").text(supplier);
                        $(".truckIMM").text(data.immatriculation);
                        $(".tvolume").text(data.volume);
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


        JsBarcode("#recnumber", $("#receiving_number").val(), {
          width: 2,
          height: 60,
          displayValue: false
        });

        var prices = ["", 1500, 2500];

        $("#type").change(function(){
            var type = $(this).children("option:selected").html();
            $(".tdelivery").text(type);
        })

        $("#supplier-id").change(function(){
            var supplier = $(this).children("option:selected").html();
            $("#ticketclientname").text(supplier);
        })

        $("#quantity").change(function(){
            $(".tvolume").text($(this).val());
            var total = parseFloat($(this).val()) * parseFloat($("#cost").val());
            $(".total").text($(this).val());
        })

        $("#cost").change(function(){
            $(".productprice").text($(this).val());
            var total = parseFloat($(this).val())* parseFloat($("#quantity").val());
            $(".total").text(total.toFixed(2));
        })

        $("#item").change(function(){
            $('#cost').val(prices[$(this).val()]);
            var total = parseFloat($("#cost").val())* parseFloat($("#quantity").val());
            $(".total").text(total.toFixed(2));
            $(".productprice").text($("#cost").val());
            $(".productname").text($(this).children("option:selected").html());
        })

        $('.truckVerification').change(function(){        
        var token =  $('input[name="_csrfToken"]').val();
        $.ajax({
            type : 'POST',
            url : '/trucks/find',
            data : {
                truck : $(this).val()
            },
            headers : {
                'X-CSRF-Token': token 
            },
            success: function(data){
                data = JSON.parse(data);
                if(data == "false"){
                    alert("Camion introuvable, vérifiez l'immatriculation");
                }else{
                    // Selectionner le fournisseur en question
                    if(data[0].suppliers[0]){
                       $("#supplier-id").val(data[0].suppliers[0].id); 
                    }
                    
                    console.log(data);
                    // Remplir le volume automatiquement
                    $('#quantity').val(data[0].volume);
                    $(".truckValidation").val(data[0].id);
                    $(".truckIMM").text(data[0].immatriculation);
                    $(".tvolume").text(data[0].volume);
                    $(".productprice").text($("#cost").val());
                }
            },
            error: function() {
              console.log('La requête n\'a pas abouti'); 
            }
            });   
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