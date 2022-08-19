<?php
class Events_dashboard extends Controller
{
    // page access control. check for user log in/ user status
    public function __construct()
    {
        $data = [];
        // not logged in
        if (!isLoggedIn()) {
            $data = ["message" => "Sorry. Only logged-in event creators have access to this page."];
            // redirect('error', $data);
            $this->view('pages/error', $data);
            die();
        }
        // logged in, but as a guest
        elseif (isset($_SESSION['user_id']) && $_SESSION['status'] == 'guest') {
            $data = ["message" => "Sorry. Only event creators have access to this page."];
            // redirect('error', $data);
            $this->view('pages/error', $data);
            die();
        }
    }
    public function index($event_id)
    {
        // the url: /events/3
        // param is an array
        $data = [
            "title" => "Dashboard"
        ];
        $this->view('events/allEvents', $data);
    }


    public function discount_code($params)
    {
        // possible url: events_dashboard/2/discount_code/3
        // $params[0]=2, $params[1]=3

        require_once('Codes.php');
        $codes = new Codes;
        $codes->index($params);
    }
}
