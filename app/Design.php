<?php

namespace App;

use App\Localization\Currencies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Design extends Model
{
    use SoftDeletes;
    use Features\EditLockFeature;
    use Features\ImageFeature;
    use Features\LikeFeature;
    use Features\TagFeature;
    use Features\TransferFeature;
    use Features\TranslationFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'design';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id', 'tag_ids', 'gallery_image_ids', 'webshop',
        'price', 'currency', 'taobao', 'taobao_price',
    ];

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
    protected $appends = ['name', 'url'];

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
    // Relationship
    //====================================================================

    public function designer()
    {
        return $this->belongsTo('App\Designer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    //====================================================================
    // Dynamic Attributes
    //====================================================================

    /**
     * "name" getter.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->text('name');
    }

    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('design/' . $this->id);
    }

    //====================================================================
    // Others
    //====================================================================

    public function updateEuroPrice()
    {
        if (!empty($this->price) && !empty($this->currency)) {
            $this->eur_price = Currencies::euro($this->price, $this->currency);
        }
    }
}
