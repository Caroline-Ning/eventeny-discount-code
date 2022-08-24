<?php
class Codes extends Controller
{
    public function __construct()
    {
        $this->codeModel = $this->model('Code');
    }

    public function index($params)
    {
        $event_id = $params[0];
        /* 

        !! for completion: access control - only the creator's events are displayed on events_dashboard
        /events_dashboard/0/discount_code/25 - only the creater have access to event_id=0

        if there's a events table, below should be getCodesByEvent

        */
        $codes = $this->codeModel->getCodesByUser($_SESSION['user_id']);

        // events_dashboard/event_id/discount_code
        // get all codes of this event
        if (!$params[1]) {
            $data = [
                'title' => 'Discount Codes',
                'codes' => $codes,
                'event_id' => $event_id,
                'user_id' => $_SESSION['user_id']
            ];

            $this->view('events/allCodes', $data);
            die();
        }

        /*    
        check if params[1] is add
        !! for completion: check if params[0]=int && params[0]=any event id && params[1]=add
        */
        // events_dashboard/event_id/discount_code/add
        if ($params[1] == "add") {
            $this->add($event_id);
            die();
        };

        // events_dashboard/event_id/discount_code/code_id/edit
        if ($params[2] == "edit") {
            $this->edit($params[1], $event_id);
            die();
        }

        // events_dashboard/event_id/discount_code/code_id/delete
        if ($params[2] == "delete") {
            $this->delete($params[1], $event_id);
            die();
        }

        // show one code
        // events_dashboard/event_id/discount_code/code_id
        $code_id = $params[1];
        $this->show($code_id);
    }

    public function show($code_id)
    {
        $code = $this->codeModel->getCodeById($code_id);

        // check for owner
        if ($code->user_id != $_SESSION['user_id']) {
            $this->view('pages/error', ['message' => "You don't have access to this page"]);
            die();
        }

        // eligibility
        $eligibility = 'All customers can use this code';
        switch ($code->customer_eligibility) {
            case 'all':
                $eligibility = "For all customers";
                break;
            case 'group':
                $eligibility = "For groups of customers only";
                break;
            case 'specific':
                $eligibility = "For specific customers only";
                break;
        }

        // limited times
        $limit_times = 'There is no limit of times to use this code';
        if ($code->limit_times) {
            $limit_times = 'The code can be used ' . $code->limit_times_value . ' times in total';
        }

        // active or inactive
        $status = "";
        $current = date('Y-m-d H:i');
        if ($current >= $code->start_date) {
            if (!$code->end_date || $current <= $code->end_date) {
                $status = 'active';
            } else {
                $status = 'inactive';
            }
        } else {
            $status = 'inactive';
        }

        $data = [
            'code_id' => $code->id,
            'event_id' => $code->event_id,
            'code' => $code->code,
            'type' => $code->type,
            'type_value' => $code->type_value,
            'customer_eligibility' => $eligibility,
            'limit_times' => $limit_times,
            'limit_one' => $code->limit_one ? 'One customer can only use the code once' : 'One customer can use the code many times, but the code can only be used once in one order',
            'start_date' => 'Active from ' . $code->start_date,
            'end_date' => $code->end_date ? ' to ' . $code->end_date : '',
            'user_id' => $code->user_id,
            'status' => $status
        ];

        $this->view('events/showCode', $data);
    }

    public function add($event_id)
    {
        // POST, collect data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'code' => strtolower(trim($_POST['code'])),
                'event_id' => $event_id,
                'type' => trim($_POST['type']),
                'type_value' => $_POST['type_value'],
                'customer_eligibility' => trim($_POST['customer_eligibility']),
                'limit_times' => $_POST['limit_times'] ? $_POST['limit_times'] : 0,
                'limit_times_value' => $_POST['limit_times_value'] ? $_POST['limit_times_value'] : Null,
                'limit_one' => $_POST['limit_one'] ? $_POST['limit_one'] : 0,
                "user_id" => $_SESSION['user_id'],
                'start_date' => $_POST['start_date'] ? str_replace('T', ' ', $_POST['start_date'])  : date('Y-m-d H:i'),
                'end_date' => $_POST['end_date'] ? str_replace('T', ' ', $_POST['end_date'])  : Null,
                'is_deleted' => 0,
                'used_times' => 0,
                'code_err' => '',
                'type_value_err' => '',
                'limit_times_value_err' => '',
                'date_err' => '',
                'customer_eligibility_err' => ''
            ];
            // print_r($data);

