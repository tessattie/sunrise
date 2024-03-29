<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="">Rapports</li>
        <li class="active">Clients</li>
    </ol>
        <a href="<?= ROOT_DIREC ?>/exports/monthly_customers" target="_blank" style="float:right;
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
            Ventes par clients
        </div>
        <div class="panel-body articles-container">
            <table class="table datatable">
                <thead>
                    <th style="width:110px"></th>
                    <th class="text-center">TOTAL HTG</th>
                    <th class="text-center">TOTAL USD</th>
                    <?php $i = 1; ?>
                    <?php foreach($products as $product) : ?>
                        <?php $i = $i+1; ?>
                    <?php endforeach; ?>
                    <th class="text-right">POID (KG)</th>
                </thead>
            
            <tbody>
                <?php $number=1; foreach($customers as $customer) : ?>
                <?php if($customer->total > 0) : ?>
                    <tr <?= ($number % 2 == 0) ? "style='background:#F2F2F2'" : "" ?>><td> <a target="_blank" style="" href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>"><?= (empty($customer->last_name)) ? strtoupper($customer->first_name) : strtoupper($customer->last_name) ?></a></td>
                    <?php if($customer->rate_id == 1) : ?>
                        <th class="text-center"><?= number_format($customer->total, 2, ".", ",") ?></th>
                        <th class="text-center">-</th>
                    <?php else : ?>
                        <th class="text-center">-</th>
                        <th class="text-center"><?= number_format($customer->total, 2, ".", ",") ?></th>
                    <?php endif; ?>
                    <?php $volume = 0 ?>
                    <?php foreach($customer->products as $prd) : ?>
                        <?php $volume = $volume + $prd['total_sold'] ?>
                    <?php endforeach; ?>
                    <th class="text-right"><?= number_format($volume, 2, ".", ",") ?> KG</th>
                    </tr>
                    <?php $number++ ?>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        
    </div>
</div>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
            "ordering": false,
            scrollY: "400px",
            scrollCollapse: true,
            paging: false,
        });
    });    
</script>

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
