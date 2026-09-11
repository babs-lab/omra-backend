<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(LeadRequest $request): JsonResponse
    {
        $lead = Lead::create($request->validated());

        $lead->load('departure.package');

        $notifyEmail = config('app.notify_email');
        if ($notifyEmail) {
            Mail::to($notifyEmail)->send(new NewLeadNotification($lead));
        }

        return response()->json([
            'message' => 'Votre demande de réservation a bien été prise en compte.',
            'lead' => $lead,
        ], 201);
    }
}
