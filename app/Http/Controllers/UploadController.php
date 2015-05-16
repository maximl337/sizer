<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Imgur;

//use Illuminate\Http\Request;
use Request;

use App\Upload;
use App\Output;

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

		$path =  $this->resizeAndSaveTempImage($upload->raw_image_url);
		
		$done = $this->uploadToImgur($path);

		$resp = $done->getData();

		$image_url = $resp['link'];

		$output = Output::create(['image_url' => $image_url, 'upload_id' => $upload_id]);

		$output->save();
		
		$this->clearTempDirectory();

		return view('uploads.index', compact('output'));

	}

	/**
	 * [resizeImage description]
	 * @param  [type] $image_url [description]
	 * @return [type]            [description]
	 */
	public function resizeAndSaveTempImage($image_url)
	{

		
		$img = Image::make($image_url)->insert('http://i.imgur.com/Ned0D1ub.jpg', 'top', 130, 330);

		$tmp_name = 'final-output-' . microtime(true) . '.jpg';

		$path = 'tmp/' . $tmp_name;

		$img->save($path);

		return $path;
		
    	
	}

	public function convertHeightToPixels($value='')
	{
		# code...
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
