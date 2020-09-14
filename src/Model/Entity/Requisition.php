<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requisition Entity
 *
 * @property int $id
 * @property string|null $photo
 * @property int $customer_id
 * @property string $uid
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Sale[] $sales
 */
class Requisition extends Entity
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
        'photo' => true,
        'customer_id' => true,
        'uid' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'customer' => true,
        'user' => true,
        'products' => true,
        'sales' => true
    ];
}
