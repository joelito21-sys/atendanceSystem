<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    /**
     * Show the system settings page.
     */
    public function index(): View
    {
        $definitions = [
            'school_name' => [
                'label' => 'School Name',
                'description' => 'Displayed in the navigation and dashboards.',
                'default' => 'AttendanceSystem',
            ],
            'school_year' => [
                'label' => 'Current School Year',
                'description' => 'For example: 2025–2026.',
                'default' => '',
            ],
            'term_start' => [
                'label' => 'Current Term Start Date',
                'description' => 'Start date of the active term/semester.',
                'default' => '',
            ],
            'term_end' => [
                'label' => 'Current Term End Date',
                'description' => 'End date of the active term/semester.',
                'default' => '',
            ],
            'contact_email' => [
                'label' => 'Contact Email',
                'description' => 'General contact address shown in footers or notifications.',
                'default' => '',
            ],
            'timezone' => [
                'label' => 'System Timezone',
                'description' => 'Used as the default timezone for reporting (e.g. Asia/Manila).',
                'default' => config('app.timezone'),
            ],
        ];

        $existing = Setting::whereIn('key', array_keys($definitions))
            ->get()
            ->keyBy('key');

        return view('admin.settings.index', [
            'definitions' => $definitions,
            'existing' => $existing,
        ]);
    }

    /**
     * Persist system settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $keys = [
            'school_name',
            'school_year',
            'term_start',
            'term_end',
            'contact_email',
            'timezone',
        ];

        $validated = $request->validate([
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_year' => ['nullable', 'string', 'max:50'],
            'term_start' => ['nullable', 'date'],
            'term_end' => ['nullable', 'date', 'after_or_equal:term_start'],
            'contact_email' => ['nullable', 'email'],
            'timezone' => ['nullable', 'string', 'max:100'],
        ]);

        $values = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $validated)) {
                $values[$key] = $validated[$key];
            }
        }

        Setting::setMany($values);

        return back()->with('success', 'System settings have been updated.');
    }
}

