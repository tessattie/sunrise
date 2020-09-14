<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductsSale $productsSale
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Products Sale'), ['action' => 'edit', $productsSale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Products Sale'), ['action' => 'delete', $productsSale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productsSale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products Sales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Products Sale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="productsSales view large-9 medium-8 columns content">
    <h3><?= h($productsSale->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productsSale->has('product') ? $this->Html->link($productsSale->product->name, ['controller' => 'Products', 'action' => 'view', $productsSale->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale') ?></th>
            <td><?= $productsSale->has('sale') ? $this->Html->link($productsSale->sale->id, ['controller' => 'Sales', 'action' => 'view', $productsSale->sale->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productsSale->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($productsSale->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($productsSale->quantity) ?></td>
        </tr>
    </table>
</div>
