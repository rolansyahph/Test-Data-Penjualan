<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pipeline\Hub;
use Illuminate\Support\Facades\Http;

class MasterBarangController extends Controller
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

            $GetData = Http::withHeaders([])->get($base_url. 'get_data_barang');

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        if ($GetData['status'] == 200) {
            return view('master-barang.index', [
                'aktif' => 'data-barang',
                'title' => 'Master Barang',
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
        return view('master-barang.create', [
            'aktif' => '/',
            'title' => 'Tambah Barang',
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
        try {
            $base_url = config('api.base_url');

            $InsertData = Http::withHeaders([])->post($base_url. 'input_data_barang', [
                'nama_barang' => $request->nama_barang,
                'stok' => (int)$request->stok,
                'satuan' => $request->satuan,
                'jenis_barang' => $request->jenis_barang
            ]);

            // return $InsertData;

            $response = $InsertData->json();

            if ($response['status'] == 200) {
                // return redirect('/users')->with('success' , $response['desc']);
                // alert()->success($response['message'], '');

                return redirect()->back();
            } else {
                // return back()->with('LoginError', $response['message']);
                // alert()->warning($response['message'], '');

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
    public function update(Request $request)
    {
        $base_url = config('api.base_url') . "update_data_barang";
        try {
            // return $request->kode_barang;
            $Update = Http::withHeaders([])->post($base_url, [
                'kode_barang' => $request->kode_barang,
                'stok' => (int)$request->stok
            ]);

            if ($Update['status'] == "200") {
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            // return $th;
            $message = $th->getMessage();
            return redirect('/error-page')->with('message', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        {
            $base_url = config('api.base_url') . "hapus_data_barang";
            try {
                // return $request->kode_barang;
                $Delete = Http::withHeaders([])->post($base_url, [
                    'kode_barang' => $request->kode_barang
                ]);

                // return $Delete;

                if ($Delete['status'] == "200") {
                    return redirect()->back();
                } else {
                    return redirect()->back();
                }
            } catch (\Throwable $th) {
                return $th;
                $message = $th->getMessage();
                return redirect('/error-page')->with('message', $message);
            }
        }
    }
}
