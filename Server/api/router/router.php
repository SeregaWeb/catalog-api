<? 

class router 
{
    public $method;

    public function run()
    {
        // $url =  $_SERVER['REQUEST_URI'];
        $path = explode('/',$_SERVER['REQUEST_URI']);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $controller = $path[5];
        $action = $path[6];

        $param = $path[7];
        $param2 = $path[8];
        $param3 = $path[9];
        $param4 = $path[10];
        $param5 = $path[11];
        // echo $this->method."/".$action."/".sizeof($param);
        
        switch($this->method)
        {
            case 'GET':
                if($action == ''){
                    $action = DEFOULT_ACTION;
                }
                $lastMet = mb_strtolower($this->method)."_".$action; 
                break;
            case 'DELETE':
                //  $this->setMethod('delete', explode('/', $path));
                break;
            case 'POST':
                $lastMet = mb_strtolower($this->method)."_".$action; 
                break;
            case 'PUT':
                $lastMet = mb_strtolower($this->method)."_".$action; 
                break;
            default:
                return false;
        }  
        
        switch($controller)
        {
            case 'shop':
                $catalog = new shop;
                header('Content-Type: application/json');
                echo ($catalog->{$lastMet}($param , $param2 , $param3 , $param4 , $param5)) ;
                
                break;
            case 'user';
                $user = new user;
                header('Content-Type: application/json');
                print_r($user->{$lastMet}($param , $param2 , $param3 ,$param4 , $param5)) ;
                break;
            default:
                return false;
        }
    }
    
    // CREATE TABLE auth_user (
    //     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     login VARCHAR(30) NOT NULL UNIQUE,
    //     email VARCHAR(50) NOT NULL UNIQUE,
    //     online BOOLEAN NOT NULL
    // );

}