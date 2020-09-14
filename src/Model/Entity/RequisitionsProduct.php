<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequisitionsProduct Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $requisition_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Requisition $requisition
 */
class RequisitionsProduct extends Entity
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
        'product_id' => true,
        'requisition_id' => true,
        'quantity' => true,
        'created' => true,
        'modified' => true,
        'product' => true,
        'used' => true,
        'requisition' => true
    ];
}
