<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::clients()
            ->withCount('loanApplications')
            ->latest()
            ->paginate(15);

        return view('agent.clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        if (! $client->isClient()) {
            abort(404);
        }

        $client->load('loanApplications');

        return view('agent.clients.show', compact('client'));
    }
}
