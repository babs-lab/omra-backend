<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lead $lead,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de réservation - '.$this->lead->first_name.' '.$this->lead->last_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    public function buildHtml(): string
    {
        $lead = $this->lead;
        $departure = $lead->departure;
        $package = $departure?->package;

        $rows = $this->buildRow('Nom complet', $lead->first_name.' '.$lead->last_name);
        $rows .= $this->buildRow('Email', '<a href="mailto:'.e($lead->email).'" style="color:#2563eb;">'.e($lead->email).'</a>', true);
        $rows .= $this->buildRow('Téléphone', '<a href="tel:'.e($lead->phone).'" style="color:#2563eb;">'.e($lead->phone).'</a>');
        $rows .= $this->buildRow('Voyageurs', (string) $lead->passengers_count, true);
        $rows .= $this->buildRow('Type de chambre', ucfirst($lead->room_type_requested));

        if ($package) {
            $rows .= $this->buildRow('Formule', e($package->title), true);
        }

        if ($departure) {
            $start = $departure->start_date->format('d/m/Y');
            $end = $departure->end_date->format('d/m/Y');
            $rows .= $this->buildRow('Dates', $start.' &rarr; '.$end);
            $rows .= $this->buildRow('Vacances scolaires', $departure->is_school_holiday ? 'Oui' : 'Non', true);
        }

        if ($lead->estimated_total_price !== null) {
            $currency = $lead->currency ?? '';
            $price = number_format($lead->estimated_total_price, 2, ',', ' ');
            $rows .= $this->buildRow('Prix estim&eacute;', '<span style="font-size:16px;font-weight:700;">'.$price.' '.e($currency).'</span>');
        }

        if ($lead->notes) {
            $rows .= $this->buildRow('Notes', nl2br(e($lead->notes)), true);
        }

        $adminUrl = config('app.url', 'http://localhost:8000').'/moonshine/leads/'.$lead->id;
        $createdAt = $lead->created_at->format('d/m/Y &agrave; H:i');

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">
<div style="max-width:600px;margin:0 auto;padding:24px;">
    <div style="background:linear-gradient(135deg,#1a1a2e,#16213e);border-radius:12px 12px 0 0;padding:24px 32px;text-align:center;">
        <h1 style="color:#d4a843;font-size:22px;margin:0;">OUMRA TERANGA</h1>
        <p style="color:#9ca3af;font-size:13px;margin:4px 0 0;">Nouvelle demande de r&eacute;servation</p>
    </div>
    <div style="background:#ffffff;border-radius:0 0 12px 12px;padding:8px 0 24px;">
        <table style="width:100%;border-collapse:collapse;">
            {$rows}
        </table>
        <div style="padding:0 16px;margin-top:16px;">
            <a href="{$adminUrl}" style="display:inline-block;background:#1a1a2e;color:#d4a843;text-decoration:none;padding:12px 24px;border-radius:8px;font-weight:600;">
                Voir dans l'admin
            </a>
        </div>
    </div>
    <p style="text-align:center;color:#9ca3af;font-size:11px;margin-top:16px;">
        Lead #{$lead->id} &middot; {$createdAt}
    </p>
</div>
</body>
</html>
HTML;
    }

    private function buildRow(string $label, string $value, bool $alt = false): string
    {
        $bg = $alt ? 'background:#f9fafb;' : '';

        return <<<HTML
        <tr style="{$bg}">
            <td style="padding:12px 16px;font-weight:600;color:#374151;width:180px;">{$label}</td>
            <td style="padding:12px 16px;color:#111827;">{$value}</td>
        </tr>
        HTML;
    }
}
