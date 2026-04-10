<?php

namespace App\Console;

use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands personnalisés
        \App\Console\Commands\SendAppointmentReminders::class,
        \App\Console\Commands\CleanupOldRecords::class,
        \App\Console\Commands\GenerateDailyReport::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ==================== RAPPELS DE RENDEZ-VOUS ====================
        
        // Envoyer les rappels 24h avant le rendez-vous (toutes les heures)
        $schedule->call(function () {
            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('date_time', '>=', now())
                ->where('date_time', '<=', now()->addDay())
                ->where('status', 'confirmed')
                ->where('reminder_sent', false)
                ->get();

            foreach ($appointments as $appointment) {
                try {
                    $appointment->patient->user->notify(new AppointmentReminder($appointment, 'reminder'));
                    $appointment->update(['reminder_sent' => true]);
                    Log::info('Rappel envoyé pour le rendez-vous #' . $appointment->id);
                } catch (\Exception $e) {
                    Log::error('Erreur envoi rappel: ' . $e->getMessage());
                }
            }
        })->hourly()->name('send-appointment-reminders');

        // Envoyer les rappels 1h avant (toutes les 30 minutes)
        $schedule->call(function () {
            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('date_time', '>=', now())
                ->where('date_time', '<=', now()->addHour())
                ->where('status', 'confirmed')
                ->where('reminder_sent', false)
                ->get();

            foreach ($appointments as $appointment) {
                try {
                    $appointment->patient->user->notify(new AppointmentReminder($appointment, 'reminder'));
                    Log::info('Rappel 1h avant envoyé pour le rendez-vous #' . $appointment->id);
                } catch (\Exception $e) {
                    Log::error('Erreur envoi rappel 1h: ' . $e->getMessage());
                }
            }
        })->everyThirtyMinutes()->name('send-hourly-reminders');

        // ==================== NETTOYAGE AUTOMATIQUE ====================
        
        // Supprimer les rendez-vous annulés de plus de 30 jours (tous les jours à 02:00)
        $schedule->call(function () {
            $deleted = Appointment::where('status', 'cancelled')
                ->where('date_time', '<', now()->subDays(30))
                ->delete();
            
            Log::info('Nettoyage auto: ' . $deleted . ' rendez-vous annulés supprimés');
        })->dailyAt('02:00')->name('cleanup-cancelled-appointments');

        // Supprimer les patients inactifs (sans rendez-vous depuis 1 an)
        $schedule->call(function () {
            $patients = \App\Models\Patient::whereDoesntHave('appointments', function($q) {
                $q->where('date_time', '>', now()->subYear());
            })->get();
            
            foreach ($patients as $patient) {
                Log::info('Patient inactif: ' . $patient->user->name);
            }
        })->weekly()->sundays()->at('03:00')->name('check-inactive-patients');

        // ==================== RAPPORTS QUOTIDIENS ====================
        
        // Générer rapport quotidien (tous les jours à 23:30)
        $schedule->call(function () {
            $today = now();
            $appointments = Appointment::whereDate('date_time', $today)->count();
            $confirmed = Appointment::whereDate('date_time', $today)->where('status', 'confirmed')->count();
            $cancelled = Appointment::whereDate('date_time', $today)->where('status', 'cancelled')->count();
            $completed = Appointment::whereDate('date_time', $today)->where('status', 'completed')->count();
            $newPatients = \App\Models\Patient::whereDate('created_at', $today)->count();
            
            $report = [
                'date' => $today->format('Y-m-d'),
                'appointments' => $appointments,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'completed' => $completed,
                'new_patients' => $newPatients,
            ];
            
            Log::info('Rapport quotidien', $report);
            
            // Optionnel: envoyer email au chef de cabinet
            // Mail::to('chef@healthsys.com')->send(new DailyReportMail($report));
            
        })->dailyAt('23:30')->name('generate-daily-report');

        // ==================== STATISTIQUES HEBDOMADAIRES ====================
        
        // Générer rapport hebdomadaire (tous les dimanches à 22:00)
        $schedule->call(function () {
            $weekStart = now()->startOfWeek();
            $weekEnd = now()->endOfWeek();
            
            $weeklyAppointments = Appointment::whereBetween('date_time', [$weekStart, $weekEnd])->count();
            $weeklyRevenue = \App\Models\Invoice::whereBetween('created_at', [$weekStart, $weekEnd])->sum('amount');
            $weeklyPaid = \App\Models\Invoice::whereBetween('created_at', [$weekStart, $weekEnd])->sum('paid_amount');
            
            Log::info('Rapport hebdomadaire', [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
                'appointments' => $weeklyAppointments,
                'revenue' => $weeklyRevenue,
                'paid' => $weeklyPaid,
                'pending' => $weeklyRevenue - $weeklyPaid,
            ]);
            
        })->weekly()->sundays()->at('22:00')->name('generate-weekly-report');

        // ==================== STATISTIQUES MENSUELLES ====================
        
        // Générer rapport mensuel (le 1er de chaque mois à 08:00)
        $schedule->call(function () {
            $lastMonth = now()->subMonth();
            $monthStart = $lastMonth->copy()->startOfMonth();
            $monthEnd = $lastMonth->copy()->endOfMonth();
            
            $monthlyAppointments = Appointment::whereBetween('date_time', [$monthStart, $monthEnd])->count();
            $monthlyRevenue = \App\Models\Invoice::whereBetween('created_at', [$monthStart, $monthEnd])->sum('amount');
            $newPatients = \App\Models\Patient::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            Log::info('Rapport mensuel', [
                'month' => $lastMonth->format('F Y'),
                'appointments' => $monthlyAppointments,
                'revenue' => $monthlyRevenue,
                'new_patients' => $newPatients,
            ]);
            
        })->monthlyOn(1, '08:00')->name('generate-monthly-report');

        // ==================== SAUVEGARDE BASE DE DONNÉES ====================
        
        // Sauvegarde quotidienne de la base de données (tous les jours à 01:00)
        $schedule->command('backup:run')->dailyAt('01:00')->name('database-backup');

        // ==================== NETTOYAGE CACHE ====================
        
        // Vider le cache toutes les heures
        $schedule->command('cache:clear')->hourly()->name('clear-cache');
        
        // Vider la vue cache tous les jours
        $schedule->command('view:clear')->dailyAt('04:00')->name('clear-view-cache');
        
        // Optimiser la base de données chaque semaine
        $schedule->command('db:optimize')->weekly()->sundays()->at('05:00')->name('optimize-database');

        // ==================== NOTIFICATIONS FACTURES IMPAYÉES ====================
        
        // Envoyer rappels pour factures impayées (tous les jours à 09:00)
        $schedule->call(function () {
            $overdueInvoices = \App\Models\Invoice::where('status', 'pending')
                ->where('due_date', '<', now())
                ->with('patient.user')
                ->get();
            
            foreach ($overdueInvoices as $invoice) {
                Log::info('Facture impayée #' . $invoice->invoice_number . ' - Patient: ' . $invoice->patient->user->name);
                // Optionnel: envoyer email de rappel
            }
        })->dailyAt('09:00')->name('check-overdue-invoices');

        // ==================== RAPPELS ANNIVERSAIRES ====================
        
        // Vérifier les anniversaires des patients (tous les jours à 08:00)
        $schedule->call(function () {
            $today = now()->format('m-d');
            $patients = \App\Models\Patient::with('user')
                ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [$today])
                ->get();
            
            foreach ($patients as $patient) {
                Log::info('Anniversaire aujourd\'hui: ' . $patient->user->name);
                // Optionnel: envoyer email de souhaits
            }
        })->dailyAt('08:00')->name('birthday-reminders');

        // ==================== EXPORT AUTOMATIQUE ====================
        
        // Exporter les rapports PDF chaque semaine (lundi à 06:00)
        $schedule->command('export:weekly-report')->weekly()->mondays()->at('06:00')->name('export-weekly-report');

        // ==================== MISE À JOUR STATUT RENDEZ-VOUS ====================
        
        // Mettre à jour les rendez-vous passés en "completed" (toutes les heures)
        $schedule->call(function () {
            $updated = Appointment::where('date_time', '<', now())
                ->where('status', 'confirmed')
                ->update(['status' => 'completed']);
            
            if ($updated > 0) {
                Log::info($updated . ' rendez-vous marqués comme terminés');
            }
        })->hourly()->name('update-past-appointments');

        // ==================== RAPPORTS PERSONNALISÉS ====================
        
        // Exécuter les commandes personnalisées
        $schedule->command('reminders:send')->everyMinute();
        $schedule->command('cleanup:old')->dailyAt('03:00');
        $schedule->command('report:daily')->dailyAt('23:00');
        $schedule->command('report:weekly')->weekly()->sundays()->at('22:00');
        $schedule->command('report:monthly')->monthlyOn(1, '08:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}