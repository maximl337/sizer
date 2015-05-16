<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;

use Request;
use App\Silhouette;
use Imgur;

class SilhouetteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$silhouettes = Silhouette::paginate(6);

		return view('silhouettes.index', compact('silhouettes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('silhouettes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		//get request
		$input = Request::all();

		//get original path
		$image_path = $input['image_url']->getRealPath();

		//build image array to upload
		$imageData = array(
		        'image' => $image_path,
		        'type'  => 'file'
		    );

		//upload to imgur
		$basic = Imgur::api('image')->upload($imageData);

		//parse response
		$resp = $basic->getData();

		//assign new url to request
		$input['image_url'] = $resp['link'];

		//save
		$silhouette = Silhouette::create($input);

		$silhouette->save();

		// send to home
		return redirect('admin/silhouettes');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		dd($id);
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

		

		$silhouette = Silhouette::findOrFail($id);


		$silhouette->delete();

		return redirect('admin/silhouettes'); 

	}

}
