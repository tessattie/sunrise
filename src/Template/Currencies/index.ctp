<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Currency[]|\Cake\Collection\CollectionInterface $currencies
 */
?>



<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Configurations pour Coffre</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Configurations pour Coffre
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                        <th>Nom</th>
                        <th class="text-center">Abbréviation</th>
                        <th class="text-center">Taux Vente</th>
                        <th class="text-center">Taux Achat</th>
                        <th class="text-center">Date de création</th>
                        <th class="text-right"></th>
                </thead>
            <tbody> 
        <?php foreach($currencies as $currency) : ?>
                <tr>
                    <td><?= $currency->name ?></td>
                    <td class="text-center"><?= $currency->abbr ?></td>
                    <td class="text-center"><?= $currency->rate_buy ?></td>
                    <td class="text-center"><?= $currency->rate_sale ?></td>
                    <td class="text-center"><?= $currency->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/currencies/edit/<?= $currency->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                    </td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
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
</style>
