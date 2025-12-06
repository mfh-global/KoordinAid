<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NeedlistController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Needlist/Index', [
            'needlists' => Inquiry::with('organisation')
               ->orderby('created_at', 'desc')
               ->filter($request->status)
               ->get(),
            'filters' => $request->all('status'),
        ]);
    }

    public function show(Inquiry $inquiry): Response
    {
        return Inertia::render('Needlist/Show', [
            'inquiry' => $inquiry->loadMissing('organisation'),
            'comment'=> $inquiry->getComment(),
            'needlist' =>$inquiry->inqueriedProducts()
            ->with('product')
            ->with('sizes')
            ->get(),
        ]);
    }

    public function update(Inquiry $inquiry, Request $request): RedirectResponse
    {
        $inquiry->update($request->only('status'));

        return Redirect::back()->with('success', 'Status updated.');
    }
}
