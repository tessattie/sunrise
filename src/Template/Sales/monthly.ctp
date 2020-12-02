<?php 
$months = array("01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril", "05" => "Mai", "06" => "Juin", "07" => "Juillet","08" => "Août", "09" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Décembre");

$years = array("2019" => "2019", "2020" => "2020", '2021' => '2021', '2022' => '2022', '2023' => '2023', '2023' => '2023', '2024' => '2024');
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Ventes Mensuelles</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/monthly" target="_blank" style="float:right;
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
            Ventes Mensuelles
        </div>
        <div class="panel-body articles-container">
            <!--End .article-->
            <table class="table datatable">
                <thead>
                    <th style="width:110px"></th>
                    <?php $i = 1; ?>
                    <?php foreach($products as $product) : ?>
                        <?php $i = $i+1; ?>
                    <?php endforeach; ?>
                    <th class="text-right">TOTAL (LBS)</th>
                </thead>
            
            <tbody>
                <?php $current = $from; ?>
                <?php while($current <= $to) : ?>
                    <?php $product_total = 0; $day = date("d", strtotime($current)); ?>
                    <tr <?php if($day ==1 || $day == 5 || $day == 10 || $day == 15 || $day == 20 || $day == 25 || $day == 30) : ?> style="background:#E5E4E4" <?php endif; ?>>
                       <th><?= date("D j M y",strtotime($current)); ?></th> 
                       <?php foreach($products as $product) : ?>

                            <?php 
                            $volume = 0;
                                foreach($sales as $sale){
                                    if($sale['date'] == $current && $sale['id'] == $product->id){
                                        $volume = $sale['total'];
                                        break;
                                    }
                                }
                                $product->total = $product->total + $volume;
                                $product_total = $product_total + $volume;
                                $volume = number_format($volume, 2, ".", ",");
                                
                            ?>
                            
                    <?php endforeach; ?>
                        <th class="text-right"><?= number_format($product_total, 2, ".", ",")  ?></th>
                    <?php $current = date('Y-m-d', strtotime($current . ' + 1 day')); ?>
                <?php endwhile; ?>

            </tbody>
            <tfoot>
                <tr>
                <?php $last_total = 0; ?>
                    <th>TOTAL (LBS)</th>
                    <?php foreach($products as $product) : ?>
                        <?php $last_total = $last_total + $product->total; ?>
                    <?php endforeach; ?>
                    <th class="text-right"><?= number_format($last_total, 2, ".", ",") ?></th>
                </tr>
            </tfoot>
            </table>
        </div>
    </div>
</div><!--End .articles-->


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering": false,
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
    });
});</script>

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
