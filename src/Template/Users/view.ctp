<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$discounts = array(0 => "HTG", 1 => "%");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/users">
            Utilisateurs
        </a></li>
        <li class="active"><?= $user->first_name." ".$user->last_name ?></li>
    </ol><a href="<?= ROOT_DIREC ?>/exports/sales/3/99999/<?= $user->id ?>/1/1" target="_blank" style="float:right;
        margin-top: -34px;
        margin-right: 40px;
        padding: 3px 10px;
        background: black;
        color: white;text-decoration:none!important;cursor:pointer">Excel</a>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Fiche Utilisateur : <?= $user->first_name." ".$user->last_name ?>
        </div>
    <div class="panel-body articles-container">

    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
           <table class="table table-bordered" style="margin-bottom:60px">
               <thead>
                   <tr>
                       <th class="text-center">Nom</th>
                       <th class="text-center">Nom d'Utilisateur</th>
                       <th class="text-center">Rôle</th>
                       <th class="text-center">Statut</th>
                       <th class="text-center">Créé le</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td><?= $user->first_name." ".$user->last_name ?></td>
                       <td><?= $user->username ?></td>
                       <td><?= $user->role->name ?></td>
                       <td><?= ($user->status == 0) ? "<label class='label label-danger'>Inactif</label>" : "<label class='label label-success'>Actif</label>" ?></td>
                       <td><?= $user->created ?></td>
                   </tr>
               </tbody>
           </table>

        <div class="panel-body tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Ventes</a></li>
            </ul>
            <div class="tab-content" style="    border-left: 1px solid #f2f3f2;
    border-right: 1px solid #f2f3f2;
    border-bottom: 1px solid #f2f3f2;">
                <div class="tab-pane fade in active" id="tab1">
                                 <table class="table table-stripped datatable">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Caissier</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Chargé</th>
                    <th class="text-center">Sortie</th>
                    <th class="text-center">Produit</th>
                    <th class="text-center">Volume</th>
                    <th class="text-center">Total HTG</th>
                    <th class="text-center">Total USD</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Heure</th>
                    <th class="text-center">Transport</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php $sous = 0; $reductions = 0; $total = 0; $sous_us = 0; $reductions_us = 0; $total_us = 0; $volume=0; foreach ($user->sales as $sale): ?>
            <tr <?php if($sale->status == 0 || $sale->status == 4) : ?> style="background:#d9edf7" <?php endif; ?>>
                <td class="text-center"> <a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center"><?= $sale->has('user') ? $this->Html->link(substr($sale->user->last_name, 0,1)." ".substr($sale->user->first_name, 0,1), ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>

                <?php if($sale->charged == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($sale->charged_time)) ?></label></td>
                <?php endif; ?>

                <?php if($sale->sortie == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success"><?= date("Y-m-d H:i", strtotime($sale->sortie_time)) ?></label></td>
                <?php endif; ?>

                <?php if($sale->status == 0) : ?>

                    <?php 
                        $sous_us = $sous_us + $sale->subtotal;
                        if($sale->discount_type == 0) {
                            $reductions_us = $reductions_us + $sale->discount;
                        }else{
                            $reductions_us = $reductions_us + ( $sale->subtotal * $sale->discount / 100 );
                        }
                        $total_us = $total_us + $sale->total;
                    ?>

                    
                    <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
                    <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                    <td class="text-center">-</td>
                    <td class="text-center"><?= $this->Number->format($sale->total) ?></td>
                <?php else : ?>
                    <?php 
                        $sous = $sous + $sale->subtotal;
                        if($sale->discount_type == 0) {
                            $reductions = $reductions + $sale->discount;
                        }else{
                            $reductions = $reductions + ( $sale->subtotal * $sale->discount / 100 );
                        }
                        $total = $total + $sale->total;
                    ?>
                    <td class="text-center"><?= $sale->products_sales[0]->product->abbreviation ?></td>
                    <td class="text-center"><?= $sale->products_sales[0]->quantity ?></td>
                    <td class="text-center"><?= $this->Number->format($sale->total) ?></td>
                    <td class="text-center">-</td>
                <?php endif; ?>
                <?php $volume = $volume + $sale->products_sales[0]->quantity; ?>
                
                <td class="text-center"><?= date('Y-m-d', strtotime($sale->created)) ?></td>
                <td class="text-center"><?= date('h:i A', strtotime($sale->created)) ?></td>
                <?php if($sale->transport == 0) : ?>
                    <td class="text-center"><span class="label label-default">Non</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-primary">Oui</span></td>
                <?php endif; ?>
                <td class="text-right"><a href="<?= ROOT_DIREC ?>/sales/edit/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <th>Total</th>
            <th colspan="6"></th>
            <th class="text-center"><?= number_format($volume, 0, ".", ",") ?></th>
            <th class="text-center"><?= number_format($total, 0, ".", ",") ?></th>
            <th class="text-center"><?= number_format($total_us, 0, ".", ",") ?></th>
            <th></th>
        <th></th>
        <th></th>
        <th></th>
        </tfoot>
        
        </table>
                </div>
                <div class="tab-pane fade" id="tab2">
                    <table class="table table-stripped" style="margin-bottom:60px">
                            <thead> 
                                <th>Nom</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Téléphone</th>
                                <th class="text-center">Limite de Crédit</th>
                                <th class="text-center">Réduction</th>
                                <th class="text-center">Date de création</th>
                                <th class="text-center"></th>
                                <th></th>
                            </thead>
                        <tbody> 
                    <?php foreach($user->customers as $customer) : ?>
                        <?php if($customer->id != 1) : ?>
                            <tr>
                                <td class="text-left"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>"><?= $customer->first_name." ".$customer->last_name ?></a></td>
                                <td class="text-center"><?= $customer->email ?></td>
                                <td class="text-center"><?= $customer->phone ?></td>
                                <td class="text-center"><?= number_format($customer->credit_limit, 2, ".", ",") ?> USD</td>
                                <td class="text-center"><?= $customer->discount ?> <?= $discounts[$customer->discount_type] ?></td>
                                <td class="text-center"><?= $customer->created ?></td>
                                <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab3">
                    <table class="table table-stripped">
                            <thead> 
                                <th>Immatriculation</th>
                                <th class="text-center">Volume</th>
                                <th class="text-center">Date de création</th>
                            </thead>
                        <tbody> 
                    <?php foreach($user->trucks as $truck) : ?>
                            <tr>
                                <td class="text-left"><?= $this->Html->image('trucks/'.$truck->photo, ["width" => "60px", "height" => "auto"]); ?> <a href="<?= ROOT_DIREC ?>/trucks/view/<?= $truck->id ?>"><?= $truck->immatriculation ?></a></td>
                                <td class="text-center"><?= $truck->volume ?> m3</td>
                                <td class="text-right"><?= $truck->created ?></td>
                            </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>



        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
        scrollY: "400px",
    scrollX: "2500px",
        scrollCollapse: true,
        paging: false,
        fixedColumns:   {
            leftColumns: 4,
            // rightColumns: 1
        }
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
        text-align:left;
    }
</style>