<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Output extends Model {

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'outputs';

    /**
     * [$fillable description]
     * @var [type]
     */
	protected $fillable = [
        'image_url',
        'upload_id'
    ];

    /**
     * [uploads description]
     * @return [type] [description]
     */
    public function upload()
    {
        return $this->belongsTo('App\Upload');
    }
}
