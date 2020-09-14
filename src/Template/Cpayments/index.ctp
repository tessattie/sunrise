<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cpayment[]|\Cake\Collection\CollectionInterface $cpayments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cpayment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['controller' => 'Rates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cpayments index large-9 medium-8 columns content">
    <h3><?= __('Cpayments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('daily_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cpayments as $cpayment): ?>
            <tr>
                <td><?= $this->Number->format($cpayment->id) ?></td>
                <td><?= $cpayment->has('customer') ? $this->Html->link($cpayment->customer->name, ['controller' => 'Customers', 'action' => 'view', $cpayment->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($cpayment->amount) ?></td>
                <td><?= $cpayment->has('rate') ? $this->Html->link($cpayment->rate->name, ['controller' => 'Rates', 'action' => 'view', $cpayment->rate->id]) : '' ?></td>
                <td><?= $this->Number->format($cpayment->daily_rate) ?></td>
                <td><?= h($cpayment->created) ?></td>
                <td><?= h($cpayment->modified) ?></td>
                <td><?= $cpayment->has('user') ? $this->Html->link($cpayment->user->id, ['controller' => 'Users', 'action' => 'view', $cpayment->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cpayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cpayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cpayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cpayment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
