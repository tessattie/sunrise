<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersProduct[]|\Cake\Collection\CollectionInterface $customersProducts
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Spécials Clients</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Prix Spécials Clients
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/customersProducts/add">
                                                <em class="fa fa-plus"></em> Nouveau Spécial
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                        <th>Client</th>
                        <th class="text-center">Produit</th>
                        <th class="text-center">Prix</th>
                        <th class="text-right"></th>
                </thead>
            <tbody> 
        <?php foreach($customersProducts as $cp) : ?>
                <tr>
                    <td><?= strtoupper($cp->customer->last_name) . " " . strtoupper($cp->customer->first_name) ?></td>
                    <td class="text-center"><?= $cp->product->name ?></td>
                    <td class="text-center"><?= number_format($cp->price,2,".", ",") ?> USD</td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customersProducts/edit/<?= $cp->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>  <a href="<?= ROOT_DIREC ?>/customersProducts/delete/<?= $cp->id ?>" style="font-size:1.3em!important;margin-left:15px"><span class="fa fa-xl fa-trash color-red"></span></a></td>
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