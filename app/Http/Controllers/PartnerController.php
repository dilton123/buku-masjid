<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $this->authorize('view-any', new Partner);

        $editablePartner = null;
        $partners = Partner::paginate();

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editablePartner = Partner::find(request('id'));
        }

        return view('partners.index', compact('partners', 'editablePartner'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Partner);

        $newPartner = $request->validate([
            'name' => 'required|max:60',
            'phone' => 'nullable|max:60',
            'work' => 'nullable|max:60',
            'address' => 'nullable|max:255',
            'description' => 'nullable|max:255',
        ]);
        $newPartner['creator_id'] = auth()->id();

        Partner::create($newPartner);

        flash(__('partner.created'), 'success');

        return redirect()->route('partners.index');
    }

    public function show(Partner $partner)
    {
        $this->authorize('view', $partner);

        return view('partners.show', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $this->authorize('update', $partner);

        $partnerData = $request->validate([
            'name' => 'required|max:60',
            'phone' => 'nullable|max:60',
            'work' => 'nullable|max:60',
            'address' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        $partner->update($partnerData);

        flash(__('partner.updated'), 'success');

        return redirect()->route('partners.index');
    }

    public function destroy(Partner $partner)
    {
        $this->authorize('delete', $partner);

        request()->validate([
            'partner_id' => 'required',
        ]);

        if (request('partner_id') == $partner->id && $partner->delete()) {
            flash(__('partner.deleted'), 'success');

            return redirect()->route('partners.index');
        }

        return back();
    }
}