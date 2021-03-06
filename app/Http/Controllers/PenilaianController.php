<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenilaianForm;
use App\Models\Penilaian;
use App\Models\Role;
use App\Models\SatkerPenilaian;
use Illuminate\Support\Facades\Gate;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_VIEW_PENILAIAN)) {
            return redirect('/home')->with('message-error', 'Sorry, access restricted');
        }

        return view('penilaian.index', ['penilaian' => SatkerPenilaian::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_CREATE_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        return view('penilaian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PenilaianForm $request)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_CREATE_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $satker = SatkerPenilaian::create($validated);

        $data = [];
        foreach (Penilaian::getItemPenilaian() as $index => $item) {
            if ($index === 0) {
                continue;
            }
            $data[] = [
                'satker_penilaian_id' => $satker->id,
                'grup_penilaian' => $item['grup'],
                'sub_grup_penilaian' => $item['subgrup'],
                'item_penilaian_id' => $index,
                'item_penilaian_judul' => $item['judul'],
            ];
        }
        Penilaian::insert($data);

        return redirect('/penilaian/'.$satker->id)->with('message-success', 'Penilaian berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_SHOW_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        return view('penilaian.show', [
            'penilaian' => $penilaian,
            'item' => Penilaian::getItemPenilaianSatker($penilaian->id),
            'kelengkapan' => Penilaian::getAllKelengkapan(),
            'tingkat' => Penilaian::getAllTingkatKelengkapan(),
            'grup' => Penilaian::getGrupPenilaian(),
            'subgrup' => Penilaian::getSubGrupPenilaian(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        return view('penilaian.edit', ['penilaian' => $penilaian]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PenilaianForm $request, SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $penilaian->nama_unit_kerja = $validated['nama_unit_kerja'];
        $penilaian->petugas_pendampingan = $validated['petugas_pendampingan'];

        $penilaian->save();

        return redirect('/penilaian')->with('message-success', 'Penilaian updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_DELETE_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        $penilaian->delete();

        return redirect('/penilaian')->with('message-success', 'Penilaian deleted successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeItem(PenilaianForm $request, SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_ADD_ITEM_PENILAIAN)) {
            return redirect('/penilaian/'.$penilaian->id)->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $validated['satker_penilaian_id'] = $penilaian->id;

        Penilaian::create($validated);

        return redirect('/penilaian/'.$penilaian->id)->with('message-success', 'Item created successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addItem(SatkerPenilaian $penilaian)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_ADD_ITEM_PENILAIAN)) {
            return redirect('/penilaian/'.$penilaian->id)->with('message-error', 'Sorry, access restricted');
        }

        //return view('penilaian.add-item', ['penilaian' => $penilaian, 'grup' => Role::getGrupPenilaian(), 'subgrup' => Role::getSubGrupPenilaian()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editItem(SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_ITEM_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateItem(PenilaianForm $request, SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_PENILAIAN)) {
            return redirect('/penilaian')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $penilaian->nama_unit_kerja = $validated['nama_unit_kerja'];
        $penilaian->petugas_pendampingan = $validated['petugas_pendampingan'];

        $penilaian->save();

        return redirect('/penilaian')->with('message-success', 'Penilaian updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(PenilaianForm $request, SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_ITEM_PENILAIAN)) {
            return redirect('/penilaian/')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $item->kelengkapan = $validated['kelengkapan'];
        $item->tingkat_kelengkapan = $validated['tingkat_kelengkapan'];

        $item->save();

        return redirect('/penilaian/'.$penilaian->id)->with('message-success', 'Status Dokumen berhasil diupdate');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateKelengkapan(PenilaianForm $request, SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_ITEM_PENILAIAN)) {
            return redirect('/penilaian/')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $item->kelengkapan = $validated['kelengkapan'];

        $item->save();

        return redirect('/penilaian/'.$penilaian->id)->with('message-success', 'Kelengkapan berhasil diupdate');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTingkat(PenilaianForm $request, SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_ITEM_PENILAIAN)) {
            return redirect('/penilaian/')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $item->tingkat_kelengkapan = $validated['tingkat_kelengkapan'];

        $item->save();

        return redirect('/penilaian/'.$penilaian->id)->with('message-success', 'Kelengkapan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(SatkerPenilaian $penilaian, Penilaian $item)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_DELETE_ITEM_PENILAIAN)) {
            return redirect('/penilaian/'.$penilaian->id)->with('message-error', 'Sorry, access restricted');
        }

        $item->delete();

        return redirect('/penilaian/'.$penilaian->id)->with('message-success', 'Item Penilaian deleted successfully');
    }
}
