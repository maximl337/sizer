<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Silhouette extends Model {

    /**
     * [$table description]
     * @var string
     */
	protected $table = 'silhouettes';

    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [

        'image_url',
        'max_height_cm',
        'max_width_cm',
        'offset_height_px'

    ];

}
