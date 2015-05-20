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
	public function store(Requests\UploadRequest $request)
	{
		// Handle raw upload
		$input = $request->all();

		$output = [];
		
		if($request->hasFile('image')) {

			//get original path
			$image_path = $input['image']->getRealPath();
		
		    //upload to imgur
			$imgur_url = $this->uploadToImgur($image_path);

			//assign new url to request
			$input['raw_image_url'] = $imgur_url; 

			
		} 

		// format dimensions
		$dimensions = $this->formatDimensions($input['units'], $input['product_height_cm'], $input['product_width_cm']);

		$input['product_height_cm'] = $dimensions['product_height_cm'];

		$input['product_width_cm'] = $dimensions['product_width_cm'];

		$upload = new Upload($input);

		$upload->save();

		$upload_id = $upload->id;
				
		// format image ( if jpeg -> convert to png)

		//get the completed image
		$path = $this->makeHumanSizeReferenceImage($upload);

		
		if($path):

			$image_url = $this->uploadToImgur($path);

			$output = Output::create(['image_url' => $image_url, 'upload_id' => $upload_id]);

			$output->save();
			
			$this->clearTempDirectory();

			return view('uploads.index', compact('output'));

		endif;

		$messages = array(
		    'required' => 'Could not find a silhouette that can accomodate your product size',
		);

		return redirect('/')->withErrors($messages);

		//return "Could Not find a Human Silhouette that will accomodate your product size";

	}

	private function formatDimensions($unit, $height, $width)
	{

		// if inches are selected then convert to cm
		if($unit == 'in') {

			$height *= 2.54; 

			$width *= 2.54;
		}

		return [
			'product_height_cm' => round($height),
			'product_width_cm' => round($width),
		];

	}

	/**
	 * [makeHumanSizeReferenceImage description]
	 * @param  Upload $upload [description]
	 * @return [type]         [description]
	 */
	private function makeHumanSizeReferenceImage(Upload $upload)
	{
		
		$original_product_image_url = $upload->raw_image_url;

		// get product height and weight
		$upload_height_cm = $upload->product_height_cm;
		$upload_width_cm = $upload->product_width_cm;
		
		
		// check if there is a silhouette where height = $height and width > $width
		$silhouette = Silhouette::where('max_height_cm', '=', $upload_height_cm)
								->where('max_width_cm', '>=', $upload_width_cm)
								->first(); 

		// format and return image						
		return $this->imageOutputHandler($silhouette, $original_product_image_url);


	}

	private function imageOutputHandler($silhouette, $original_product_image_url)
	{

		if(empty($silhouette)) return false;
		
		if(empty($original_product_image_url)) return false;

		// Get silhouette data
		$cm_pixel_ratio 		= $silhouette->one_cm_to_pixel_ratio;
		$offset_height_px 		= $silhouette->offset_height_px;
		$accomodating_height 	= $silhouette->max_height_cm;
		$silhouette_url 		= $silhouette->image_url;


		$expected_product_height = $accomodating_height * $cm_pixel_ratio;
		
		// resizeScale image to new_height
		$final_product_image = Image::make($original_product_image_url)->heighten($expected_product_height);

		// overlay product image on silhouette offset height	
		$img = Image::make($silhouette_url)->insert($final_product_image, 'top', 0, $offset_height_px);

		// save image to tmp to be uploaded to imgur
		$tmp_name = 'final-output-' . microtime(true) . '.jpg';

		$path = 'tmp/' . $tmp_name;

		$img->save($path);

		return $path;
	}

	/**
	 * [uploadToImgur description]
	 * @param  [type] $image_path [description]
	 * @return [url]             [return link from imgur upload]
	 */
	private function uploadToImgur($image_path)
	{

		$imageData = array(
	        'image' => $image_path,
	        'type'  => 'file'
	    );

		$basic = Imgur::api('image')->upload($imageData);

		//parse response
		$resp = $basic->getData();

		return $resp['link'];
	}

	/**
	 * [clearTempDirectory description]
	 * @return [type] [description]
	 */
	private function clearTempDirectory()
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
