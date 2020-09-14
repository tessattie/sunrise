<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Method[]|\Cake\Collection\CollectionInterface $methods
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Méthodes de Paiement</li>
    </ol>
</div>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Méthodes de Paiement
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped">
                <thead> 
                        <th>Nom</th>
                        <th class="text-right">Date de création</th>
                </thead>
            <tbody> 
        <?php foreach($methods as $method) : ?>
                <tr>
                    <td><?= $method->name ?></td>
                    <td class="text-right"><?= $method->created ?></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
