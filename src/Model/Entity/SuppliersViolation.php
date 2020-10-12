<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SuppliersViolation Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $violation_id
 * @property float $price
 *
 * @property \App\Model\Entity\Violation $violation
 * @property \App\Model\Entity\Supplier $supplier
 */
class SuppliersViolation extends Entity
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
        'violation_id' => true,
        'supplier_id' => true,
        'price' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true
    ];
}
