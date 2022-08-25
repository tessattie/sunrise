<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tracking $tracking
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Trackings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Products Sales'), ['controller' => 'ProductsSales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Products Sale'), ['controller' => 'ProductsSales', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Flights'), ['controller' => 'Flights', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Flight'), ['controller' => 'Flights', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stations'), ['controller' => 'Stations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Station'), ['controller' => 'Stations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="trackings form large-9 medium-8 columns content">
    <?= $this->Form->create($tracking) ?>
    <fieldset>
        <legend><?= __('Add Tracking') ?></legend>
        <?php
            echo $this->Form->control('products_sale_id', ['options' => $productsSales]);
            echo $this->Form->control('flight_id', ['options' => $flights, 'empty' => true]);
            echo $this->Form->control('movement_id', ['options' => $movements]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('station_id', ['options' => $stations]);
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
