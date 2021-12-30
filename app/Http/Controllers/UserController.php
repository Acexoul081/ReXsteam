<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getFriend(User $user){
        // dd($user->friends->toArray());
        //https://stackoverflow.com/questions/61410592/laravel-filter-array-based-on-element-value
        $friends_incoming = Friend::where(
            'friend_id', $user->id
        );
        $friends_incoming = $friends_incoming->get();
        $incomings = $friends_incoming->filter(function ($item) {
            return $item->status === 'pending';
        });
        $friends_accepted = $friends_incoming->filter(function ($item) {
            return $item->status === 'accepted';
        });
        $pendings = $user->friends->filter(function ($item) {
            return $item->status === 'pending';
        });
        $friends = $user->friends->filter(function ($item) {
            return $item->status === 'accepted';
        });

        // $friends = Arr::where($user->friends->toArray(), function ($value, $key) {
        //     return $value['status'] === 'accepted';
        // });
        $accepted = [];
        foreach($friends_accepted as $c){
            $accepted[] = $c->user;
        }
        foreach($friends as $c){
            $accepted[] = $c->friend;
        }
        $friends = $accepted;
        return view('friend', compact('friends', 'incomings', 'pendings'));
    }

    public function cancelFriend(Request $request, User $user){
        Friend::where('user_id', $user->id)->where('friend_id', $request->id)->delete();
        return back();
    }

    public function responseFriend(Request $request, User $user){
        if(isset($request->accept)){
            Friend::where('user_id', $request->accept)->where('friend_id', $user->id)->update(['status' => 'accepted']);
        }else if(isset($request->reject)){
            Friend::where('user_id', $request->reject)->where('friend_id', $user->id)->update(['status' => 'rejected']);
        }
        return back();
    }

    public function rejectFriend(Request $request, User $user){
        $friend_request = Friend::where('user_id', $request->id)->where('friend_id', $user->id)->first();
        $friend_request->status = "rejected";
        $friend_request->save();
        return back();
    }

    public function getTransaction(User $user){
        // dd($user->transactions[0]->games);
        $transactions = $user->transactions;
        return view('history', compact('transactions'));
    }

    public function addFriend(Request $request, User $user){
        //validasi validasi tambah
        $friend = DB::table('users');
        $friend->where(
            'username', '=', $request->name,
        );
        $friend = $friend->first();
        $friend_req = new Friend();
        $friend_req->user_id = $user->id;
        $friend_req->friend_id = $friend->id;
        $friend_req->status = "pending";
        $friend_req->save();
        return back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($user->fullname !== $request->fullname){
            $user->fullname = $request->fullname;
        }
        if($user->username !== $request->username){
            $user->username = $request->username;
        }
        if($user->level !== $request->level){
            $user->level = $request->level;
        }
        if($request->file('image')!==null){
            $img_path = $request->file('image')->store('public/images');
            $user->image = $img_path;
        }
        if($request->curr_pass !== null){
            if(Hash::check($request->password, $user->password)){
                $user->password = Hash::make($request->new_pass);
            }
        }
        $user->save();
        return back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
