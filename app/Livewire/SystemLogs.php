<?php

namespace App\Livewire;

use Livewire\Component;

//MODELS:
use App\Models\RecentLogs;

class SystemLogs extends Component
{
    public $recentLogs;
     /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function mount() {
        $this->fetchRecentLogs();
    }
     /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function fetchRecentLogs() {
        $this->recentLogs = RecentLogs::orderBy('updated_at', 'DESC')->limit(50)->get();
    }
     /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function render() {
        $recentLogs = $this->recentLogs;
        return view('livewire.system-logs', compact('recentLogs'));
    }
}
