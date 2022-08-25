<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tracking[]|\Cake\Collection\CollectionInterface $trackings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tracking'), ['action' => 'add']) ?></li>
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
<div class="trackings index large-9 medium-8 columns content">
    <h3><?= __('Trackings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('products_sale_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('flight_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('movement_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('station_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trackings as $tracking): ?>
            <tr>
                <td><?= $this->Number->format($tracking->id) ?></td>
                <td><?= $tracking->has('products_sale') ? $this->Html->link($tracking->products_sale->id, ['controller' => 'ProductsSales', 'action' => 'view', $tracking->products_sale->id]) : '' ?></td>
                <td><?= $tracking->has('flight') ? $this->Html->link($tracking->flight->name, ['controller' => 'Flights', 'action' => 'view', $tracking->flight->id]) : '' ?></td>
                <td><?= $tracking->has('movement') ? $this->Html->link($tracking->movement->id, ['controller' => 'Movements', 'action' => 'view', $tracking->movement->id]) : '' ?></td>
                <td><?= h($tracking->created) ?></td>
                <td><?= h($tracking->modified) ?></td>
                <td><?= $tracking->has('user') ? $this->Html->link($tracking->user->id, ['controller' => 'Users', 'action' => 'view', $tracking->user->id]) : '' ?></td>
                <td><?= $tracking->has('station') ? $this->Html->link($tracking->station->name, ['controller' => 'Stations', 'action' => 'view', $tracking->station->id]) : '' ?></td>
                <td><?= h($tracking->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tracking->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tracking->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tracking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tracking->id)]) ?>
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
