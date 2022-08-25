<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tracking Entity
 *
 * @property int $id
 * @property int $products_sale_id
 * @property int|null $flight_id
 * @property int $movement_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $station_id
 * @property string|null $comment
 *
 * @property \App\Model\Entity\ProductsSale $products_sale
 * @property \App\Model\Entity\Flight $flight
 * @property \App\Model\Entity\Movement $movement
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Station $station
 */
class Tracking extends Entity
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
        'products_sale_id' => true,
        'flight_id' => true,
        'movement_id' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'station_id' => true,
        'comment' => true,
        'products_sale' => true,
        'flight' => true,
        'movement' => true,
        'user' => true,
        'station' => true
    ];
}
