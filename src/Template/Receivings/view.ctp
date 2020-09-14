<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiving $receiving
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Receiving'), ['action' => 'edit', $receiving->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Receiving'), ['action' => 'delete', $receiving->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiving->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Receivings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receiving'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="receivings view large-9 medium-8 columns content">
    <h3><?= h($receiving->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $receiving->has('user') ? $this->Html->link($receiving->user->id, ['controller' => 'Users', 'action' => 'view', $receiving->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Truck') ?></th>
            <td><?= $receiving->has('truck') ? $this->Html->link($receiving->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $receiving->truck->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $receiving->has('supplier') ? $this->Html->link($receiving->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $receiving->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($receiving->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($receiving->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($receiving->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cost') ?></th>
            <td><?= $this->Number->format($receiving->cost) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $this->Number->format($receiving->item) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($receiving->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($receiving->modified) ?></td>
        </tr>
    </table>
</div>
