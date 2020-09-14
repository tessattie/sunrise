<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
$discounts = array(0 => "HTG", 1 => "%");
$rates= array(1 => "HTG", 2 => "USD");

?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Clients
        </a></li>
        <li class="active"><?= $customer->first_name." ".$customer->last_name ?></li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/sales/3/<?= $customer->id ?>/99999/1/1" target="_blank" style="float:right;
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
            Fiche Client : <?= $customer->first_name." ".$customer->last_name ?>
        </div>
    <div class="panel-body articles-container">

    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
           <table class="table table-bordered" style="margin-bottom:60px;width:100%!important">
               <thead>
                   <tr>
                       <th class="text-center">Compagnie</th>
                       <th class="text-center">Représentant</th>
                       <th class="text-center">Type</th>
                       <th class="text-center">Email</th>
                       <th class="text-center">Téléphone</th>
                       <th class="text-center">Créé par</th>
                       <th class="text-center">Limite de Crédit</th>
                       <th class="text-center">Réduction</th>
                       <th class="text-center">Créé le</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td><?= strtoupper($customer->last_name) ?></td>
                       <td><?= strtoupper($customer->first_name) ?></td>
                       <td>
                        <?php if($customer->type == 1) : ?>
                          <span span class="label label-info"> CREDIT</span>
                        <?php else : ?>
                          <span span class="label label-info"> CHEQUE</span>
                        <?php endif; ?>

                        <?php if($customer->rate_id == 1) : ?>
                          <span span class="label label-primary"> HTG</span>
                        <?php else : ?>
                          <span span class="label label-success"> USD</span>
                        <?php endif; ?>
                       </td>
                       <td><?= $customer->email ?></td>
                       <td><?= $customer->phone ?></td>
                       <td> <a target="_blank" href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->user->id ?>"><?= $customer->user->first_name." ".$customer->user->last_name ?></a></td>
                       <td><?= number_format($customer->credit_limit, 2, ".", ",") ?> <?= $customer->rate->name ?></td>
                       <td><?= $customer->discount." ".$discounts[$customer->discount_type] ?></td>
                       <td><?= $customer->created ?></td>
                   </tr>
               </tbody>
           </table>
        <hr>
        <h3 class="text-left"><strong>Ventes</strong></h3>
        <hr>
        <?php $sales = $customer->sales ?>
            <?php echo $this->element('sales', array('sales' => $customer->sales)); ?>

        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->


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

