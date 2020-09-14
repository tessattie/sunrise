<?php 
    if($total_to_show < 0){
        $total_to_show = 0;
    }
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Produits</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Balancement des Fiches Cash
                <?= $this->Form->create() ?>
                    <div class="row" style="float: right;margin-top: -41px;width:250px;margin-right:79px">
                        
                        <div class="col-md-3" style="margin-left:20px;width:250px">
                            <?= $this->Form->control('value', array('class' => 'form-control', "placeholder" => "Total à balancer", "label" => false, "value" => $total_to_show)); ?>
                        </div>

                        <div class="col-md-1" style="margin-left:-38px">
                            <?= $this->Form->button(__('Continuer'), array('class'=>'btn btn-success', "style"=>"float:left", "style" => "height: 46px;border-radius: 0px;")) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container" style="margin-top:50px">
            <table class="table table-stripped datatable">
                <thead> 
					<th>Catégorie</th>
                    <th>Produit</th>
                    <th class="text-center">Pourentage</th>
                    <th class="text-center">Balancé</th>
                    <th class="text-right">Restant</th>
                </thead>
            <tbody> 
        <?php $total = 0; $balanced = 0; foreach($products as $product) : ?>
                <?php 

                $tohide = $total_to_show*$product->percentage/100 - $product->balanced;
                if($tohide <= 0){
                    $tohide = 0;
                    $disabled = true;
                    }else{
                        $disabled = false;
                    }
                 ?>
                
                <tr>
                
					<td><?= $product->category->name ?></td>
                    <td class="text-left"><?= $product->abbreviation ?></td>
                    <td class="text-center"><?= number_format($product->percentage, 3, ".", ",") ?>%</td>
                    <td class="text-center"><?= number_format($product->balanced, 2, ".", ",") ?> HTG</td>
                    <td class="text-right"><?= $this->Form->create() ?><?= $this->Form->control('value', array("type" => "hidden", "value" => $total_to_show)); ?><?= $this->Form->button(__('OK'), array('class'=>'btn btn-success', "disabled" => $disabled, "style"=>"float:left", "style" => "height: 46px;border-radius: 0px;float:right")) ?><?= $this->Form->control("product_hide", array('class' => 'form-control', "placeholder" => "Total à balancer", "label" => false, "style" => "width:68px;float:right", "disabled" => $disabled, "value" => ceil($tohide))); ?> <?= $this->Form->input("product_id", array("type" => "hidden", "value" => $product->id)) ?> <?= $this->Form->end() ?></td>
                
                </tr>
                
                <?php $balanced = $balanced + $product->balanced; $total = $total + $product->percentage*$total_to_show/100; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <th colspan="3">
                TOTAL
            </th>
            <th class="text-center"><?= number_format($balanced, 2, ".", ",") ?> HTG</th>
            <th></th>
        </tfoot>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<script type="text/javascript">$(document).ready( function () {
$('.datatable').DataTable({
        order: [[2, "desc"]],
        iDisplayLength: 25,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
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
    td,th{
        vertical-align:middle;
    }
</style>


