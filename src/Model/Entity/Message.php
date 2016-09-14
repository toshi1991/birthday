<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $comment
 * @property \Cake\I18n\Time $craeted
 * @property \Cake\I18n\Time $modified
 * @property int $del_flg
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Image[] $images
 * @property \App\Model\Entity\Movie[] $movies
 */
class Message extends Entity
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
        '*' => true,
        'id' => false
    ];
}
