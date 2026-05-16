<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create more teachers to make it "real"
        $teacherData = [
            ['name' => 'Dr. Robert Fox', 'email' => 'robert.fox@school.com', 'dept' => 'CIT'],
            ['name' => 'Prof. Sarah Jenkins', 'email' => 'sarah.jenkins@school.com', 'dept' => 'CIT'],
            ['name' => 'Engr. Michael Chen', 'email' => 'michael.chen@school.com', 'dept' => 'Engineering'],
            ['name' => 'Dr. Elena Rodriguez', 'email' => 'elena.rodriguez@school.com', 'dept' => 'Business'],
            ['name' => 'Chef Antonio Luna', 'email' => 'antonio.luna@school.com', 'dept' => 'HRM'],
            ['name' => 'Ms. Grace Hopper', 'email' => 'grace.hopper@school.com', 'dept' => 'CS'],
            ['name' => 'Dr. Alan Turing', 'email' => 'alan.turing@school.com', 'dept' => 'CS'],
        ];

        $teachers = [];
        foreach ($teacherData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);

            $teachers[] = Teacher::create([
                'user_id' => $user->id,
                'employee_id' => 'TCH-' . rand(1000, 9999),
                'department' => $data['dept'],
            ]);
        }

        $bsit = Course::where('code', 'BSIT')->first();
        $bscs = Course::where('code', 'BSCS')->first();
        $hrm = Course::where('code', 'HRM')->first();

        $curriculum = [
            'BSIT' => [
                '1st Year' => [
                    '1st Semester' => [
                        ['name' => 'Introduction to Computing', 'code' => 'IT101'],
                        ['name' => 'Computer Programming 1', 'code' => 'IT102'],
                        ['name' => 'Calculus 1', 'code' => 'MATH101'],
                        ['name' => 'Purposive Communication', 'code' => 'ENG101'],
                        ['name' => 'Ethics', 'code' => 'SOC101'],
                        ['name' => 'Physical Fitness', 'code' => 'PE101'],
                        ['name' => 'NSTP 1', 'code' => 'NSTP101'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Computer Programming 2', 'code' => 'IT103'],
                        ['name' => 'Discrete Mathematics', 'code' => 'IT104'],
                        ['name' => 'Networking 1', 'code' => 'IT105'],
                        ['name' => 'Art Appreciation', 'code' => 'ART101'],
                        ['name' => 'The Contemporary World', 'code' => 'SOC102'],
                        ['name' => 'Rhythmic Activities', 'code' => 'PE102'],
                        ['name' => 'NSTP 2', 'code' => 'NSTP102'],
                    ],
                ],
                '2nd Year' => [
                    '1st Semester' => [
                        ['name' => 'Data Structures and Algorithms', 'code' => 'IT201'],
                        ['name' => 'Quantitative Methods', 'code' => 'IT202'],
                        ['name' => 'System Analysis and Design', 'code' => 'IT203'],
                        ['name' => 'Human Computer Interaction', 'code' => 'IT204'],
                        ['name' => 'Platform Technologies', 'code' => 'IT205'],
                        ['name' => 'Individual Sports', 'code' => 'PE201'],
                        ['name' => 'Life and Works of Rizal', 'code' => 'RIZAL101'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Events Driven Programming', 'code' => 'IT206'],
                        ['name' => 'Networking 2', 'code' => 'IT207'],
                        ['name' => 'Database Management Systems 1', 'code' => 'IT208'],
                        ['name' => 'Information Management', 'code' => 'IT209'],
                        ['name' => 'Object Oriented Programming', 'code' => 'IT210'],
                        ['name' => 'Team Sports', 'code' => 'PE202'],
                        ['name' => 'Science, Technology and Society', 'code' => 'STS101'],
                    ],
                ],
                '3rd Year' => [
                    '1st Semester' => [
                        ['name' => 'Information Assurance and Security 1', 'code' => 'IT301'],
                        ['name' => 'Mobile Development', 'code' => 'IT302'],
                        ['name' => 'Web Systems and Technologies 1', 'code' => 'IT303'],
                        ['name' => 'Systems Administration and Maintenance', 'code' => 'IT304'],
                        ['name' => 'Advanced Database Systems', 'code' => 'IT305'],
                        ['name' => 'IT Elective 1', 'code' => 'ITE1'],
                        ['name' => 'Integrative Programming', 'code' => 'IT306'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Information Assurance and Security 2', 'code' => 'IT307'],
                        ['name' => 'Web Systems and Technologies 2', 'code' => 'IT308'],
                        ['name' => 'Social and Professional Issues in IT', 'code' => 'IT309'],
                        ['name' => 'Capstone Project 1', 'code' => 'IT310'],
                        ['name' => 'IT Elective 2', 'code' => 'ITE2'],
                        ['name' => 'Cloud Computing', 'code' => 'IT311'],
                        ['name' => 'Application Development', 'code' => 'IT312'],
                    ],
                ],
                '4th Year' => [
                    '1st Semester' => [
                        ['name' => 'Capstone Project 2', 'code' => 'IT401'],
                        ['name' => 'IT Elective 3', 'code' => 'ITE3'],
                        ['name' => 'IT Elective 4', 'code' => 'ITE4'],
                        ['name' => 'Enterprise System', 'code' => 'IT402'],
                        ['name' => 'Seminars and Field Trips', 'code' => 'IT403'],
                        ['name' => 'Technopreneurship', 'code' => 'IT404'],
                        ['name' => 'Information Management 2', 'code' => 'IT405'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Practicum (480 hours)', 'code' => 'IT406'],
                        ['name' => 'Special Topics', 'code' => 'IT407'],
                        ['name' => 'Emerging Technologies', 'code' => 'IT408'],
                        ['name' => 'Research in IT', 'code' => 'IT409'],
                        ['name' => 'Project Management', 'code' => 'IT410'],
                        ['name' => 'Professional Skills', 'code' => 'IT411'],
                        ['name' => 'Network Security', 'code' => 'IT412'],
                    ],
                ]
            ],
            'BSCS' => [
                 '1st Year' => [
                    '1st Semester' => [
                        ['name' => 'Introduction to CS', 'code' => 'CS101'],
                        ['name' => 'Discrete Structures 1', 'code' => 'CS102'],
                        ['name' => 'Programming Concepts 1', 'code' => 'CS103'],
                        ['name' => 'Mathematics in Modern World', 'code' => 'MATH111'],
                        ['name' => 'Purposive Communication', 'code' => 'ENG111'],
                        ['name' => 'Physical Fitness', 'code' => 'PE111'],
                        ['name' => 'NSTP 1', 'code' => 'NSTP111'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Programming Concepts 2', 'code' => 'CS104'],
                        ['name' => 'Discrete Structures 2', 'code' => 'CS105'],
                        ['name' => 'Object Oriented Systems', 'code' => 'CS106'],
                        ['name' => 'Art Appreciation', 'code' => 'ART111'],
                        ['name' => 'Science, Tech and Society', 'code' => 'STS111'],
                        ['name' => 'Rhythmic Activities', 'code' => 'PE112'],
                        ['name' => 'NSTP 2', 'code' => 'NSTP112'],
                    ],
                ],
                '2nd Year' => [
                    '1st Semester' => [
                        ['name' => 'Data Structures', 'code' => 'CS201'],
                        ['name' => 'Computer Organization', 'code' => 'CS202'],
                        ['name' => 'Algorithms and Complexity', 'code' => 'CS203'],
                        ['name' => 'Software Engineering 1', 'code' => 'CS204'],
                        ['name' => 'Linear Algebra', 'code' => 'MATH211'],
                        ['name' => 'Individual Sports', 'code' => 'PE211'],
                        ['name' => 'Rizal', 'code' => 'RIZAL111'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Theory of Automata', 'code' => 'CS205'],
                        ['name' => 'Operating Systems', 'code' => 'CS206'],
                        ['name' => 'Database Systems', 'code' => 'CS207'],
                        ['name' => 'Software Engineering 2', 'code' => 'CS208'],
                        ['name' => 'Numerical Methods', 'code' => 'MATH212'],
                        ['name' => 'Team Sports', 'code' => 'PE212'],
                        ['name' => 'Readings in Phil History', 'code' => 'HIST111'],
                    ],
                ],
                '3rd Year' => [
                    '1st Semester' => [
                        ['name' => 'Programming Languages', 'code' => 'CS301'],
                        ['name' => 'Architecture and Organization', 'code' => 'CS302'],
                        ['name' => 'CS Elective 1', 'code' => 'CSE1'],
                        ['name' => 'Information Management', 'code' => 'CS303'],
                        ['name' => 'Prob and Stats', 'code' => 'MATH311'],
                        ['name' => 'Logic Design', 'code' => 'CS304'],
                        ['name' => 'Operating Systems 2', 'code' => 'CS305'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'CS Elective 2', 'code' => 'CSE2'],
                        ['name' => 'Networks and Comm', 'code' => 'CS306'],
                        ['name' => 'CS Thesis 1', 'code' => 'CS307'],
                        ['name' => 'Parallel and Dist Computing', 'code' => 'CS308'],
                        ['name' => 'Graphics and Visual', 'code' => 'CS309'],
                        ['name' => 'Intelligence Systems', 'code' => 'CS310'],
                        ['name' => 'Information Assurance', 'code' => 'CS311'],
                    ],
                ],
                '4th Year' => [
                    '1st Semester' => [
                        ['name' => 'CS Thesis 2', 'code' => 'CS401'],
                        ['name' => 'CS Elective 3', 'code' => 'CSE3'],
                        ['name' => 'Special Topics in CS', 'code' => 'CS402'],
                        ['name' => 'Social Issues and Prof', 'code' => 'CS403'],
                        ['name' => 'Technopreneurship', 'code' => 'CS404'],
                        ['name' => 'Mobile Dev in CS', 'code' => 'CS405'],
                        ['name' => 'Cloud Architecture', 'code' => 'CS406'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'OJT (480 hours)', 'code' => 'CS407'],
                        ['name' => 'Advanced Algorithms', 'code' => 'CS408'],
                        ['name' => 'Cryptography', 'code' => 'CS409'],
                        ['name' => 'Machine Learning', 'code' => 'CS410'],
                        ['name' => 'Data Science', 'code' => 'CS411'],
                        ['name' => 'Cybersecurity', 'code' => 'CS412'],
                        ['name' => 'Emerging Trends in CS', 'code' => 'CS413'],
                    ],
                ]
            ],
            'HRM' => [
                 '1st Year' => [
                    '1st Semester' => [
                        ['name' => 'Macro Perspective in HRM', 'code' => 'HRM101'],
                        ['name' => 'Risk Management', 'code' => 'HRM102'],
                        ['name' => 'Kitchen Essentials', 'code' => 'HRM103'],
                        ['name' => 'Math in Modern World', 'code' => 'MATH121'],
                        ['name' => 'Purposive Comm', 'code' => 'ENG121'],
                        ['name' => 'PE 1', 'code' => 'PE121'],
                        ['name' => 'NSTP 1', 'code' => 'NSTP121'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Micro Perspective in HRM', 'code' => 'HRM104'],
                        ['name' => 'Food Safety and Hygiene', 'code' => 'HRM105'],
                        ['name' => 'Bread and Pastry 1', 'code' => 'HRM106'],
                        ['name' => 'Art Appreciation', 'code' => 'ART121'],
                        ['name' => 'Readings in Phil History', 'code' => 'HIST121'],
                        ['name' => 'PE 2', 'code' => 'PE122'],
                        ['name' => 'NSTP 2', 'code' => 'NSTP122'],
                    ],
                ],
                '2nd Year' => [
                    '1st Semester' => [
                        ['name' => 'Food and Beverage Service', 'code' => 'HRM201'],
                        ['name' => 'Front Office Operations', 'code' => 'HRM202'],
                        ['name' => 'Total Quality Management', 'code' => 'HRM203'],
                        ['name' => 'Quantity Food Prod', 'code' => 'HRM204'],
                        ['name' => 'Hospitality Accounting', 'code' => 'HRM205'],
                        ['name' => 'PE 3', 'code' => 'PE221'],
                        ['name' => 'Ethics', 'code' => 'SOC121'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Bar Management', 'code' => 'HRM206'],
                        ['name' => 'Housekeeping Operations', 'code' => 'HRM207'],
                        ['name' => 'Supply Chain in HRM', 'code' => 'HRM208'],
                        ['name' => 'Global Culture in HRM', 'code' => 'HRM209'],
                        ['name' => 'Strategic Management', 'code' => 'HRM210'],
                        ['name' => 'PE 4', 'code' => 'PE222'],
                        ['name' => 'Rizal', 'code' => 'RIZAL121'],
                    ],
                ],
                '3rd Year' => [
                    '1st Semester' => [
                        ['name' => 'Event Management', 'code' => 'HRM301'],
                        ['name' => 'Travel and Tour Ops', 'code' => 'HRM302'],
                        ['name' => 'Foreign Language 1', 'code' => 'FL1'],
                        ['name' => 'Research in HRM 1', 'code' => 'HRM303'],
                        ['name' => 'Hospitality Law', 'code' => 'HRM304'],
                        ['name' => 'Tourism Marketing', 'code' => 'HRM305'],
                        ['name' => 'Cost Control', 'code' => 'HRM306'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Foreign Language 2', 'code' => 'FL2'],
                        ['name' => 'Research in HRM 2', 'code' => 'HRM307'],
                        ['name' => 'HRM Elective 1', 'code' => 'HRME1'],
                        ['name' => 'HRM Elective 2', 'code' => 'HRME2'],
                        ['name' => 'Facilities Management', 'code' => 'HRM308'],
                        ['name' => 'Tourism Policy', 'code' => 'HRM309'],
                        ['name' => 'Entrepreneurship in HRM', 'code' => 'HRM310'],
                    ],
                ],
                '4th Year' => [
                    '1st Semester' => [
                        ['name' => 'Professional Development', 'code' => 'HRM401'],
                        ['name' => 'HRM Elective 3', 'code' => 'HRME3'],
                        ['name' => 'HRM Elective 4', 'code' => 'HRME4'],
                        ['name' => 'Capstone Project in HRM', 'code' => 'HRM402'],
                        ['name' => 'Seminars in HRM', 'code' => 'HRM403'],
                        ['name' => 'Sustainable Tourism', 'code' => 'HRM404'],
                        ['name' => 'Luxury Service', 'code' => 'HRM405'],
                    ],
                    '2nd Semester' => [
                        ['name' => 'Practicum / OJT (600 hours)', 'code' => 'HRM406'],
                        ['name' => 'Industry Simulation', 'code' => 'HRM407'],
                        ['name' => 'Advanced Culinary', 'code' => 'HRM408'],
                        ['name' => 'Mixology', 'code' => 'HRM409'],
                        ['name' => 'Food Ethics', 'code' => 'HRM410'],
                        ['name' => 'Global HRM Trends', 'code' => 'HRM411'],
                        ['name' => 'Project Management', 'code' => 'HRM412'],
                    ],
                ]
            ],
        ];

        foreach ($curriculum as $courseCode => $years) {
            $course = Course::where('code', $courseCode)->first();
            if (!$course) continue;

            foreach ($years as $yearLevel => $semesters) {
                foreach ($semesters as $semester => $subjs) {
                    foreach ($subjs as $s) {
                        Subject::create([
                            'name' => $s['name'],
                            'code' => $courseCode . '-' . $s['code'],
                            'description' => $s['name'] . ' for ' . $courseCode,
                            'teacher_id' => $teachers[array_rand($teachers)]->id,
                            'course_id' => $course->id,
                            'year_level' => $yearLevel,
                            'semester' => $semester,
                            'units' => rand(2, 3),
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