            // for test
            // $data = [
            //     'code' => '2',
            //     'event_id' => '0',
            //     'type' => 'amount',
            //     'type_value' => '2',
            //     'customer_eligibility' => 'all',
            //     'limit_times' => "1",
            //     'limit_times_value' => "2",
            //     'limit_one' => "1",
            //     "user_id" => $_SESSION['user_id'],
            //     'start_date' => '2022-08-17 17:59',
            //     'end_date' => '2022-08-17 21:59',
            //     'code_err' => '',
            //     'type_value_err' => '',
            //     'limit_times_value_err' => ''
            // ];

            // validate data
            if (empty($data['code'])) {
                $data['code_err'] = 'Please enter discount code';
            } else {
                // code entered, check if it's already created
                // !! for completion: if there's a events table, this should be getCodesByEvent
                $codes = $this->codeModel->getCodesByEventId($event_id);
                foreach ($codes as $ele) {
                    if ($data['code'] == $ele->code && $ele->is_deleted == 0) {
                        $data['code_err'] = 'Code is already created for this event.';
                    }
                }
            }

            if ($data["limit_times"] && empty($data['limit_times_value'])) {
                $data['limit_times_value_err'] = 'Please enter number of times';
            } else if (!$data["limit_times"] && $data['limit_times_value']) {
                $data['limit_times_value_err'] = 'Please select to limit the number of times';
            }

            if ($data['type_value'] <= 0) {
                $data['type_value_err'] = "Invalid value";
            }

            if ($data['type'] == 'percentage' && $data['type_value'] > 100) {
                $data['type_value_err'] = 'Percentage should be less than 100';
            }

            if (empty($data['customer_eligibility'])) {
                $data['customer_eligibility_err'] = 'Please select customer eligibility';
            }

