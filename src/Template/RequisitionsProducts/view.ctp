<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionsProduct $requisitionsProduct
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Requisitions Product'), ['action' => 'edit', $requisitionsProduct->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Requisitions Product'), ['action' => 'delete', $requisitionsProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requisitionsProduct->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Requisitions Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requisitions Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Requisitions'), ['controller' => 'Requisitions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requisition'), ['controller' => 'Requisitions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requisitionsProducts view large-9 medium-8 columns content">
    <h3><?= h($requisitionsProduct->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $requisitionsProduct->has('product') ? $this->Html->link($requisitionsProduct->product->name, ['controller' => 'Products', 'action' => 'view', $requisitionsProduct->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Requisition') ?></th>
            <td><?= $requisitionsProduct->has('requisition') ? $this->Html->link($requisitionsProduct->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $requisitionsProduct->requisition->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($requisitionsProduct->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($requisitionsProduct->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($requisitionsProduct->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($requisitionsProduct->modified) ?></td>
        </tr>
    </table>
</div>
