<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotesChestsFixture
 */
class NotesChestsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'note_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'movement_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        '_indexes' => [
            'motif_coffre_coffre_transaction_id_foreign' => ['type' => 'index', 'columns' => ['movement_id'], 'length' => []],
            'motif_coffre_motif_id_foreign' => ['type' => 'index', 'columns' => ['note_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'motif_coffre_coffre_transaction_id_foreign' => ['type' => 'foreign', 'columns' => ['movement_id'], 'references' => ['movements', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
            'motif_coffre_motif_id_foreign' => ['type' => 'foreign', 'columns' => ['note_id'], 'references' => ['notes', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'note_id' => 1,
                'movement_id' => 1,
                'id' => 1
            ],
        ];
        parent::init();
    }
}
