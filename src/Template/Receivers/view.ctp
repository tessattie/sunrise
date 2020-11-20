<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receiver $receiver
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Receiver'), ['action' => 'edit', $receiver->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Receiver'), ['action' => 'delete', $receiver->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiver->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Receivers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receiver'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="receivers view large-9 medium-8 columns content">
    <h3><?= h($receiver->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($receiver->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($receiver->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($receiver->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($receiver->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($receiver->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($receiver->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($receiver->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Sales') ?></h4>
        <?php if (!empty($receiver->sales)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Number') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Truck Id') ?></th>
                <th scope="col"><?= __('Taxe') ?></th>
                <th scope="col"><?= __('Discount') ?></th>
                <th scope="col"><?= __('Subtotal') ?></th>
                <th scope="col"><?= __('Charged') ?></th>
                <th scope="col"><?= __('Sortie') ?></th>
                <th scope="col"><?= __('Pointofsale Id') ?></th>
                <th scope="col"><?= __('Hidden') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Discount Type') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col"><?= __('Monnaie') ?></th>
                <th scope="col"><?= __('Charged Time') ?></th>
                <th scope="col"><?= __('Sortie Time') ?></th>
                <th scope="col"><?= __('Charged User Id') ?></th>
                <th scope="col"><?= __('Sortie User Id') ?></th>
                <th scope="col"><?= __('Transport') ?></th>
                <th scope="col"><?= __('Transport Fee') ?></th>
                <th scope="col"><?= __('Image Path') ?></th>
                <th scope="col"><?= __('Receiver Id') ?></th>
                <th scope="col"><?= __('Station Id') ?></th>
                <th scope="col"><?= __('Destination Station Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($receiver->sales as $sales): ?>
            <tr>
                <td><?= h($sales->id) ?></td>
                <td><?= h($sales->sale_number) ?></td>
                <td><?= h($sales->status) ?></td>
                <td><?= h($sales->user_id) ?></td>
                <td><?= h($sales->customer_id) ?></td>
                <td><?= h($sales->truck_id) ?></td>
                <td><?= h($sales->taxe) ?></td>
                <td><?= h($sales->discount) ?></td>
                <td><?= h($sales->subtotal) ?></td>
                <td><?= h($sales->charged) ?></td>
                <td><?= h($sales->sortie) ?></td>
                <td><?= h($sales->pointofsale_id) ?></td>
                <td><?= h($sales->hidden) ?></td>
                <td><?= h($sales->created) ?></td>
                <td><?= h($sales->modified) ?></td>
                <td><?= h($sales->discount_type) ?></td>
                <td><?= h($sales->total) ?></td>
                <td><?= h($sales->monnaie) ?></td>
                <td><?= h($sales->charged_time) ?></td>
                <td><?= h($sales->sortie_time) ?></td>
                <td><?= h($sales->charged_user_id) ?></td>
                <td><?= h($sales->sortie_user_id) ?></td>
                <td><?= h($sales->transport) ?></td>
                <td><?= h($sales->transport_fee) ?></td>
                <td><?= h($sales->image_path) ?></td>
                <td><?= h($sales->receiver_id) ?></td>
                <td><?= h($sales->station_id) ?></td>
                <td><?= h($sales->destination_station_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sales', 'action' => 'view', $sales->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sales', 'action' => 'edit', $sales->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sales', 'action' => 'delete', $sales->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sales->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
