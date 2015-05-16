<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Imgur;

//use Illuminate\Http\Request;
use Request;

use App\Upload;
use App\Output;
use App\Silhouette;

class UploadController extends Controller {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Request::all();

		$upload = new Upload($input);

		$upload->save();

		$upload_id = $upload->id;

		//$path =  $this->resizeAndSaveTempImage($upload->raw_image_url);

		$path = $this->makeHumanSizeReferenceImage($upload);
		
		if($path):
			$done = $this->uploadToImgur($path);

			$resp = $done->getData();

			$image_url = $resp['link'];

			$output = Output::create(['image_url' => $image_url, 'upload_id' => $upload_id]);

			$output->save();
			
			$this->clearTempDirectory();

			return view('uploads.index', compact('output'));
		endif;

		return "Could Not find a Human Silhouette that will accomodate your product size";

	}


	/**
	 * [makeHumanSizeReferenceImage description]
	 * @param  Upload $upload [description]
	 * @return [type]         [description]
	 */
	public function makeHumanSizeReferenceImage(Upload $upload)
	{

		// get product image url
		$original_product_image_url = $upload->raw_image_url; 
		// get product height and weight
		$upload_height = $upload->product_height_cm;
		$upload_width = $upload->product_width_cm;

		
		// convert dimensions to cm if not in cm
		$upload_height_cm = $upload_height;
		$upload_width_cm = $upload_width;

		// round the dimensions
		 
		
		
		// check if there is a silhouette where height = $height and width > $width
		$silhouette = Silhouette::where('max_height_cm', '=', $upload_height_cm)
									->where('max_width_cm', '>=', $upload_width_cm)
									->first(); 
        
        
		// if image was found - get cm-to-pixel ratio of that image
		if($silhouette) {

			// Get silhouette data
			$cm_pixel_ratio 		= $silhouette->one_cm_to_pixel_ratio;
			$offset_height_px 		= $silhouette->offset_height_px;
			$accomodating_height 	= $silhouette->max_height_cm;
			$silhouette_url 		= $silhouette->image_url;


			$expected_product_height = $accomodating_height * $cm_pixel_ratio;

			// resizeScale image to new_height
			$final_product_image = Image::make($original_product_image_url)->heighten($expected_product_height, function ($constraint) {
			    $constraint->upsize();
			});

			
			// 
			// overlay product image on silhouette offset height	
			$img = Image::make($silhouette_url)->insert($final_product_image, 'top', 0, $offset_height_px);

			$tmp_name = 'final-output-' . microtime(true) . '.jpg';

			$path = 'tmp/' . $tmp_name;

			$img->save($path);

			return $path;

		} // EO if silhouette

		return false;
	}

	/**
	 * [uploadToImgur description]
	 * @param  [type] $image_path [description]
	 * @return [type]             [description]
	 */
	public function uploadToImgur($image_path)
	{

			$imageData = array(
		        'image' => $image_path,
		        'type'  => 'file'
		    );

			$basic = Imgur::api('image')->upload($imageData);

			return $basic;

		
	}

	/**
	 * [clearTempDirectory description]
	 * @return [type] [description]
	 */
	public function clearTempDirectory()
	{
		// get all file names
		$files = glob('tmp/*'); 

		// iterate files
		foreach($files as $file) { 

			// delete file
			if(is_file($file)) unlink($file); 

		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

			// Multiple Images
		// $images = Imgur::api('gallery')->randomGalleryImages();

		// foreach ($images as $image)
		// {
		//     return '<li><img src="' . $image->getLink() . '"></li>';
		// }

		//Single Image
		// $imageId = 'I5wuDWu';

		// $image = Imgur::api('image')->image($imageId);

		// return '<img src="' . $image->getLink() . '" alt="">';

}
