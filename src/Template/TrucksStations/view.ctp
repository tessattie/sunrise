<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrucksStation $trucksStation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Trucks Station'), ['action' => 'edit', $trucksStation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Trucks Station'), ['action' => 'delete', $trucksStation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucksStation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Trucks Stations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Trucks Station'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stations'), ['controller' => 'Stations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Station'), ['controller' => 'Stations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="trucksStations view large-9 medium-8 columns content">
    <h3><?= h($trucksStation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Station') ?></th>
            <td><?= $trucksStation->has('station') ? $this->Html->link($trucksStation->station->name, ['controller' => 'Stations', 'action' => 'view', $trucksStation->station->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Truck') ?></th>
            <td><?= $trucksStation->has('truck') ? $this->Html->link($trucksStation->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $trucksStation->truck->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $trucksStation->has('user') ? $this->Html->link($trucksStation->user->id, ['controller' => 'Users', 'action' => 'view', $trucksStation->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($trucksStation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($trucksStation->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxe') ?></th>
            <td><?= $this->Number->format($trucksStation->taxe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($trucksStation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($trucksStation->modified) ?></td>
        </tr>
    </table>
</div>
