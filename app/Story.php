<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * Story
 *
 * Model for story page.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 */
class Story extends Model
{
    use SoftDeletes;
    use Features\EditLockFeature;
    use Features\ImageFeature;
    use Features\LikeFeature;
    use Features\TagFeature;
    use Features\TransferFeature;
    use Features\TranslationFeature;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'locked_at'];

    /**
     * Dynamic properties that should be included in toArray() or toJSON().
     *
     * @var array
     */
    protected $appends = ['title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image_id', 'user_id', 'tag_ids'];

    /**
     * Children properties that should be transfered with parent. Key is property
     * name and value is boolean: if the child is a collection.
     *
     * @var array
     */
    protected $transfer_children = ['images' => true];

    //====================================================================
    // Management Methods
    //====================================================================

    /**
     * Soft delete with relationships.
     */
    public function deleteWithRelationships()
    {
        $this->delete();
    }

    /**
     * Restore with relationships.
     */
    public function restoreWithRelationships()
    {
        $this->restore();
    }

    /**
     * Hard delete with relationships.
     */
    public function forceDeleteWithRelationships()
    {
        // Hard delete images with files
        foreach ($this->images as $image) {
            $image->deleteWithFiles();
        }

        // Hard delete likes
        $this->likes()->delete();

        // Detach tags
        $this->tags()->detach();

        $this->forceDelete();
    }


    //====================================================================
    // Relationship Methods
    //====================================================================

    /**
     * Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    //====================================================================
    // Dynamic Properties
    //====================================================================

    /**
     * "title" getter.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->text('title');
    }

    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('story/' . $this->id);
    }

    /**
     * "edit_url" getter.
     *
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return url('story/' . $this->id . '/edit');
    }


    //====================================================================
    // Other Methods
    //====================================================================

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // Load relationships
        $this->load('translations', 'tags.translations', 'user');

        // Generate array data
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    //====================================================================
    // Static Functions
    //====================================================================


}
