<?php 
$months = array("01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril", "05" => "Mai", "06" => "Juin", "07" => "Juillet","08" => "Août", "09" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Décembre");

$years = array("2019" => "2019", "2020" => "2020", '2021' => '2021', '2022' => '2022', '2023' => '2023', '2023' => '2023', '2024' => '2024');
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Ventes Journalières</li>
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
            Ventes Journalières
        </div>
        <div class="panel-body articles-container">
            <!--End .article-->
            <table class="table datatable">
                <thead>
                    <th style="width:110px"></th>
                    <th class="text-center">TAXE (HTG)</th>
                    <th class="text-center">TAXE (USD)</th>
                    <th class="text-center">TOTAL (HTG)</th>
                    <th class="text-right">TOTAL (USD)</th>
                </thead>
            
            <tbody>
                <?php foreach($sales as $sale) : ?>  
                <tr>
                    <th><?= $sale['date'] ?></th>
                    <td class="text-center"><?= number_format($sale['taxe_htg'], 2, ".", ",") ?></td>
                    <td class="text-center"><?= number_format($sale['taxe_usd'], 2, ".", ",") ?></td>
                    <td class="text-center"><?= number_format($sale['total_htg'], 2, ".", ",") ?></td>
                    <td class="text-right"><?= number_format($sale['total_usd'], 2, ".", ",") ?></td>
                </tr>              
                <?php endforeach; ?>
            </tbody>
            <tfoot>

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
