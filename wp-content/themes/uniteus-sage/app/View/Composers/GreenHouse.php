<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class GreenHouse extends Composer

{
    // Don't attach this composer to any views
    protected static $views = [];

    /** @var string */
    public $boardToken = 'uniteus';

    // Return nothing so no methods are called
    public function with()
    {
        return [];
    }

    // Hard stubs so accidental calls never reach the API
    public function getJsonResponse($type = 'jobs', $job_id = 0) { return []; }
    public function jobsData()        { return []; }
    public function officesData()     { return []; }
    public function departmentsData() { return []; }
    public static function getJob($job_id = 0) { return []; }
}

// {
 
//     public $boardToken;

//     public $type;

//     public function __construct($boardToken = '')
//     {
//         $this->boardToken = 'uniteus';
//     }

//     protected static $views = [
//         'partials.page-header',
//         'partials.content',
//         'partials.content-*',
//         'single'
//     ];

//     public function with()
//     {
//         return [
//             'greenHouseJobs' => $this->jobsData(),
//             'greenHouseOffices' => $this->officesData(),
//             'greenHouseDepartments' => $this->departmentsData(),
//         ];
//     }

//     public function getJsonResponse($type = 'jobs', $job_id = 0)
//     {
//         $url = 'https://boards-api.greenhouse.io/v1/boards/' . $this->boardToken . '/' . $type .'?content=true';
//         if ($job_id) {
//             $url .= '/' . $job_id;
//         }

//         $request = wp_remote_get($url);

//         if (is_wp_error($request)) {
//             return false;
//         }

//         $body = wp_remote_retrieve_body($request);

//         $data = json_decode($body, true);

//         return $data;
//     }

//     public function jobsData()
//     {
//         return $this->getJsonResponse('jobs');
//     }

//     public function officesData()
//     {
//         return $this->getJsonResponse('offices');
//     }

//     public function departmentsData()
//     {
//         return $this->getJsonResponse('departments');
//     }

//     public static function getJob($job_id = 0) {
//         $url = 'https://boards-api.greenhouse.io/v1/boards/uniteus/jobs/' . $job_id;

//         $request = wp_remote_get($url);

//         if (is_wp_error($request)) {
//             return false; 
//         }

//         $body = wp_remote_retrieve_body($request);

//         $data = json_decode($body, true);

//         return $data;
//     }
// }
