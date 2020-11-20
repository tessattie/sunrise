<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Station $station
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Station'), ['action' => 'edit', $station->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Station'), ['action' => 'delete', $station->id], ['confirm' => __('Are you sure you want to delete # {0}?', $station->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Station'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stations view large-9 medium-8 columns content">
    <h3><?= h($station->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($station->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($station->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Sales') ?></h4>
        <?php if (!empty($station->sales)): ?>
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
            <?php foreach ($station->sales as $sales): ?>
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
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($station->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Role Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Remember Token') ?></th>
                <th scope="col"><?= __('Station Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($station->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->first_name) ?></td>
                <td><?= h($users->last_name) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->role_id) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td><?= h($users->status) ?></td>
                <td><?= h($users->remember_token) ?></td>
                <td><?= h($users->station_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
