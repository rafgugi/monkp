<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\File;
use App\Post;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BeritaController extends Controller {

	public function index()
	{
		$posts = Post::orderBy('created_at', 'desc')->get();
		return view('inside.berita', compact('posts'));
	}

	public function store(Request $request)
	{
		$br = $request->only(['title', 'post']);
		$post = Post::create($br);

		$uploadedFile = $request->file('file');
		if ($uploadedFile != null) {
			// $this->attach($uploadedFile);
			$ext = $uploadedFile->getClientOriginalExtension();
			$saved_name = str_random(20) . '.' . $ext;
			$uploadedFile->move(storage_path() . '/upload', $saved_name);

			// we should save this file information in database
			$name = $uploadedFile->getClientOriginalName();
			$mime = $uploadedFile->getClientMimeType();
			$size = $uploadedFile->getClientSize();
			$post_id = $post->id;

			$file = compact('saved_name', 'name', 'mime', 'size', 'post_id');
			$file = new File($file);
			// dd($file);
			$file->save();
		}

		return redirect('berita');
	}

	public function file($id)
	{
		return File::find($id)->binary();
	}
}
