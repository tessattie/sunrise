<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiver[]|\Cake\Collection\CollectionInterface $receivers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Receiver'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="receivers index large-9 medium-8 columns content">
    <h3><?= __('Receivers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receivers as $receiver): ?>
            <tr>
                <td><?= $this->Number->format($receiver->id) ?></td>
                <td><?= h($receiver->name) ?></td>
                <td><?= h($receiver->phone) ?></td>
                <td><?= h($receiver->email) ?></td>
                <td><?= h($receiver->created) ?></td>
                <td><?= h($receiver->modified) ?></td>
                <td><?= h($receiver->address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $receiver->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $receiver->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $receiver->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiver->id)]) ?>
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
