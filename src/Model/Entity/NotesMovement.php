<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotesMovement Entity
 *
 * @property int $note_id
 * @property int $movement_id
 * @property int $id
 *
 * @property \App\Model\Entity\Note $note
 * @property \App\Model\Entity\Movement $movement
 */
class NotesMovement extends Entity
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
        'note_id' => true,
        'movement_id' => true,
        'note' => true,
        'movement' => true
    ];
}
