<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tracking $tracking
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li>
            <em class="fa fa-home"></em>
        </li>
        <li><a href="<?= ROOT_DIREC ?>/sales/manifest">
            Trackings
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Tracking
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cog"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/manifest">
                                                 Retour
                                            </a></li>
                                            <li><?= $this->Form->postLink(
                                                     __('Supprimer'),
                                                    ['action' => 'delete', $tracking->id],
                                                    ['confirm' => __('Etes-vous sûr de vouloir supprimer ce tracking?')]
                                                )       
                                            ?></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($tracking) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('movement_id', array('class' => 'form-control', "label" => "Statut *", 'options' => $movements)); ?></div>
                <div class="col-md-6"><?= $this->Form->control('flight_id', array('class' => 'form-control', "label" => "Vol", 'options' => $flights, 'empty' => "-- Choisissez --")); ?></div>
                    
                    
                </div>  
                <hr>
                <div class="row" style="margin-top:15px">
                <div class="col-md-12"><?= $this->Form->control('comment', array('class' => 'form-control', "label" => "Commentaire *", "placeholder" => "Commentaire")); ?></div>
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
