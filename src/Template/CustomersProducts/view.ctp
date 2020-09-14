<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersProduct $customersProduct
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customers Product'), ['action' => 'edit', $customersProduct->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customers Product'), ['action' => 'delete', $customersProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customersProduct->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customers Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customers Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customersProducts view large-9 medium-8 columns content">
    <h3><?= h($customersProduct->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $customersProduct->has('customer') ? $this->Html->link($customersProduct->customer->name, ['controller' => 'Customers', 'action' => 'view', $customersProduct->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $customersProduct->has('product') ? $this->Html->link($customersProduct->product->name, ['controller' => 'Products', 'action' => 'view', $customersProduct->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customersProduct->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($customersProduct->price) ?></td>
        </tr>
    </table>
</div>
