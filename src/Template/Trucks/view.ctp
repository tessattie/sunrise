<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
$discounts = array(0 => "HTG", 1 => "%");
$ouinon = array(0=> "Non", 1 => "Oui");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/trucks">
            Camions
        </a></li>
        <li class="active">Camion <?= $truck->immatriculation ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Fiche Camion <?= $truck->immatriculation ?>
        </div>
    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-md-12 text-center">
            <?= $this->Html->image('trucks/'.$truck->photo, ["width" => "auto", "height" => "auto"]); ?>
        </div>
    </div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
            <table class="table table-bordered" style="margin-bottom:60px;width:100%!important">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Plaque</th>
                    <th class="text-center"  rowspan="2">Créé par</th>
                    <th class="text-center" colspan="3">Benne</th>
                    <th class="text-center" colspan="2">Vérrin</th>
                    <th class="text-center" rowspan="2">Volume</th>
                </tr>
                <tr><th class="text-center">Longueur</th><th class="text-center">Largeur</th><th class="text-center">Hauteur</th><th class="text-center">Largeur</th><th class="text-center">Hauteur</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $truck->immatriculation ?></td>
                    <td><?= $truck->user->first_name." ".$truck->user->last_name ?></td>
                    <td><?= $truck->length ?>m</td>
                    <td><?= $truck->width ?>m</td>
                    <td><?= $truck->height ?>m</td>
                    <td><?= $truck->widthv ?>m</td>
                    <td><?= $truck->heightv ?>m</td>
                    <td><?= $truck->volume ?>m3</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h3 class="text-left"><strong>Ventes Associées</strong></h3>
        <hr>
        <?php echo $this->element('sales', array('sales' => $truck->sales)); ?>
        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->





