<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
 */ 

// Type 1 is credit and type 2 is cheque
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Clients</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/customers" target="_blank" style="float:right;
    margin-top: -34px;
    margin-right: 40px;
    padding: 3px 10px;
    background: black;
    color: white;text-decoration:none!important;cursor:pointer">Excel</a>
    <a href="#" target="_blank"  data-toggle="modal" data-target="#importCustomers" style="float:right;
    margin-top: -34px;
    margin-right: 110px;
    padding: 3px 10px;
    background: black;
    color: white;text-decoration:none!important;cursor:pointer">Import</a>
</div>
<?= $this->Flash->render() ?>
<div class="modal fade" id="importCustomers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importer les Clients</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'bulk']]); ?>
      <div class="modal-body">
        <?= $this->Form->file('customers'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button class="btn btn-primary">Valider</button>
      </div>
      <?= $this->Form->end(); ?>
    </div>
  </div>
</div>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Clients
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/customers/add">
                                    <em class="fa fa-plus"></em> Nouveau Client
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
                    <th>Compagnie</th>
                    <th>Représentant</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Devise</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center">Limite</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($customers as $customer) : ?>
            <?php if($customer->id != 1) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>" target="_blank"><?= strtoupper($customer->last_name) ?></a></td>
                    <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>" target="_blank"><?= strtoupper($customer->first_name) ?></a></td>
                    <?php if($customer->type == 1) : ?>
                        <td class="text-center"><span class="label label-info">CREDIT</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-warning">CHEQUE</span></td>
                    <?php endif; ?>

                    <?php if($customer->rate_id == 1) : ?>
                        <td class="text-center"><span class="label label-default">HTG</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success">USD</span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $customer->phone ?></td>
                    <td class="text-center"><?= number_format($customer->credit_limit, 2, ".", ",") ?> <?= $customer->rate->name ?></td>
        
                    <td class="text-center">
                        <?php if($customer->status == 1) : ?>
                            <span class="label label-success">Actif</span>
                        <?php else : ?>
                            <span class="label label-danger">Bloqué</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                     </td>
                </tr>
            <?php endif; ?>
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
           'pdf', 'print'
        ],
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
    });
});
</script>

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
