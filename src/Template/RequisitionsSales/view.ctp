<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionsSale $requisitionsSale
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Requisitions Sale'), ['action' => 'edit', $requisitionsSale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Requisitions Sale'), ['action' => 'delete', $requisitionsSale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requisitionsSale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Requisitions Sales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requisitions Sale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Requisitions'), ['controller' => 'Requisitions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requisition'), ['controller' => 'Requisitions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requisitionsSales view large-9 medium-8 columns content">
    <h3><?= h($requisitionsSale->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Requisition') ?></th>
            <td><?= $requisitionsSale->has('requisition') ? $this->Html->link($requisitionsSale->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $requisitionsSale->requisition->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale') ?></th>
            <td><?= $requisitionsSale->has('sale') ? $this->Html->link($requisitionsSale->sale->id, ['controller' => 'Sales', 'action' => 'view', $requisitionsSale->sale->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($requisitionsSale->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($requisitionsSale->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($requisitionsSale->modified) ?></td>
        </tr>
    </table>
</div>
