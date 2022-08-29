<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement $movement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Movement'), ['action' => 'edit', $movement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movement'), ['action' => 'delete', $movement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trackings'), ['controller' => 'Trackings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tracking'), ['controller' => 'Trackings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="movements view large-9 medium-8 columns content">
    <h3><?= h($movement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($movement->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $movement->has('user') ? $this->Html->link($movement->user->id, ['controller' => 'Users', 'action' => 'view', $movement->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($movement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($movement->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($movement->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Trackings') ?></h4>
        <?php if (!empty($movement->trackings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Products Sale Id') ?></th>
                <th scope="col"><?= __('Flight Id') ?></th>
                <th scope="col"><?= __('Movement Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Station Id') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($movement->trackings as $trackings): ?>
            <tr>
                <td><?= h($trackings->id) ?></td>
                <td><?= h($trackings->products_sale_id) ?></td>
                <td><?= h($trackings->flight_id) ?></td>
                <td><?= h($trackings->movement_id) ?></td>
                <td><?= h($trackings->created) ?></td>
                <td><?= h($trackings->modified) ?></td>
                <td><?= h($trackings->user_id) ?></td>
                <td><?= h($trackings->station_id) ?></td>
                <td><?= h($trackings->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Trackings', 'action' => 'view', $trackings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Trackings', 'action' => 'edit', $trackings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Trackings', 'action' => 'delete', $trackings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trackings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
