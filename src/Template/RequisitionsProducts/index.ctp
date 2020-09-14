<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionsProduct[]|\Cake\Collection\CollectionInterface $requisitionsProducts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Requisitions Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Requisitions'), ['controller' => 'Requisitions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Requisition'), ['controller' => 'Requisitions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requisitionsProducts index large-9 medium-8 columns content">
    <h3><?= __('Requisitions Products') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('requisition_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requisitionsProducts as $requisitionsProduct): ?>
            <tr>
                <td><?= $this->Number->format($requisitionsProduct->id) ?></td>
                <td><?= $requisitionsProduct->has('product') ? $this->Html->link($requisitionsProduct->product->name, ['controller' => 'Products', 'action' => 'view', $requisitionsProduct->product->id]) : '' ?></td>
                <td><?= $requisitionsProduct->has('requisition') ? $this->Html->link($requisitionsProduct->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $requisitionsProduct->requisition->id]) : '' ?></td>
                <td><?= $this->Number->format($requisitionsProduct->quantity) ?></td>
                <td><?= h($requisitionsProduct->created) ?></td>
                <td><?= h($requisitionsProduct->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $requisitionsProduct->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requisitionsProduct->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $requisitionsProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requisitionsProduct->id)]) ?>
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
