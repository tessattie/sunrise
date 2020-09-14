<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductsSale[]|\Cake\Collection\CollectionInterface $productsSales
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Products Sale'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="productsSales index large-9 medium-8 columns content">
    <h3><?= __('Products Sales') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productsSales as $productsSale): ?>
            <tr>
                <td><?= $this->Number->format($productsSale->id) ?></td>
                <td><?= $productsSale->has('product') ? $this->Html->link($productsSale->product->name, ['controller' => 'Products', 'action' => 'view', $productsSale->product->id]) : '' ?></td>
                <td><?= $productsSale->has('sale') ? $this->Html->link($productsSale->sale->id, ['controller' => 'Sales', 'action' => 'view', $productsSale->sale->id]) : '' ?></td>
                <td><?= $this->Number->format($productsSale->price) ?></td>
                <td><?= $this->Number->format($productsSale->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $productsSale->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productsSale->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $productsSale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productsSale->id)]) ?>
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
