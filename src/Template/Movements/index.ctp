<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement[]|\Cake\Collection\CollectionInterface $movements
 */
$validations = array(1 => "OUI", 0 => "NON")

?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li>
            <em class="fa fa-home"></em>
        </li>
        <li class="active">Mouvements</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Mouvements
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/movements/add">
                                                <em class="fa fa-plus"></em> Nouveau Mouvement
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
                        <th class="text-center">Vol</th>
                        <th class="text-center">Validation Client</th>
                        <th class="text-right"></th>
                </thead>
            <tbody> 
        <?php foreach($movements as $movement) : ?>
                <tr>
                    <td><?= $movement->name ?></td>
                    <td class="text-center"><?= $validations[$movement->with_flight] ?></td>
                    <td class="text-center"><?= $validations[$movement->customer_validation]  ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/movements/edit/<?= $movement->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
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

