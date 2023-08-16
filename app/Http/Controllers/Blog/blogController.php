<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\Models\Blog\Blogmodel;
use App\Models\Blog\BlogOption;

use File;

class blogController extends Controller
{
    public function bologpost(request $request)
    {
        // return $request->all();
        $prefix = 'blog_';
        $randomNumber = rand(1000, 9999);
        $blogid = $prefix . $randomNumber;

        // return "Hello";
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $file = $request->file('blogImage');
        // return $file;
        $image = $file->getClientOriginalName();
        // return $image;
        $imagePath = '/assets/profile/' . $image;
        // return $imagePath;

        $file->move(public_path('/assets/profile'), $image);
        $imageUrl = url($imagePath);
        // return $imageUrl;

        if (file_exists(public_path($image =  $file->getClientOriginalName()))) {
            unlink(public_path($image));
        };


        $blog = Blogmodel::create([
            'blogid'=>$blogid,
            'hastag'=>$request->input('hastag'),
            'blogTitle'=>$request->input('blogTitle'),
            'blogDescription'=>$request->input('blogDescription'),
            'blogImage'=>$image,
            'blogQuestion'=>$request->input('blogQuestion'),
        ]);

        $lastInsertedBlogId = $blog->blogid; // Access the 'blogid' property of the newly created blog entry

        $options = [
            $request->input('blogoption_one'),
            $request->input('blogoption_two'),
            $request->input('blogoption_three'),
            $request->input('blogoption_four')
        ];

        for ($i = 0; $i < count($options); $i++) {
            Blogoption::create([
                'blogid' => $lastInsertedBlogId,
                'blogoption' => $options[$i],
            ]);
        }
        return response()->json(['status'=>true, 'message'=>'Your blog has been uploaded']);
    }

    

    public function bologGet()
    {
        $blogs = Blogmodel::select('blogid', 'hastag', 'blogTitle', 'blogDescription', 'blogImage', 'blogQuestion')->get();

        $blogData = [];
        foreach ($blogs as $blog) {
            $newUrl = "http://127.0.0.1:8000/assets/profile/" . $blog->blogImage;

            $blogData[] = [
                'blogid'          => $blog->blogid,
                'hastag'          => $blog->hastag,
                'blogTitle'       => $blog->blogTitle,
                'blogDescription' => $blog->blogDescription,
                'blogImage'       => $newUrl,
            ];
        }

        return response()->json(['status' => true, 'data' => $blogData]);
    }


    public function blogoptionget($blogid)
    {
        $select_option = Blogoption::select('*')->where('blogid',$blogid)->get();
        $select_question = Blogmodel::select('blogQuestion')->where('blogid',$blogid)->first();
        return response()->json(['status'=>true, 'question'=>$select_question, 'data'=>$select_option]);
    }

    public function blogGetById($blogid)
    {
        // return "hhhhhh";
        $blogGetById = Blogmodel::select('*')->where('blogid',$blogid)->get();
        return response()->json(['status'=>true, 'data'=>$blogGetById]);
    }


    public function submitVote(Request $request){
        // return "poole ans";
        $validatedData = $request->validate([
            'option_id' => 'required|exists:blog_options,id',
        ]);

        // Find the option and update its vote_count
        $option = Blogoption::find($validatedData['option_id']);
        $option->vote_count += 1;
        $option->save();

        return response()->json(['message' => 'Vote submitted successfully']);
    }
}
