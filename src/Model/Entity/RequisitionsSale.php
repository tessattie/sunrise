<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequisitionsSale Entity
 *
 * @property int $id
 * @property int $requisition_id
 * @property int $sale_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Requisition $requisition
 * @property \App\Model\Entity\Sale $sale
 */
class RequisitionsSale extends Entity
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
        'requisition_id' => true,
        'sale_id' => true,
        'created' => true,
        'modified' => true,
        'requisition' => true,
        'sale' => true
    ];
}
