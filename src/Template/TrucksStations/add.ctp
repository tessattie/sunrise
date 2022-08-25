<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrucksStation $trucksStation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Trucks Stations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stations'), ['controller' => 'Stations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Station'), ['controller' => 'Stations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="trucksStations form large-9 medium-8 columns content">
    <?= $this->Form->create($trucksStation) ?>
    <fieldset>
        <legend><?= __('Add Trucks Station') ?></legend>
        <?php
            echo $this->Form->control('station_id', ['options' => $stations]);
            echo $this->Form->control('truck_id', ['options' => $trucks]);
            echo $this->Form->control('price');
            echo $this->Form->control('taxe');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
