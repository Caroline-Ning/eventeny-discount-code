<?php
class Cart extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            $data = ["message" => "Sorry. Only logged-in users have access to this page."];
            $this->view('pages/error', $data);
            die();
        }

        $this->codeModel = $this->model('Code');
        $this->userCodeModel = $this->model('UserCode');
    }

    public function index($params)
    {
        // !! for completion: we need to make sure that $params[0] is an event_id
        $event_id = $params[0];

        // try apply code, but not use code
        // cart/0, POST
        if (!$params[1] && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->apply($event_id);
            die();
        }

        // simply show cart page
        // cart/0 GET
        elseif (!$params[1]) {
            //!! for completion: the total(currently) and subtotal comes from the event_id(getEventById), instead of hard-coded
            $data = [
                "title" => "Cart",
                'event_id' => $event_id,
                'total' => '30',
                'subtotal' => '30'
            ];
            $this->view('cart/index', $data);
            die();
        }
    }

    public function checkout($params)
    {
        $event_id = $params[0];

        // cart/0/chekcout/(code_id) POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // has a valid discount code
            if ($params[1]) {
                $this->useCode($params[1]);
            }
            // checkout without discount code
            else {
                $this->view('pages/success', ['message' => 'Thank you for your order!']);
            }
        }

        // cart/0/chekcout/(code_id) GET
        else {
            redirect('cart/' . $event_id);
        }
    }

    public function useCode($id)
    {
        $code = $this->codeModel->getCodeById($id);
        // if ths code has limit use times, used times + 1
        if ($code->limit_times) {
            $this->codeModel->updateUsedTimes($id, $code->used_times);
        }

        // if the code limit once per user, mark this user use this code (add user_id - code_id to user_code table)
        if ($code->limit_one) {
            $this->userCodeModel->addUserWithCode($_SESSION['user_id'], $id);
        }

        $this->view('pages/success', ['message' => 'Thank you for your order']);
    }

    public function apply($event_id)
    {
        // POST, try applying the code
        // sanitize 
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $input = $_POST['apply'];

        $event_price = 30;
        $total = $event_price;

        // init data
        $data = [
            'apply' => trim($input),
            "title" => "Cart",
            'event_id' => 0,
            'total' => $total,
            'subtotal' => 30,
            'apply_err' => ''
        ];

        // empty input -> err
        if ($input == "") {
            $data['apply_err'] = 'Please enter coupon code';
        }

        // 1. check if this input code exists for this event
        $code = $this->codeModel->getCodeByEventAndCode($event_id, strtolower(trim($input)));

        if (!$code) {
            $data['apply_err'] = 'Invalid Coupon Code';
        }

        // 2. limit of times: how many times left for this coupon code
        if ($code->limit_times && $code->limit_times_value - $code->used_times < 1) {
            $data['apply_err'] = 'Coupon code exceed limit of times';
        }

        // 3. see if limit of once per user
        if ($code->limit_one) {
            if ($this->userCodeModel->userExistsForThisCode($_SESSION['user_id'], $code->id)) {
                $data['apply_err'] = "The same code can't be used twice";
            }
        }

        // 4. between start date and end date
        $current = date('Y-m-d H:i');
        if ($current >= $code->start_date) {
            if ($code->end_date && $current > $code->end_date) {
                $data['apply_err'] = 'Code is Inactive';
            }
        } else {
            $data['apply_err'] = 'Code is Inactive';
        }

        if (empty($data['apply_err'])) {
            // calculate total
            if ($code->type == 'percentage') {
                $total = $event_price - $event_price * 0.01 * $code->type_value;
            } else {
                $total = $event_price - $code->type_value;
            }
            if ($total < 0) {
                $total = 0;
            }

            // show updated total
            $data = [
                'valid_code_id' => $code->id,
                'apply' => $input,
                "title" => "Cart",
                'event_id' => $event_id,
                'total' => round($total, 2),
                'subtotal' => 30,
                'apply_success' => 'Successfully applied!'
            ];

            $this->view('cart/index', $data);
        } else {
            // load view with errors
            $this->view('cart/index', $data);
        }
    }
}
