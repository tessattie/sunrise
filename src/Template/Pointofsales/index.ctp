<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pointofsale[]|\Cake\Collection\CollectionInterface $pointofsales
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">POS</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            POS
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/pointofsales/add">
                                                <em class="fa fa-plus"></em> Nouveau POS
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped">
                <thead> 
                    <th>Nom</th>
                    <th class="text-center">Numéro de série</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($pointofsales as $pointofsale) : ?>
                <tr>
                    <td><?= $pointofsale->name ?></td>
                    <td class="text-center"><?= $pointofsale->serial_number ?></td>
                    <?php if($pointofsale->status == 1) : ?>
                        <td class="text-center">  <span class="label label-success"> <?= $status[$pointofsale->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center">  <span class="label label-danger"> <?= $status[$pointofsale->status] ?></span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $pointofsale->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/pointofsales/edit/<?= $pointofsale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
					<a href="<?= ROOT_DIREC ?>/pointofsales/delete/<?= $pointofsale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-trash color-red"></span></a></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->