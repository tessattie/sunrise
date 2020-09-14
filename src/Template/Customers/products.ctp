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
            Ventes Clients
        </div>
        <div class="panel-body articles-container">
            <table class="table datatable">
                <thead>
                    <th style="width:110px"></th>
                    <th>TOTAL HTG</th>
                    <th>TOTAL USD</th>
                    <?php $i = 1; ?>
                    <?php foreach($products as $product) : ?>
                        <?php $i = $i+1; ?>
                        <th><?= $product->abbreviation ?></th>
                    <?php endforeach; ?>
                    <th>VOLUME</th>
                    <th>TRANSPORT</th>
                </thead>
            
            <tbody>
                <?php $number=1; foreach($customers as $customer) : ?>
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
                        <td class="text-center"><?= number_format($prd['total_sold'],2,".",",") ?></td>
                    <?php endforeach; ?>
                    <th class="text-center"><?= number_format($volume, 2, ".", ",") ?></th>
                    <td class="text-center"><?= $customer->transport ?></td>
                    </tr>
                    <?php $number++ ?>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        
    </div>
</div>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                'pdf', 'print'
            ],
            scrollY: "400px",
            scrollX: "2700px",
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
