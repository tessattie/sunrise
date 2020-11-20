<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale[]|\Cake\Collection\CollectionInterface $sales
 */

$discounts = array(0 => "HTG", 1 => "%");
$ouinon = array(0=> "Non", 1 => "Oui");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Ventes</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/exports/sales/<?= $truck_type ?>/<?= $customer ?>/<?= $user ?>/<?= $reussies ?>/<?= $transport ?>" target="_blank" style="float:right;
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
            Ventes <br>
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-20px;margin-top:25px">
                    
                    <div class="col-md-3">
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2', "empty" => "-- Client --", "options" => $customers, "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('reussies', array('class' => 'form-control',"options" => array(1 => "Réussies", 2 => "Annulées"), "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('user_id', array('class' => 'form-control', "empty" => "-- Agent --", "options" => $users, "label" => false, "style" => "width:100%")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container">
            <?php echo $this->element('sales'); ?>
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
