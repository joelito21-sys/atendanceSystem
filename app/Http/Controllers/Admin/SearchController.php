<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return view('admin.search.results', [
                'query' => '',
                'results' => []
            ]);
        }

        $results = [
            'students' => Student::with('user')
                ->where('student_id_number', 'LIKE', "%{$query}%")
                ->orWhereHas('user', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })->limit(10)->get(),

            'teachers' => Teacher::with('user')
                ->where('employee_id', 'LIKE', "%{$query}%")
                ->orWhereHas('user', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })->limit(10)->get(),

            'subjects' => Subject::where('name', 'LIKE', "%{$query}%")
                ->orWhere('code', 'LIKE', "%{$query}%")
                ->limit(10)->get(),

            'admins' => User::where('role', 'admin')
                ->where('name', 'LIKE', "%{$query}%")
                ->limit(10)->get(),
        ];


        return view('admin.search.results', [
            'query' => $query,
            'results' => $results
        ]);
    }
}
