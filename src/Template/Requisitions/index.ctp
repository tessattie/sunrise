<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition[]|\Cake\Collection\CollectionInterface $requisitions
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Réquisitions</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Réquisitions
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/requisitions/add">
                                                <em class="fa fa-plus"></em> Nouvelle Réquisition
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
                        <th>Numéro Réquisition</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">Créé par</th>
                        <th class="text-center">Date de création</th>
                        <th class="text-right"></th>
                </thead>
            <tbody> 
        <?php foreach ($requisitions as $requisition): ?>
            <tr>
                <td><?= $requisition->uid ?></td>
                <td class="text-center"><?= $requisition->has('customer') ? $this->Html->link($requisition->customer->first_name." ".$requisition->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $requisition->customer->id]) : '' ?></td>
                <td class="text-center"><?= $requisition->has('user') ? $this->Html->link(strtoupper($requisition->user->last_name)." ".ucfirst(strtolower($requisition->user->first_name)), ['controller' => 'Users', 'action' => 'view', $requisition->user->id]) : '' ?></td>
                <td class="text-center"><?= h($requisition->created) ?></td>
                <td class="actions text-right">
                    <a href="<?= ROOT_DIREC ?>/requisitions/edit/<?= $requisition->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                    <a href="<?= ROOT_DIREC ?>/requisitions/delete/<?= $requisition->id ?>" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
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
	orderable:false,
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
        text-align:left!important;
    }
</style>
