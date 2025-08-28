<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class GreenHouse extends Composer
{
    /**
     * The board token.
     *
     * @var string
     */
    public $boardToken;

    public $type;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($boardToken = '')
    {
        $this->boardToken = 'uniteus';
    }
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
        'single'
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function with()
    {
        return [
            'greenHouseJobs' => $this->jobsData(),
            'greenHouseOffices' => $this->officesData(),
            'greenHouseDepartments' => $this->departmentsData(),
        ];
    }

    /**
     * Returns the GreenHouse json response.
     *
     * @return string
     */
    // public function getJsonResponse($type = 'jobs', $job_id = 0)
    // {
    //     $url = 'https://boards-api.greenhouse.io/v1/boards/' . $this->boardToken . '/' . $type .'?content=true';
    //     if ($job_id) {
    //         $url .= '/' . $job_id;
    //     }

    //     $request = wp_remote_get($url);

    //     if (is_wp_error($request)) {
    //         return false; // bail out early
    //     }

    //     $body = wp_remote_retrieve_body($request);

    //     $data = json_decode($body, true);

    //     return $data;
    // }

    // public function jobsData()
    // {
    //     return $this->getJsonResponse('jobs');
    // }

    // public function officesData()
    // {
    //     return $this->getJsonResponse('offices');
    // }

    // public function departmentsData()
    // {
    //     return $this->getJsonResponse('departments');
    // }

    // public static function getJob($job_id = 0) {
    //     $url = 'https://boards-api.greenhouse.io/v1/boards/uniteus/jobs/' . $job_id;

    //     $request = wp_remote_get($url);

    //     if (is_wp_error($request)) {
    //         return false; // bail out early
    //     }

    //     $body = wp_remote_retrieve_body($request);

    //     $data = json_decode($body, true);

    //     return $data;
    // }
}
