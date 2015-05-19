<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class uploadRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'raw_image_url' 	=> 'required_without_all:image',
    		'image' 			=> 'required_without_all:raw_image_url',
			'original_link'		=>	'product_height_cm',
			'provider_id'		=>	'product_width_cm',
		];
	}

}
