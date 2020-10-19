<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Spayment $spayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Spayment'), ['action' => 'edit', $spayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Spayment'), ['action' => 'delete', $spayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $spayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Spayments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rates'), ['controller' => 'Rates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="spayments view large-9 medium-8 columns content">
    <h3><?= h($spayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $spayment->has('user') ? $this->Html->link($spayment->user->id, ['controller' => 'Users', 'action' => 'view', $spayment->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $spayment->has('supplier') ? $this->Html->link($spayment->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $spayment->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $spayment->has('rate') ? $this->Html->link($spayment->rate->name, ['controller' => 'Rates', 'action' => 'view', $spayment->rate->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Requisition Number') ?></th>
            <td><?= h($spayment->requisition_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($spayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($spayment->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $this->Number->format($spayment->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Daily Rate') ?></th>
            <td><?= $this->Number->format($spayment->daily_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($spayment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($spayment->modified) ?></td>
        </tr>
    </table>
</div>
