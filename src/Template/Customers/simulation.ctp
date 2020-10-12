<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Simulation Cashback</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Simulation Cashback<br>
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-20px;margin-top:25px">
                    
                    <div class="col-md-3">
                        <?= $this->Form->control('interval_from', array('class' => 'form-control', 'placeholder' => "De", "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('interval_to', array('class' => 'form-control','placeholder' => "A", "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('pourcentage', array('class' => 'form-control', 'placeholder' => "pourcentage", "label" => false, "style" => "width:100%")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container" style="margin-top:15px">
            <table class="table table-stripped datatable">
                <thead> 
                        <th>Camion</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Total</th>
                        <th class="text-right">Cash Back</th>
                </thead>
            <tbody> 
        <?php $cashback=0; $total=0; $quantity = 0; foreach($sales as $sale) : ?>
            <?php if($pourcentage != 0 && $sale['quantity'] >= $de && $sale['quantity'] <= $a) : ?>
                <tr>
                    <td><?= $sale['immatriculation'] ?></td>
                    <td class="text-center"><?= number_format($sale['quantity'], 2, ".", ",") ?></td>
                    <td class="text-center"><?= number_format($sale['total'], 2, ".", ",") ?></td>
                    <td class="text-right"><?= number_format($sale['total']*$pourcentage/100,2,".",",") ?></td>
                    <?php $cashback = $cashback + $sale['total']*$pourcentage/100; ?>
                    <?php $total = $total + $sale['total'] ?>
                    <?php $quantity = $quantity + $sale['quantity'] ?>
                    
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><th>TOTAL</th><th class="text-center"><?= number_format($quantity, 2,".",",") ?></th><th class="text-center"><?= number_format($total, 2,".",",") ?></th><th class="text-right"><?= number_format($cashback, 2,".",",") ?></th></tr>
        </tfoot>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "order" : [1]
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
</style>
