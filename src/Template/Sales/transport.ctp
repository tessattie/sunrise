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
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Rapport Transport
        </div>
    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-m-12">
            <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('customer_id', array('class' => 'form-control select2', "empty" => "-- Client --", "options" => $customers, "label" => false, "style" => "width:100%")); ?>
                    </div>
                    <div class="col-md-2" style="margin-left:20px">
                        <?= $this->Form->control('immatriculation', array('class' => 'form-control', "placeholder" => "Immatriculation", "label" => false)); ?>
                    </div>

                    <div class="col-md-1" style="margin-left:-38px">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left", "style" => "height: 46px;border-radius: 0px;")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <hr>
        </div>
    </div>
            <?php echo $this->element('transport'); ?>

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
