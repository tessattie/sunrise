<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrucksStation Entity
 *
 * @property int $id
 * @property int $station_id
 * @property int $truck_id
 * @property float $price
 * @property float $taxe
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\Station $station
 * @property \App\Model\Entity\Truck $truck
 * @property \App\Model\Entity\User $user
 */
class TrucksStation extends Entity
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
        'station_id' => true,
        'truck_id' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'station' => true,
        'truck' => true,
        'user' => true
    ];
}
