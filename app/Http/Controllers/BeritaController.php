<?php namespace App\Http\Controllers;

use App\File;
use App\Post;
use App\Services\MimeTypeGuesser;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Pagination;

class BeritaController extends Controller {

	/**
	 * Display posts listing.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::orderBy('created_at', 'desc')->get();
		return view('inside.berita', compact('posts'));
	}

	/**
	 * Store a newly created post in storage.
	 *
	 * @param Request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$br = $request->only(['title', 'post']);
		if ($br['title'] == "" || $br['post'] == "") {
			return redirect('berita')
				->with('alert', ['alert' => 'warning', 'body' => 'Gagal membuat berita.']);
		}
		$post = Post::create($br);

		$uploadedFile = $request->file('file');
		if ($uploadedFile != null) {
			$ext = $uploadedFile->getClientOriginalExtension();
			$saved_name = time() . '.' . $ext;
			$uploadedFile->move(storage_path() . '/upload', $saved_name);

			// we should save this file information in database
			$name = $uploadedFile->getClientOriginalName();
			$ext = $uploadedFile->getClientOriginalExtension();
			$mime = (new MimeTypeGuesser)->guess($ext);
			$size = $uploadedFile->getClientSize();
			$post_id = $post->id;

			$file = compact('saved_name', 'name', 'mime', 'size', 'post_id');
			$file = new File($file);
			// dd($file);
			$file->save();
		}

		return redirect('berita')
			->with('alert', ['alert' => 'info', 'body' => 'Berhasil membuat berita.']);
	}


	/**
	 * Update the post.
	 *
	 * @param  Request
	 * @return Response
	 */
	public function update(Request $request) {
		$post = Post::find($request->input('id'));
		if ($post == null) {
			return redirect('berita')
				->with('alert', ['alert' => 'warning', 'body' => 'Gagal mengubah berita.']);
		}

		$br = $request->only(['title', 'post']);
		if ($br['title'] == "" || $br['post'] == "") {
			return redirect('berita')
				->with('alert', ['alert' => 'warning', 'body' => 'Gagal mengubah berita.']);
		}

		$post->fill($br);
		$post->save();
		return redirect('berita')
			->with('alert', ['alert' => 'info', 'body' => 'Berhasil mengubah berita.']);
	}

	/**
	 * Remove the post from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$post = Post::find($id);

		if ($post->file != null) {
			$post->file->delete();
		}

		$post->delete();

		return redirect('berita')
			->with('alert', ['alert' => 'info', 'body' => 'Berhasil menghapus berita.']);
	}

}
