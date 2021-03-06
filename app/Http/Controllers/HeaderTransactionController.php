<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailTransactionRequest;
use App\Models\HeaderTransaction;
use App\Http\Requests\StoreHeaderTransactionRequest;
use App\Http\Requests\UpdateHeaderTransactionRequest;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class HeaderTransactionController extends Controller
{
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
        $cart = (new CartController)->getCart();
        return view('create_transaction', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHeaderTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHeaderTransactionRequest $request)
    {
        $request->validate([
            'card_name' => ['required','string','min:6'],
            'card_number' => ['required','string','size:19',
                function($attribute, $value, $fail){
                    for ($i = 0; $i < strlen($value); $i++){
                        if($i == 4 || $i == 9 || $i == 14){
                            if($value[$i] !== ' '){
                                $fail("The ".$attribute." format '0000 0000 0000 0000'");
                            }
                        }
                        else{
                            if(!is_numeric($value[$i])){
                                $fail("The ".$attribute." has value that is not number in a number-required place");
                            }
                        }
                    }
                }
            ],
            'month' => ['required', 'integer','between:1,12'],
            'year' => ['required', 'integer','between:2021,2050'],
            'cvc' => ['required', 'numeric', 'digits_between:3,4'],
            'country' => ['required'],
            'zip' => ['required', 'numeric']
        ]);

        $cart = (new CartController)->getCart();
        // dd(Auth::user());
        $header = new HeaderTransaction();
        $header->id = Uuid::uuid4()->toString();
        $header->user_id = Auth::user()->id;
        $header->card_name = $request->card_name;
        $header->card_number = $request->card_number;
        $header->month = $request->month;
        $header->year = $request->year;
        $header->cvc_cvv = $request->cvc;
        $header->card_country = $request->country;
        $header->zip = $request->zip;
        
        $detail_req = new StoreDetailTransactionRequest();
        $detail_req->merge(['transaction_id' => $header->id]);
        $detail_req->merge(['cart' => $cart]);
        $header->save();
        (new DetailTransactionController)->store($detail_req);
        (new CartController)->clear();
        //alihkan ke halaman transaction
        return view('transaction', compact('cart', 'header'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeaderTransaction  $headerTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(HeaderTransaction $headerTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeaderTransaction  $headerTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(HeaderTransaction $headerTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHeaderTransactionRequest  $request
     * @param  \App\Models\HeaderTransaction  $headerTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHeaderTransactionRequest $request, HeaderTransaction $headerTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeaderTransaction  $headerTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeaderTransaction $headerTransaction)
    {
        //
    }
}
