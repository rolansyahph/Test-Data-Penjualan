<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pipeline\Hub;
use Illuminate\Support\Facades\Http;

class DataPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $base_url = config('api.base_url');

            $GetData = Http::withHeaders([])->get($base_url. 'get_data_penjualan');

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        if ($GetData['status'] == 200) {
            return view('data-penjualan.index', [
                'aktif' => 'data-penjualan',
                'title' => 'Penjualan Barang',
                'values' => $GetData['data'],
                'status' => $GetData['status']
            ]);
        }
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
        try {
            $base_url = config('api.base_url');

            $InsertData = Http::withHeaders([])->post($base_url. 'input_data_penjualan', [
                'kode_barang' => $request->kode_barang,
                'jumlah_terjual' => (int)$request->jumlah_terjual
            ]);

            // return $InsertData;

            $response = $InsertData->json();

            if ($response['status'] == "success") {
                // return redirect('/users')->with('success' , $response['desc']);
                alert()->success($response['message'], '');

                return redirect()->back();
            } else {
                // return back()->with('LoginError', $response['message']);
                alert()->warning($response['message'], '');

                return redirect()->back();
            }

        } catch (\Throwable $th) {
            return $th;
            $message = $th->getMessage();
            return redirect('/error-page')->with('message', $message);
        }
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
