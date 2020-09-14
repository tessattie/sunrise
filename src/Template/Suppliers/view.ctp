<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Supplier'), ['action' => 'edit', $supplier->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Supplier'), ['action' => 'delete', $supplier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receivings'), ['controller' => 'Receivings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receiving'), ['controller' => 'Receivings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="suppliers view large-9 medium-8 columns content">
    <h3><?= h($supplier->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($supplier->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($supplier->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($supplier->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $supplier->has('user') ? $this->Html->link($supplier->user->id, ['controller' => 'Users', 'action' => 'view', $supplier->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($supplier->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($supplier->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($supplier->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Trucks') ?></h4>
        <?php if (!empty($supplier->trucks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Immatriculation') ?></th>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= __('Volume') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Length') ?></th>
                <th scope="col"><?= __('Width') ?></th>
                <th scope="col"><?= __('Height') ?></th>
                <th scope="col"><?= __('Heightv') ?></th>
                <th scope="col"><?= __('Widthv') ?></th>
                <th scope="col"><?= __('Lengthv') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($supplier->trucks as $trucks): ?>
            <tr>
                <td><?= h($trucks->id) ?></td>
                <td><?= h($trucks->immatriculation) ?></td>
                <td><?= h($trucks->photo) ?></td>
                <td><?= h($trucks->volume) ?></td>
                <td><?= h($trucks->created) ?></td>
                <td><?= h($trucks->modified) ?></td>
                <td><?= h($trucks->status) ?></td>
                <td><?= h($trucks->user_id) ?></td>
                <td><?= h($trucks->name) ?></td>
                <td><?= h($trucks->length) ?></td>
                <td><?= h($trucks->width) ?></td>
                <td><?= h($trucks->height) ?></td>
                <td><?= h($trucks->heightv) ?></td>
                <td><?= h($trucks->widthv) ?></td>
                <td><?= h($trucks->lengthv) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Trucks', 'action' => 'view', $trucks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Trucks', 'action' => 'edit', $trucks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Trucks', 'action' => 'delete', $trucks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Receivings') ?></h4>
        <?php if (!empty($supplier->receivings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Truck Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Cost') ?></th>
                <th scope="col"><?= __('Item') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($supplier->receivings as $receivings): ?>
            <tr>
                <td><?= h($receivings->id) ?></td>
                <td><?= h($receivings->created) ?></td>
                <td><?= h($receivings->modified) ?></td>
                <td><?= h($receivings->user_id) ?></td>
                <td><?= h($receivings->status) ?></td>
                <td><?= h($receivings->truck_id) ?></td>
                <td><?= h($receivings->supplier_id) ?></td>
                <td><?= h($receivings->quantity) ?></td>
                <td><?= h($receivings->cost) ?></td>
                <td><?= h($receivings->item) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Receivings', 'action' => 'view', $receivings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Receivings', 'action' => 'edit', $receivings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Receivings', 'action' => 'delete', $receivings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receivings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
