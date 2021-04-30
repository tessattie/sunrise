<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Flight $flight
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Flight'), ['action' => 'edit', $flight->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Flight'), ['action' => 'delete', $flight->id], ['confirm' => __('Are you sure you want to delete # {0}?', $flight->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Flights'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Flight'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products Sales'), ['controller' => 'ProductsSales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Products Sale'), ['controller' => 'ProductsSales', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="flights view large-9 medium-8 columns content">
    <h3><?= h($flight->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($flight->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($flight->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($flight->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($flight->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $flight->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Products Sales') ?></h4>
        <?php if (!empty($flight->products_sales)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Barcode') ?></th>
                <th scope="col"><?= __('Image Path') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Truck Id') ?></th>
                <th scope="col"><?= __('Sale Id') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Taxe') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('TotalPrice') ?></th>
                <th scope="col"><?= __('List Price') ?></th>
                <th scope="col"><?= __('Flight Id') ?></th>
                <th scope="col"><?= __('Tag') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Loaded') ?></th>
                <th scope="col"><?= __('Loaded User Id') ?></th>
                <th scope="col"><?= __('Landed') ?></th>
                <th scope="col"><?= __('Landed User Id') ?></th>
                <th scope="col"><?= __('Delivered') ?></th>
                <th scope="col"><?= __('Delivered User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($flight->products_sales as $productsSales): ?>
            <tr>
                <td><?= h($productsSales->id) ?></td>
                <td><?= h($productsSales->barcode) ?></td>
                <td><?= h($productsSales->image_path) ?></td>
                <td><?= h($productsSales->product_id) ?></td>
                <td><?= h($productsSales->truck_id) ?></td>
                <td><?= h($productsSales->sale_id) ?></td>
                <td><?= h($productsSales->price) ?></td>
                <td><?= h($productsSales->taxe) ?></td>
                <td><?= h($productsSales->quantity) ?></td>
                <td><?= h($productsSales->totalPrice) ?></td>
                <td><?= h($productsSales->list_price) ?></td>
                <td><?= h($productsSales->flight_id) ?></td>
                <td><?= h($productsSales->tag) ?></td>
                <td><?= h($productsSales->comment) ?></td>
                <td><?= h($productsSales->status) ?></td>
                <td><?= h($productsSales->created) ?></td>
                <td><?= h($productsSales->modified) ?></td>
                <td><?= h($productsSales->loaded) ?></td>
                <td><?= h($productsSales->loaded_user_id) ?></td>
                <td><?= h($productsSales->landed) ?></td>
                <td><?= h($productsSales->landed_user_id) ?></td>
                <td><?= h($productsSales->delivered) ?></td>
                <td><?= h($productsSales->delivered_user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProductsSales', 'action' => 'view', $productsSales->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProductsSales', 'action' => 'edit', $productsSales->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductsSales', 'action' => 'delete', $productsSales->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productsSales->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
