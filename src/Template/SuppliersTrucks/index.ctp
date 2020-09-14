<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SuppliersTruck[]|\Cake\Collection\CollectionInterface $suppliersTrucks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Suppliers Truck'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="suppliersTrucks index large-9 medium-8 columns content">
    <h3><?= __('Suppliers Trucks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('supplier_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('truck_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliersTrucks as $suppliersTruck): ?>
            <tr>
                <td><?= $this->Number->format($suppliersTruck->id) ?></td>
                <td><?= $suppliersTruck->has('supplier') ? $this->Html->link($suppliersTruck->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $suppliersTruck->supplier->id]) : '' ?></td>
                <td><?= $suppliersTruck->has('truck') ? $this->Html->link($suppliersTruck->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $suppliersTruck->truck->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $suppliersTruck->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $suppliersTruck->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $suppliersTruck->id], ['confirm' => __('Are you sure you want to delete # {0}?', $suppliersTruck->id)]) ?>
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
