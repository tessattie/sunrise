<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiving[]|\Cake\Collection\CollectionInterface $receivings
 */
?>

<?= $this->Html->script("scanner/jquery.scannerdetection.js") ?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="#">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Produits</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Réceptions
            <?php if($user_connected['role_id'] != 8) : ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                <em class="fa fa-plus"></em>
            </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <ul class="dropdown-settings">
                            <li><a href="<?= ROOT_DIREC ?>/receivings/add">
                                <em class="fa fa-plus"></em> Nouvelle Réception
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Fournisseur</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Produit</th>
                    <th class="text-center">Coût</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Zone</th>
                    <th class="text-center">Date de Réception</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php $volume=0;$total=0; foreach($receivings as $receiving) : ?>
                <tr>
                    <td><?= $receiving->receiving_number ?></td>
                    <td class="text-center"><?= $receiving->supplier->name ?></td>
                    <td class="text-center"><?= $receiving->truck->immatriculation ?></td>
                    <td class="text-center"><?= $receiving->item->name ?></td>
                    <td class="text-center"><?= number_format($receiving->cost,2,".",",") ?></td>
                    <td class="text-center"><?= $receiving->quantity ?></td>
                    <td class="text-center"><?= number_format($receiving->cost*$receiving->quantity,2,".",",") ?></td>
                    <?php if($receiving->status == 1) : ?>
                        <td class="text-center">  <span class="label label-info"> NOUVEAU</span></td>
                    <?php elseif($receiving->status == 2) : ?>
                        <td class="text-center">  <span class="label label-warning"> VALIDE</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success"> LIVRE</span></td>
                    <?php endif; ?>
                    <?php if($receiving->type == 1) : ?>
                        <td class="text-center"><span class="label label-info"><?= $types[$receiving->type] ?></span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-default"><?= $types[$receiving->type] ?></span></td>
                    <?php endif; ?>
                    
                    <td class="text-center"><?= $receiving->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/receivings/edit/<?= $receiving->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                    </td>
                </tr>
                <?php 
                    $volume = $volume + $receiving->quantity;
                    $total = $total + $receiving->cost*$receiving->quantity;
                ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">TOTAL</th>
                <th class="text-center"><?= $volume ?></th>
                <th class="text-center"><?= number_format($total,2,".",",") ?></th>
                <th colspan="4"></th>
            </tr>
        </tfoot>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<script type="text/javascript">$(document).ready( function () {
$('.datatable').DataTable({
        iDisplayLength: 25,
        order: [],
    } );
} );

$(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function(barcode, qty){ 
            var token =  $('input[name="_csrfToken"]').val();
            $.ajax({
                type : 'POST',
                url : '/vfm/receivings/find',
                data : {
                    code : barcode
                },
                headers : {
                    'X-CSRF-Token': token 
                },
                success: function(data){
                    console.log(data);
                    window.location.href = "http://localhost/vfm/receivings/edit/"+data;
                },
                error: function(resultat,statut,erreur){
                  console.log(erreur); 
                }
            });   
        }
    }) ;</script>

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
