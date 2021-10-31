<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use DB;

class ArticleController extends Controller
{
    public function create()
    {
        return view('admin.article.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'topic' => 'required',
            'article' => 'required',
            'picture' => 'mimes:jpeg,jpg,png|max:2200'
        ]);

        $picture = $request->picture;
        $new_picture = time() . ' - ' . $picture->getClientOriginalName();


        Article::create([
            "name" => $request["name"],
            "topic" => $request["topic"],
            "article" => $request["article"],
            "picture" => $new_picture
        ]);

        $picture->move('img-upload/', $new_picture);

        return redirect('/admin/list-article')->with('success', 'Data submission successful!');
    }

    public function index()
    {
        $articles = Article::all();
        return view('admin.article.list', compact('articles'));
    }

    // public function show($id) {
    //     $submission = DB::table('submission')->where('id', $id)->first();
    //     return view('admin.show',compact('submission'));
    // }

    public function edit($id) {
        $article = Article::find($id)->first();
        return view('admin.article.edit',compact('article'));
    }

    public function update($id, Request $request) {
        $request->validate([
            'name' => 'required',
            'topic' => 'required',
            'article' => 'required',
            'picture' => 'mimes:jpeg,jpg,png|max:2200'
        ]);

        $article = Article::findorfail($id);
        if ($request->has('picture')) {
            File::delete("img-upload/".$article->picture);
            $picture = $request->picture;
            $new_picture = time() . ' - ' . $picture->getClientOriginalName();
            $picture->move('img-upload/', $new_picture);
            $article_data = [
                "name" => $request["name"],
                "topic" => $request["topic"],
                "article" => $request["article"],
                "picture" => $new_picture
            ];
        } else {
            $article_data = [
                "name" => $request["name"],
                "topic" => $request["topic"],
                "article" => $request["article"]
            ];
        }
        
        $article->update($article_data);

        return redirect('/admin/list-article')->with('success', 'Submission successfully updated!');
    }

    public function destroy($id) {
        $submission = DB::table('articles')->where('id', $id)->delete();
        return redirect('/admin/list-article')->with('success', 'Submission successfully deleted!');
    }

    public function upload($id) {
        $article = Article::where('id',$id)->first();
        return view('layouts.article_content',compact('article')); 
    }

    public function list_content() {
        $articles = Article::all();
        return view('layouts.article',compact('articles')); 
    }

    
}
