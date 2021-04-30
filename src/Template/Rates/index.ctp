<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate[]|\Cake\Collection\CollectionInterface $rates
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Taux du jour</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Taux du jour
                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped">
                <thead> 
                    <th>Type</th>
                    <th class="text-center">Produits</th>
                    <th class="text-center">Paiements</th>
                    <th class="text-center">Dernière Modification</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($rates as $rate) : ?>
                <tr>
                    <td><?= $rate->name ?></td>
                    <td class="text-center">1 <?= $rate->name ?> = <?= number_format($rate->amount, 2, ".", ",") ?> HTG</td>
                    <td class="text-center">1 <?= $rate->name ?> = <?= number_format($rate->payment, 2, ".", ",") ?> HTG</td>
                    <td class="text-center"><?= $rate->modified ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/rates/edit/<?= $rate->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->