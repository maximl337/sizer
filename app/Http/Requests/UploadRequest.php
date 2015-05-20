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
			'raw_image_url' 		=> 'required_without_all:image',
    		'image' 				=> 'required_without_all:raw_image_url|image|max:20000',
			'product_height_cm'		=>	'required|numeric',
			'product_width_cm'		=>	'required|numeric',
		];
	}

	public function messages()
	{
	    return [
	        'raw_image_url.required_without_all' => 'Please add an image URL or an image',
	        'image.required_without_all' => 'Please add an image or an image URL',
	        'product_height_cm.required' => 'Please add the product height',
	        'product_width_cm.required' => 'Please add the product width',
	        'image.max' => 'Image cannot be greater than 20 MB'

	    ];
	}

}
