<?php
/*
    functions:
    split url, find out the controller, method, params in the link

    possible url: 
    /events_dashboard/event_id/discount_code/code_id/show|edit|delete
    /events_dashboard/event_id/discount_code/add
    /cart/event_id/apply
    /users/register
    /users/login|logout
*/

class Core
{
    // if url="", go to Pages.index() -> view: home
    protected $currentController = 'Pages';
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // check for url first part, see if it is a controller
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if events_dashboard.php exists, set as controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        // requrire the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // instantiate controller class
        $this->currentController = new $this->currentController;

        // check for url second part
        if (isset($url[1])) {
            // check to see if method exists under current controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // check for url third part
        // eg. /events_dashboard/0/discount_code(third part)/2
        if (isset($url[2])) {
            // check to see if method exists under current controller
            if (method_exists($this->currentController, $url[2])) {
                $this->currentMethod = $url[2];
                unset($url[2]);
            }
        }

        // check for the remains in url, get params
        $this->params = $url ? array_values(($url)) : [];

        // var_dump($this->currentController, $this->currentMethod);
        // call a callback with array of params
        call_user_func_array(([$this->currentController, $this->currentMethod]), [$this->params]);
    }

    public function getUrl()
    {
        // remove "/" at the end of url, the split it into an array
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // split url eg. code/1/edit -> [code,1,edit]
            $url = explode('/', $url);
            return $url;
        }
    }
}
