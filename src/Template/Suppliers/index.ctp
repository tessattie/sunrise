<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier[]|\Cake\Collection\CollectionInterface $suppliers
 */
?>

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
            Fournisseurs
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/suppliers/add">
                                                <em class="fa fa-plus"></em> Nouveau Fournisseur
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
                    <th>Nom</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Produit</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($suppliers as $supplier) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/suppliers/edit/<?= $supplier->id ?>"><?= strtoupper($supplier->name) ?></a></td>
                    <td class="text-center"><?= $supplier->phone ?></td>
                    <td class="text-center"><?= $supplier->email ?></td>
                    <td class="text-center"><?= $supplier->item->name ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/suppliers/edit/<?= $supplier->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
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
</style>