<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement[]|\Cake\Collection\CollectionInterface $movements
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Movement'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Methods'), ['controller' => 'Methods', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Method'), ['controller' => 'Methods', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="movements index large-9 medium-8 columns content">
    <h3><?= __('Movements') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movements as $movement): ?>
            <tr>
                <td><?= $this->Number->format($movement->id) ?></td>
                <td><?= h($movement->name) ?></td>
                <td><?= h($movement->created) ?></td>
                <td><?= h($movement->modified) ?></td>
                <td><?= $movement->has('user') ? $this->Html->link($movement->user->id, ['controller' => 'Users', 'action' => 'view', $movement->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $movement->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $movement->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $movement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movement->id)]) ?>
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
