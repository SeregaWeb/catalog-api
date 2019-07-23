<?php 
class shop 
{
    private $autoCatalog;
    private $con;
    public function __construct()
    {
        $db = new db;
        $this->con = $db->getConnection();
        
    }
    function show()
    {
        print_r($this->autoCatalog);
    }

    function get_all()
    {
        $resultArray = array();

        foreach($this->con->query('SELECT Cars.id, CarsModel.name, model 
        from Cars,CarsModel 
        where id_name = CarsModel.id') as $row) {
            $tmp_arr = array('id'=>$row['id'],'model'=>$row['model'],'name'=>$row['name']);
            array_push($resultArray, $tmp_arr); 
        }
       
        return json_encode($resultArray);
    }

    function get_orders($id)
    {
        $resultArray = array();

        foreach($this->con->query('SELECT model, first_name , orders , price 
        from Cars, CarsOrders
        where Cars.id = id_car AND id_user = '.$id  ) as $row) {
            $tmp_arr = array('model'=>$row[0],'name'=>$row[1],'order'=>$row['orders'],'price'=>$row['price']);
            array_push($resultArray, $tmp_arr); 
        }
       
        return json_encode($resultArray);
    }
    function get_one($id)
    {
        $resultArray = array();
       
        $stmt = $this->con->prepare("SELECT Cars.id, CarsModel.name, model , year , engin , color, max_speed, price
        FROM Cars,CarsModel WHERE id_name = CarsModel.id  
        AND Cars.id = ?");
        $stmt->execute([$id]); 
        $row = $stmt->fetch();

            $tmp_arr = array(
            'id'=>$row['id'],    
            'modelName'=>$row['name'].":".$row['model'],
            'year'=>$row['year'],
            'engine'=>$row['engin'],
            'color'=>$row['color'],
            'maxspeed'=>$row['max_speed'],
            'price'=>$row['price']);
            array_push($resultArray, $tmp_arr); 
        
        return json_encode($resultArray);
    }

    function get_search($searchParam, $val, $year)
    {
        $resultArray = array();
        
        $que = 'SELECT Cars.id, CarsModel.name, model , year , engin , color, max_speed, price 
        from Cars,CarsModel 
        where '.$searchParam.' = "'.$val.'" AND id_name = CarsModel.id AND year = '.$year;
        
        
        $stmt = $this->con->prepare($que);
        // print_r($stmt);
        $stmt->execute();
        $res = $stmt->fetchAll();
        foreach($res as $row) {
            $tmp_arr = array(
                'id'=>$row['id'],    
                'modelName'=>$row['name'].":".$row['model'],
                'year'=>$row['year'],
                'engine'=>$row['engin'],
                'color'=>$row['color'],
                'maxspeed'=>$row['max_speed'],
                'price'=>$row['price']);
                array_push($resultArray, $tmp_arr); 
        }
       
        return  json_encode($resultArray);
      
    }
    function post_bue($idAuto ,$fname, $lname, $order , $idUser){
        $sql = "INSERT INTO CarsOrders (id_car, first_name, last_name , orders , id_user) VALUES (?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        if( $stmt->execute([$idAuto,$fname, $lname, $order, $idUser])){
            return json_encode(array('ok'));
        }else{
            return json_encode(array('error server'));
        }
    } 
}

// //header('Content-Type: application/pdf');
// // Он будет называться downloaded.pdf
// //header('Content-Disposition: attachment; filename="downloaded.pdf"');
// // Исходный PDF-файл original.pdf
// //readfile('original.pdf');

// //header('Content-Type: text/javascript');
// //header('Content-Type: text/css');
// //header('Content-Type: text/html; charset=utf-8'); 
// //header('Content-Type: image/gif'); 
// //header('Content-Type: image/png'); 
// //header('Content-Type: image/jpg'); 
// //header('Content-Type: application/json');
// //header("Location: http://www.example.com/");
// //header("HTTP/1.0 404 Not Found");

// class Test
// {
//     protected $url;
//     protected $method;
//     protected $parameters;

//     function __construct()
//     {
//         $this->url = explode('/',$_SERVER['REQUEST_URI']);
//         $isApi = false;
//         $isMethod = false;
//         $parameters = [];

//         //PARSING URL
//         foreach($this->url as $value)
//         {
//             $value = $this->validator($value);


//             if ($isApi)
//             {
//                 $this->parameters[] = $value;
//             }

//             if (strtolower(trim($value)) == 'api')
//             {
//                 $isApi = true;
//             }

//         }
//         $this->method = $this->parameters[0];
//         $this->methodCheck($this->method);
//     }


//     function validator($str)
//     {
//         $str = htmlspecialchars(trim($str));
//         return $str;
//     }


//         ///METHODS SELECTOR
//     function methodCheck($method)
//     { 
//         switch($method) 
//         {
//         case 'sayhello':
//             if (count($this->parameters) > 0)
//             {
//                 $this->sayHello($this->parameters[1]);
//             }else{$this->sayHello();}
        
//             break;

//         case 1:
//             echo "i равно 1";
//             break;
//         case 2:
//             echo "i равно 2";
//             break;
//         }
//     }


//     function sayHello($name = false)
//     {
//         if (!$name)
//         $res = 'Hello guest!';
//         if ($name)
//         $res = 'Hello, ' . $name . '!';
//         header('Content-Type: application/json'); 
//         echo json_encode(['echo'=>$res]);
//     }


// }

// $cl = new Test($_SERVER['REQUEST_METHOD']);
// echo "<pre>";
// echo 'REQUEST Method:';
// print_r($_SERVER['REQUEST_METHOD']);
// echo "\n";
// $arr = explode('/',$_SERVER['REQUEST_URI']);
// echo 'api Method: ' . $arr[4];
// echo " \n";
// if (isset($arr[5]) && !empty($arr[5]))
// {
//     echo 'parameter 1: ' . $arr[5];
//     echo " \n";
// }
// echo " URL: \n";
// print_r($_SERVER['REQUEST_URI']);
// // $data = [
// // 'remote_host'=>$_SERVER['REMOTE_ADDR']
// // ];
// // $data ['url'] = explode('/',$_SERVER['REQUEST_URI']);
// // echo json_encode($data);