            // no error
            if (empty($data['code_err']) && empty($data['type_value_err']) && empty($data['limit_times_value_err']) && empty($data['customer_eligibility_err'])) {
                // add in model, return t/f
                if ($this->codeModel->addCode($data)) {
                    flash('add_message', 'Discount Code Added');
                    redirect('events_dashboard/' . $data['event_id'] . '/discount_code');
                } else {
                    die('Something went wrong');
                }
            } else {
                // echo 'error';
                // Load view with errors
                $this->view('events/addCode', $data);
            }
        }
        // GET, empty input, waiting for value 
        else {
            $data = [
                'code' => '',
                'event_id' => $event_id,
                'start_date' => '',
                'end_date' => '',
                'type' => '',
                'type_value' => '',
                'customer_eligibility' => '',
                'limit_times' => '',
                'limit_times_value' => '',
                'limit_one' => '',
            ];
            $this->view('events/addCode', $data);
        }
    }

    public function edit($code_id, $event_id)
    {
        // POST, collect data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // get current code
            $code = $this->codeModel->getCodeById($code_id);

            // sanitize 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id' => $code_id,
                'code' => strtolower(trim($_POST['code'])),
                'event_id' => $event_id,
                'type' => trim($_POST['type']),
                'type_value' => $_POST['type_value'],
                'customer_eligibility' => trim($_POST['customer_eligibility']),
                'limit_times' => $_POST['limit_times'] ? $_POST['limit_times'] : 0,
                'limit_times_value' => $_POST['limit_times_value'] ? $_POST['limit_times_value'] : Null,
                'limit_one' => $_POST['limit_one'] ? $_POST['limit_one'] : 0,
                "user_id" => $_SESSION['user_id'],
                'start_date' => $_POST['start_date'] ? str_replace('T', ' ', $_POST['start_date'])  : date('Y-m-d H:i'),
                'end_date' => $_POST['end_date'] ? str_replace('T', ' ', $_POST['end_date'])  : Null,
                'is_deleted' => 0,
                'code_err' => '',
                'type_value_err' => '',
                'limit_times_value_err' => '',
                'date_err' => '',
                'customer_eligibility_err' => ''
            ];
            // print_r($data);

            // for test
            // $data = [
            //     'id' => $code_id,
            //     'code' => 'test',
            //     'event_id' => '0',
            //     'type' => 'amount',
            //     'type_value' => '234',
            //     'customer_eligibility' => 'group',
            //     'limit_times' => "1",
            //     'limit_times_value' => "2",
            //     'limit_one' => "1",
            //     "user_id" => $_SESSION['user_id'],
            //     'start_date' => '2022-08-17 17:59',
            //     'end_date' => '2022-08-17 21:59',
            //     'code_err' => '',
            //     'type_value_err' => '',
            //     'limit_times_value_err' => ''
            // ];

            //validate data
            if (empty($data['code'])) {
                $data['code_err'] = 'Please enter discount code';
            } else {
                // code entered, check if it's already created
                // !! for completion: if there's a events table, this should be getCodesByEvent
                $codes = $this->codeModel->getCodesByEventId($event_id);
                foreach ($codes as $ele) {
                    // for editing(not adding), make sure the duplicate code is not itself, then show error
                    if ($data['code'] == $ele->code && $code_id != $ele->id && $ele->is_deleted == 0) {
                        echo $ele->code, $ele->id, $code_id,
                        $data['code_err'] = 'Code is already created.';
                    }
                }
            }

            if ($data["limit_times"] && empty($data['limit_times_value'])) {
                $data['limit_times_value_err'] = 'Please enter number of times';
            } else if (!$data["limit_times"] && $data['limit_times_value']) {
                $data['limit_times_value_err'] = 'Please select to limit the number of times';
            }

            if ($data['type_value'] <= 0) {
                $data['type_value_err'] = "Invalid value";
            }

            if ($data['type'] == 'percentage' && $data['type_value'] > 100) {
                $data['type_value_err'] = 'Percentage should be less than 100';
            }

            if (empty($data['customer_eligibility'])) {
                $data['customer_eligibility_err'] = 'Please select customer eligibility';
            }

            // no error
            if (empty($data['code_err']) && empty($data['type_value_err']) && empty($data['limit_times_value_err']) && empty($data['customer_eligibility_err'])) {
                // edit in model, return t/f
                if ($this->codeModel->editCode($data)) {
                    flash('edit_message', 'Discount Code Updated');
                    redirect('events_dashboard/' . $event_id . "/discount_code/" . $code_id);
                    // redirect('');
                } else {
                    die('Something went wrong');
                }
            } else {
                // echo 'error';
                // Load view with errors
                $this->view('events/editCode', $data);
            }
        }
        // GET empty input, waiting for value 
        else {
            // get current code
            $code = $this->codeModel->getCodeById($code_id);

            // check for owner
            if ($code->user_id !== $_SESSION['user_id']) {
                $this->view('pages/error', ['message' => "You don't have access to this page"]);
                die();
            }

            $data = [
                'code_id' => $code_id,
                'code' => $code->code,
                'event_id' => $code->event_id,
                'start_date' => $code->start_date,
                'end_date' => $code->end_date,
                'type' => $code->type,
                'type_value' => $code->type_value,
                'customer_eligibility' => $code->customer_eligibility,
                'limit_times' => $code->limit_times,
                'limit_times_value' => $code->limit_times_value,
                'limit_one' => $code->limit_one,
            ];
            // print_r($data);

            $this->view('events/editCode', $data);
        }
    }

    public function delete($code_id, $event_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // get the code to be deleted
            $code = $this->codeModel->getCodeById($code_id);

            // check for owner
            // echo $code->user_id,$_SESSION['user_id'];
            if ($code->user_id != $_SESSION['user_id']) {
                $this->view('pages/error', ['message' => "You don't have access to this page"]);
                die();
            }

            // mark as deleted
            if ($this->codeModel->markDeleteCode($code_id)) {
                flash('add_message', 'Code Deleted');
                redirect('events_dashboard/' . $event_id . '/discount_code');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('events_dashboard/' . $event_id . '/discount_code');
        }
    }
}
