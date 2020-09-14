<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SuppliersTruck $suppliersTruck
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Suppliers Trucks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="suppliersTrucks form large-9 medium-8 columns content">
    <?= $this->Form->create($suppliersTruck) ?>
    <fieldset>
        <legend><?= __('Add Suppliers Truck') ?></legend>
        <?php
            echo $this->Form->control('supplier_id', ['options' => $suppliers]);
            echo $this->Form->control('truck_id', ['options' => $trucks]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
