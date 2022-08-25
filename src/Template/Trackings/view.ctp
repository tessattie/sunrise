<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tracking $tracking
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tracking'), ['action' => 'edit', $tracking->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tracking'), ['action' => 'delete', $tracking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tracking->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Trackings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tracking'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products Sales'), ['controller' => 'ProductsSales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Products Sale'), ['controller' => 'ProductsSales', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Flights'), ['controller' => 'Flights', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Flight'), ['controller' => 'Flights', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stations'), ['controller' => 'Stations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Station'), ['controller' => 'Stations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="trackings view large-9 medium-8 columns content">
    <h3><?= h($tracking->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Products Sale') ?></th>
            <td><?= $tracking->has('products_sale') ? $this->Html->link($tracking->products_sale->id, ['controller' => 'ProductsSales', 'action' => 'view', $tracking->products_sale->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Flight') ?></th>
            <td><?= $tracking->has('flight') ? $this->Html->link($tracking->flight->name, ['controller' => 'Flights', 'action' => 'view', $tracking->flight->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Movement') ?></th>
            <td><?= $tracking->has('movement') ? $this->Html->link($tracking->movement->id, ['controller' => 'Movements', 'action' => 'view', $tracking->movement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $tracking->has('user') ? $this->Html->link($tracking->user->id, ['controller' => 'Users', 'action' => 'view', $tracking->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Station') ?></th>
            <td><?= $tracking->has('station') ? $this->Html->link($tracking->station->name, ['controller' => 'Stations', 'action' => 'view', $tracking->station->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($tracking->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tracking->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($tracking->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($tracking->modified) ?></td>
        </tr>
    </table>
</div>
