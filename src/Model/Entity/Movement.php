<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movement Entity
 *
 * @property int $id
 * @property float $montant
 * @property int $user_id
 * @property int $method_id
 * @property int $currency_id
 * @property string $type
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime $date
 * @property float $balance
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 * @property string $comment
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Method $method
 * @property \App\Model\Entity\Currency $currency
 * @property \App\Model\Entity\NotesChest[] $notes_chests
 */
class Movement extends Entity
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
        'montant' => true,
        'user_id' => true,
        'method_id' => true,
        'currency_id' => true,
        'type' => true,
        'description' => true,
        'date' => true,
        'balance' => true,
        'created' => true,
        'modified' => true,
        'deleted_at' => true,
        'comment' => true,
        'user' => true,
        'method' => true,
        'currency' => true,
        'notes_chests' => true
    ];
}
