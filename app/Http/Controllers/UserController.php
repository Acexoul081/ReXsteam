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
    public function sessionAge(Request $request){
        session()->put('age_verified', $request->datebirth);
        return back();
    }
    public function getFriend(User $user){
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
        $accepted = [];
        foreach($friends_accepted as $c){
            $accepted[] = $c->user;
        }
        foreach($friends as $c){
            $accepted[] = $c->friend;
        }
        $friends = $accepted;
        $active = "friends";
        return view('friend', compact('friends', 'incomings', 'pendings', 'active'));
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
        $active = 'transaction';
        return view('history', compact('transactions', 'active'));
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
        $active = 'profile';
        return view('profile', compact('user', 'active'));
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
        $request->validate([
            'fullname' => 'required',
            'curr_pass' => 'required|alpha_num|min:6',
            'new_pass' => 'nullable|confirmed|alpha_num|min:6',
            'image' => 'file|mimes:image/jpg,image/png|max:100'
        ]);

        if($request->curr_pass !== null){
            if($user && Hash::check($request->curr_pass, $user->password)){
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
                if($request->new_pass !== ''){
                    $user->password = Hash::make($request->new_pass);  
                }
                $user->save();
            }
        }
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
