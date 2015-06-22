<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Post;
use App\Lecturer; // ini testing doang
use Carbon\Carbon;

class BeritaController extends Controller {

	public function index()
	{
		$posts = Post::orderBy('created_at', 'desc')->get();
		return view('inside.berita', compact('posts'));
	}

	public function store(Request $request)
	{
		$br = $request->all();
		Post::create($br);
		return redirect('berita');
	}

}