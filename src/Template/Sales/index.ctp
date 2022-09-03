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
            Ventes <br>
           
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
