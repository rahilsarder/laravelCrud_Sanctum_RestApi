<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ThirdPartyAPIs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jsonPlaceHolder = new Client([
            'base_uri' => 'https->//jsonplaceholder.typicode.com/',
        ]);

        $reqres = new Client([
            'base_uri' => 'https->//reqres.in/',
        ]);

        $response = $jsonPlaceHolder->request('GET', 'posts');

        // $response = $client->request('GET', 'users');
        $JPHresponse = $jsonPlaceHolder->get('users');


        return response()->json([
            'response' => $response,
            'JPHresponse' => $JPHresponse
        ]);
        // return response()->json(json_decode($response->getBody()), Response->->HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $APPKEY = env('PORTPOS_APP_KEY');
        $SECRETKEY = env('PORTPOS_SECRET_KEY');



        $request->validate([
            'amount' => 'required',
            'product_name' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_phone' => 'required',
            'address_street' => 'required',
            'address_city' => 'required',
            'address_state' => 'required',
            'address_zipcode' => 'required',
            'address_country' => 'required',

        ]);

        $obj = [
            "order" => [
                "amount" => floatval($request->input('amount')),
                "currency" => "BDT",
                "redirect_url" => "https://troikasoft.com",
                "ipn_url" => "https://troikasoft.com/",
                "reference" => "123456789",
            ],
            "product" => [
                "name" => $request->input('product_name'),
                "description" => "Product Description",
            ],
            "billing" => [
                "customer" => [
                    "name" => $request->input('customer_name'),
                    "email" => $request->input('customer_email'),
                    "phone" => $request->input('customer_phone'),
                    "address" => [
                        "street" => $request->input('address_street'),
                        "city" => $request->input('address_city'),
                        "state" => $request->input('address_state'),
                        "zipcode" => $request->input('address_zipcode'),
                        "country" => $request->input('address_country'),
                    ],
                ],
            ]
        ];

        $token = 'Bearer ' . base64_encode($APPKEY . ':' . md5($SECRETKEY . time()));
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $token
        ];

        /// creating a client 

        $client = new Client();

        /// creating a request with endpoint followed by header and json encoded body ////
        $request = new Psr7Request('POST', 'https://api-sandbox.portwallet.com/payment/v2/invoice', $headers, json_encode($obj));

        $result = $client->send($request);

        $status_code = $result->getStatusCode();

        $response = $result->getBody();

        $invoice_id = json_decode($response)->data->invoice_id;

        if ($invoice_id) {
            return redirect('https://payment-sandbox.portwallet.com/payment/?invoice=' . $invoice_id);
        }

        return response()->json([
            'response' => json_decode($response),
            'invoice_id' => $invoice_id,
            'status_code' => $status_code

        ]);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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
