<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cpayment $cpayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cpayment'), ['action' => 'edit', $cpayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cpayment'), ['action' => 'delete', $cpayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cpayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cpayments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cpayment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rates'), ['controller' => 'Rates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cpayments view large-9 medium-8 columns content">
    <h3><?= h($cpayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $cpayment->has('customer') ? $this->Html->link($cpayment->customer->name, ['controller' => 'Customers', 'action' => 'view', $cpayment->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $cpayment->has('rate') ? $this->Html->link($cpayment->rate->name, ['controller' => 'Rates', 'action' => 'view', $cpayment->rate->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $cpayment->has('user') ? $this->Html->link($cpayment->user->id, ['controller' => 'Users', 'action' => 'view', $cpayment->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cpayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($cpayment->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Daily Rate') ?></th>
            <td><?= $this->Number->format($cpayment->daily_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cpayment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cpayment->modified) ?></td>
        </tr>
    </table>
</div>
