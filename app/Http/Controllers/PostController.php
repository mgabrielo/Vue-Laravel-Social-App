<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use App\Models\PostAttachment;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Enums\PostReactionEnum;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try{
            $data= $request->validated();
            // dd($data);
            $user=$request->user();
            DB::beginTransaction();
            $allFilePaths=[];
            try {
                $post= Post::create($data);
                $attachments=$data['attachments'] ?? [];
                foreach ($attachments as $attachment){
                    $path = $attachment->store('attachments/'.$post->id, 'public');
                    $allFilePaths[] = $path;
                    $post_attachment= PostAttachment::create([
                        'post_id'=>$post->id,
                        'name'=>$attachment->getClientOriginalName(),
                        'mime'=>$attachment->getMimeType(),
                        'size'=>$attachment->getSize(),
                        'path'=>$path,
                        'created_by'=>$user->id, 
                    ]);
                }
                DB::commit();
            } catch (Exception $e) {
                foreach ($allFilePaths as $filePath){
                    Storage::disk('public')->delete($filePath);
                }
                DB::rollback();
            }
            return back();
        }catch(Exception $e){
            return redirect()->back()->withErrors(['error' =>'Failed to create post: ' . $e->getMessage()]);
        }
    }

    public function download(PostAttachment $attachment)
    {
        return response()->download(Storage::disk('public')->path($attachment->path), $attachment->name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $allFilePaths=[];
        try {
            $data=$request->validated();
            $post->update($data);
            $user=$request->user();
            DB::beginTransaction();
            $attachments=$data['attachments'] ?? [];
            $deleted_ids=$data['deletedFileIds'] ?? [];
            $attachments=PostAttachment::query()->where('post_id',$post->id)->whereIn('id', $deleted_ids)->get();
            if($deleted_ids){
                foreach($attachments as $attachment){
                    Storage::delete($attachment->path);
                    $attachment->delete();
                }
            }
            foreach ($data['attachments'] as $attachment){
                $path = $attachment->store('attachments/'.$post->id, 'public');
                $allFilePaths[] = $path;
                $post_attachment= PostAttachment::create([
                    'post_id'=>$post->id,
                    'name'=>$attachment->getClientOriginalName(),
                    'mime'=>$attachment->getMimeType(),
                    'size'=>$attachment->getSize(),
                    'path'=>$path,
                    'created_by'=>$user->id, 
                ]);
            }
            DB::commit();
            return back();
        } catch (Exception $e) {
            foreach ($allFilePaths as $filePath){
                Storage::disk('public')->delete($filePath);
            }
            DB::rollback();
                return redirect()->back()->withErrors(['error' =>'Failed to update post: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $id= Auth::id();
        if($post->user_id !== $id){
            return response('Not Authorized to Delete Post',403);
        }
        $post->delete();
        return back();

    }

    public function postReaction(Request $request ,Post $post)
    {
        // dd($request->all());
        $data=$request->validate([
            'reaction' => [Rule::enum(PostReactionEnum::class)]
        ]);
        try{
            $userId=Auth::id();
            $reaction=PostReaction::where('user_id', $userId)->where('post_id', $post->id)->first();
            if($reaction){
                $reaction->delete();
                $hasReaction=false;
            }else{
                PostReaction::create([
                    'post_id'=> $post->id,
                    'user_id'=> $userId,
                    'type'=> $data['reaction']
                ]);
                $hasReaction=true;
            }
            $reactions= PostReaction::where('post_id',$post->id)->count();
            return response()->json([
                'has_reaction'=>$hasReaction,
                'num_of_reactions'=>$reactions,
            ])->setStatusCode(200);
        }catch(Exception $e){
            return redirect()->back()->withErrors(['error' =>'Failed to post reaction: ' . $e->getMessage()]);
        }
    }

    public function createComment(Request $request ,Post $post){
        $data= $request->validate([
            'comment'=> ['required']
        ]);

        $comment=Comment::create([
            'post_id'=>$post->id,
            'comment'=>nl2br($data['comment']),
            'user_id'=>Auth::id(),
        ]);
        return response()->json([
            'comment'=>new CommentResource($comment)
        ])->setStatusCode(201);
    }
}
