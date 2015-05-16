<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model {

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'uploads';

    /**
     * [$fillable description]
     * @var [type]
     */
	protected $fillable = [
        'raw_image_url',
        'product_width_cm',
        'product_height_cm',
        'ip',
        'user_id'
    ];

    /**
     * [outputs description]
     * @return [type] [description]
     */
    public function outputs()
    {
        return $this->hasMany('App\Output');
    }
}
