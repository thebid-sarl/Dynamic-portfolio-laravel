<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitorStatsMail;
use App\Services\LogService;
use Carbon\Carbon;
use App\Models\Visit;
use Exception;

class SendVisitorStats extends Command
{
    protected $signature = 'send:visitor-stats';
    protected $description = 'Envoyer les statistiques des visiteurs à l\'administrateur';
    
    protected $logService;

    public function __construct(LogService $logService)
    {
        parent::__construct();
        $this->logService = $logService;
    }

    public function handle()
    {
        try {
            $this->logService->info('Début de l\'exécution de la commande send:visitor-stats.');

            // Récupérer les statistiques des visiteurs
            $this->logService->info('Récupération des statistiques des visiteurs.');
            $totalVisits = Visit::count();
            $visitsToday = Visit::whereDate('created_at', Carbon::today())->count();
            $visitsThisWeek = Visit::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $visitsThisMonth = Visit::whereMonth('created_at', Carbon::now()->month)->count();

            $stats = [
                'total_visits' => $totalVisits,
                'visits_today' => $visitsToday,
                'visits_this_week' => $visitsThisWeek,
                'visits_this_month' => $visitsThisMonth,
            ];

            $this->logService->info('Statistiques récupérées avec succès : ' . json_encode($stats));

            // Définir l'adresse e-mail de l'administrateur
            $adminEmail = 'odimitri@thebidgmail.com';

            // Envoi de l'email
            $this->logService->info("Envoi de l'email des statistiques à : {$adminEmail}");
            Mail::to($adminEmail)->send(new VisitorStatsMail($stats));
            $this->logService->info('Email envoyé avec succès.');

            $this->info('Les statistiques des visiteurs ont été envoyées à l\'administrateur.');
        } catch (Exception $e) {
            $this->logService->error('Erreur lors de l\'envoi des statistiques : ' . $e->getMessage());
            $this->error('Une erreur s\'est produite lors de l\'envoi des statistiques.');
        }
    }
}
