 <?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Controller.php";

class P_Controller extends MX_Controller {

    public $user_logged_in=false;
    public $user_name=null;
    public $user_full_name=null;
    public $user_role_id=null;
    public $user_role_name=null;
    public $user_role_identifier=null;
    public $user_division_id=null;
    public $user_status=null;
    public $acc_permission_bypass=0;
    public $acc_login_bypass=0;
    public $acc_permission=false;
    public $acc_privilages=array();
    public $sys_module=null;
    public $sys_controller=null;
    public $sys_methods=null;
    public $sys_breadcrumb=null;
    public $reff=null;
    public $current_url=null;

    function __construct(){
        parent::__construct();
        $this->load->model('M_home');
        $this->load->model('M_site');
        date_default_timezone_set('Asia/Makassar');
    }

}
