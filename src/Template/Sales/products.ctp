<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Rapports</li>
        <li class="active">Produits</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/products/<?= $customer ?>" target="_blank" style="float:right;
        margin-top: -34px;
        margin-right: 40px;
        padding: 3px 10px;
        background: black;
        color: white;text-decoration:none!important;cursor:pointer">Excel</a>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Ventes par Produits
        </div>

    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-m-12">
            <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2', "label" => "Client ", "options" => $customers, 'style' => "margin-left:17px", "empty" => "-- Tous --")); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left;margin-top:25px")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <hr>
        </div>
    </div>
        <table class="table table-stripped datatable">
                <thead>
                        <th>Produit</th>
                        <th class="text-center">Fiches</th>
                        <th class="text-center">Volume</th>
                        <th class="text-center">Pourcentage</th>
                        <th class="text-right">Cummulé</th>
                </thead>
            <tbody> 
                <?php 
                $total_volume=0; $total_trips=0;
                foreach ($product_list as $product){
                    $total_volume = $total_volume + $product['total_sold'];
                    $total_trips = $total_trips + $product['total_trips'];
                }
                ?>
                <?php $cummule = 0; foreach ($product_list as $product): ?>
                <?php if($total_volume != 0) : ?>
                    <?php $pourcentage = $product['total_sold']*100/$total_volume; $cummule = $cummule + $pourcentage ?>
                <?php else : ?>
                    <?php $cummule = 0; $pourcentage=0; ?>
                <?php endif; ?>
                    <tr>
                        <td><a href="<?= ROOT_DIREC ?>/products/view/<?= $product['id'] ?>" target="_blank"><?= $product['name'] ?></a></td>
                        <th class="text-center"><?= $product['total_trips'] ?></th>
                        <th class="text-center"><?= number_format($product['total_sold'],2,".", " ") ?> M3</th>
                        <th class="text-center"><?= number_format($pourcentage, 3, ".", ",") ?>%</th>
                        <th class="text-right"><?= number_format($cummule, 3, ".", ",") ?>%</th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th class="text-center"><?= $total_trips  ?></th>
                <th class="text-center"><?= number_format($total_volume, 2, ".", ",") ?> M3</th>
                <th class="text-center">100.00%</th>
                    <th class="text-right">100.000%</th>
            </tr>
        </tfoot>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
            'pdf', 'print'
        ],
        scrollY: true,
        scrollCollapse: true,
        paging: false,
    });
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
    .select2{
        margin-left:21px;
    }
</style>