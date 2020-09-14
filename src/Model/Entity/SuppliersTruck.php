<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SuppliersTruck Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $truck_id
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Truck $truck
 */
class SuppliersTruck extends Entity
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
        'supplier_id' => true,
        'truck_id' => true,
        'supplier' => true,
        'truck' => true, 
        'code' => true
    ];
}
