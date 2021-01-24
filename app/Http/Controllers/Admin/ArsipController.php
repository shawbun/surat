<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Arsip;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        return view('admin.addarsip', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_surat' => 'required',
            'title' => 'required',
            'nomor_surat' => 'required',
            'jenis_surat' => 'required',
            'category_id' => 'required',
            'file' => 'mimes:pdf|required',
        ]);

        $attributes = ([
            'tgl_surat' => date('Y-m-d', strtotime($request->tgl_surat)),
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($request->file('file')) {
            $uploadedFile = $request->file('file');
            $path = $uploadedFile->store('public/arsip');
            $attributes = array_add($attributes, 'file', $path);
        }

        Arsip::create($attributes);

        return redirect()->back()->with('success', 'Data Saving Successfully');
    }

    public function masuk(Request $request)
    {

       
            $suratmasuk = Arsip::where('jenis_surat', '=', 'Masuk')
                ->when($request->search, function ($query) use ($request) {
                    return $query->where('title', 'LIKE', "%$request->search%")
                        ->orWhere('nomor_surat', 'LIKE', "%$request->search%")
                        ->orWhere('tgl_surat', 'LIKE', "%$request->search%");
                })
                ->orderBy('created_at', 'DESC')->paginate(50);

        return view('admin.suratmasuk', compact('suratmasuk'));
    }

    public function keluar(Request $request)
    {
     
            $suratkeluar = Arsip::where('jenis_surat', '=', 'Keluar')
                ->when($request->search, function ($query) use ($request) {
                    return $query->where('title', 'LIKE', "%$request->search%")
                        ->orWhere('nomor_surat', 'LIKE', "%$request->search%")
                        ->orWhere('tgl_surat', 'LIKE', "%$request->search%");
                })
                ->orderBy('created_at', 'DESC')->paginate(50);
        

        return view('admin.suratkeluar', compact('suratkeluar'));
    }


    public function edit($id)
    {
        $arsip = Arsip::find($id);

        return view('admin.editarsip', compact('arsip'));
    }

    public function detail($id)
    {
        $arsip = Arsip::find($id);

        return view('admin.detail', compact('arsip'));
    }

    public function update(Request $request, Arsip $arsip)
    {
        $this->validate($request, [
            'tgl_surat' => 'required',
            'title' => 'required',
            'nomor_surat' => 'required',
            'jenis_surat' => 'required',
            'category_id' => 'required',
            'file' => 'mimes:pdf',
        ]);

        $attributes = ([
            'tgl_surat' => date('Y-m-d', strtotime($request->tgl_surat)),
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'category_id' => $request->category_id,
        ]);

        if ($request->file('file')) {
            $uploadedFile = $request->file('file');
            $path = $uploadedFile->store('public/arsip');
            $attributes = array_add($attributes, 'file', $path);
        }

        $arsip->update($attributes);

        return redirect('/arsip/edit/' . $arsip->id)->with('success', 'Data Update Successfully');

    }


    public function destroy(Arsip $arsip)
    {
        $arsip->delete();

        return redirect()->back()->with('success', 'Delete data successfully !');
    }
}
