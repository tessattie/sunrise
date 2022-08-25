<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrucksStation[]|\Cake\Collection\CollectionInterface $trucksStations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Trucks Station'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stations'), ['controller' => 'Stations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Station'), ['controller' => 'Stations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="trucksStations index large-9 medium-8 columns content">
    <h3><?= __('Trucks Stations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('station_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('truck_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('taxe') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trucksStations as $trucksStation): ?>
            <tr>
                <td><?= $this->Number->format($trucksStation->id) ?></td>
                <td><?= $trucksStation->has('station') ? $this->Html->link($trucksStation->station->name, ['controller' => 'Stations', 'action' => 'view', $trucksStation->station->id]) : '' ?></td>
                <td><?= $trucksStation->has('truck') ? $this->Html->link($trucksStation->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $trucksStation->truck->id]) : '' ?></td>
                <td><?= $this->Number->format($trucksStation->price) ?></td>
                <td><?= $this->Number->format($trucksStation->taxe) ?></td>
                <td><?= h($trucksStation->created) ?></td>
                <td><?= h($trucksStation->modified) ?></td>
                <td><?= $trucksStation->has('user') ? $this->Html->link($trucksStation->user->id, ['controller' => 'Users', 'action' => 'view', $trucksStation->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $trucksStation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $trucksStation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $trucksStation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucksStation->id)]) ?>
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
