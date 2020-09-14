<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SuppliersTruck $suppliersTruck
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Suppliers Truck'), ['action' => 'edit', $suppliersTruck->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Suppliers Truck'), ['action' => 'delete', $suppliersTruck->id], ['confirm' => __('Are you sure you want to delete # {0}?', $suppliersTruck->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers Trucks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Suppliers Truck'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="suppliersTrucks view large-9 medium-8 columns content">
    <h3><?= h($suppliersTruck->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $suppliersTruck->has('supplier') ? $this->Html->link($suppliersTruck->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $suppliersTruck->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Truck') ?></th>
            <td><?= $suppliersTruck->has('truck') ? $this->Html->link($suppliersTruck->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $suppliersTruck->truck->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($suppliersTruck->id) ?></td>
        </tr>
    </table>
</div>
