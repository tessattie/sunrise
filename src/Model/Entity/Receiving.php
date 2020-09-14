<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Receiving Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $status
 * @property int $truck_id
 * @property int $supplier_id
 * @property float $quantity
 * @property float $cost
 * @property int $item
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Truck $truck
 * @property \App\Model\Entity\Supplier $supplier
 */
class Receiving extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'created' => true,
        'modified' => true,
        'receiving_number' => true,
        'user_id' => true,
        'status' => true,
        'truck_id' => true,
        'supplier_id' => true,
        'quantity' => true,
        'cost' => true,
        'item' => true,
        'user' => true,
        'truck' => true,
        'supplier' => true,
        'type' => true
    ];
}
