<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Card $card
 */
?>


<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/cards">
            Cartes
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Carte : <?= $card->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cog"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/cards">
                                                 Retour
                                            </a></li>
                                            <li><?= $this->Form->postLink(
                                                     __('Supprimer'),
                                                    ['action' => 'delete', $card->id],
                                                    ['confirm' => __('Etes-vous sûr de vouloir supprimer la carte {0}?', $card->name)]
                                                )       
                                            ?></li>
                                            <li><a href="<?= ROOT_DIREC ?>/cards/add">
                                               Nouvelle Carte
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($card) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('code', array('class' => 'form-control', "label" => "Code *", "placeholder" => "Code")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                </div>  
                <div class="row" style="margin-top:15px">
                    <div class="col-md-6"><?= $this->Form->control('users._ids', array('class' => 'form-control', 'options' => $users, "label" => "Utilisateur", "empty" => "-- Choisissez --", "multiple" => false, 'required' => false)); ?></div>
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
