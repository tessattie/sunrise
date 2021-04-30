<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck[]|\Cake\Collection\CollectionInterface $trucks
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Paquets</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Paquets
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/trucks/add">
                                    <em class="fa fa-plus"></em> Nouveau Paquet
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
                    <th class="text-left">Nom</th>
                    <th class="text-center">Prix</th>
                    <th class="text-center">Taxe</th>
                    <th class="text-center">Poid min</th>
                    <th class="text-center">Poid Max</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($trucks as $truck) : ?>
                <tr>
                    <td class="text-left"><a href="<?= ROOT_DIREC ?>/trucks/view/<?= $truck->id ?>"><?= $truck->immatriculation ?></a></td>
                    <td class="text-center"><?= $truck->price ?> USD</td>
                    <td class="text-center"><?= $truck->taxe ?> USD</td>
                    <td class="text-center"><?= $truck->min_weight ?> KG</td>
                    <td class="text-center"><?= $truck->max_weight ?> KG</td>
                    <?php if($truck->status == 0) : ?>
                        <td class="text-center">Fixe</td>
                    <?php else : ?>
                        <td class="text-center">Editable</td>
                    <?php endif; ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/trucks/edit/<?= $truck->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
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
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
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
        text-align:left!important;
    }
</style>
