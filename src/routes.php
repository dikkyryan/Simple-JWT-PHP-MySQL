
<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

return function (App $app) {
    $container = $app->getContainer();

    //memperbolehkan cors origin 
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, token')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    });

    $app->post('/login', function (Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $Username=trim(strip_tags($input['Username']));
        $Password=trim(strip_tags($input['Password']));
        $sql = "SELECT IdUser, Username  FROM `user` WHERE Username=:Username AND `Password`=:Password";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("Username", $Username);
        $sth->bindParam("Password", $Password);
        $sth->execute();
        $user = $sth->fetchObject();       
        if(!$user) {
            return $this->response->withJson(['status' => 'error', 'message' => 'These credentials do not match our records username.'],200);  
        }
        $settings = $this->get('settings');       
        $token = array(
            'IdUser' =>  $user->IdUser, 
            'Username' => $user->Username
        );
        $token = JWT::encode($token, $settings['jwt']['secret'], "HS256");
        return $this->response->withJson(['status' => 'success','data'=>$user, 'token' => $token],200); 
    });

    $app->post('/register', function (Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $Username=trim(strip_tags($input['Username']));
        $NamaLengkap=trim(strip_tags($input['NamaLengkap']));
        $Email=trim(strip_tags($input['Email']));
        $NoHp=trim(strip_tags($input['NoHp']));
        $Password=trim(strip_tags($input['Password']));
        $sql = "INSERT INTO user(Username, NamaLengkap, Email, NoHp, Password) 
                VALUES(:Username, :NamaLengkap, :Email, :NoHp, :Password)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("Username", $Username);             
        $sth->bindParam("NamaLengkap", $NamaLengkap);            
        $sth->bindParam("Email", $Email);                
        $sth->bindParam("NoHp", $NoHp);      
        $sth->bindParam("Password", $Password); 
        $StatusInsert=$sth->execute();
        if($StatusInsert){
            $IdUser=$this->db->lastInsertId();     
            $settings = $this->get('settings'); 
            $token = array(
                'IdUser' =>  $IdUser, 
                'Username' => $Username
            );
            $token = JWT::encode($token, $settings['jwt']['secret'], "HS256");
            $dataUser=array(
                'IdUser'=> $IdUser,
                'Username'=> $Username
                );
            return $this->response->withJson(['status' => 'success','data'=>$dataUser, 'token'=>$token],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error insert user.'],200); 
        }
    });

    $app->group('/api', function(\Slim\App $app) {
        //letak rute yang akan kita autentikasi dengan token

        //ambil data user berdasarkan id user
        $app->get("/user/{IdUser}", function (Request $request, Response $response, array $args){
            $IdUser = trim(strip_tags($args["IdUser"]));
            $sql = "SELECT IdUser, Username, NamaLengkap, Email, NoHp FROM `user` WHERE IdUser=:IdUser";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("IdUser", $IdUser);
            $stmt->execute();
            $mainCount=$stmt->rowCount();
            $result = $stmt->fetchObject();
            if($mainCount==0) {
                return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
            }
            return $response->withJson(["status" => "success", "data" => $result], 200);
        });

        //ambil semua data produk
        $app->get("/produkAll", function (Request $request, Response $response, array $args){
            $sql = "SELECT * FROM produk";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $mainCount=$stmt->rowCount();
            $result = $stmt->fetchAll();
            if($mainCount==0) {
                return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
            }
            return $response->withJson(["status" => "success", "data" => $result], 200);
        });

        //ambil data produk berdasarkan id produk
        $app->get("/produk/{IdProduk}", function (Request $request, Response $response, array $args){
            $IdProduk = trim(strip_tags($args["IdProduk"]));
            $sql = "SELECT * FROM produk WHERE IdProduk=:IdProduk";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("IdProduk", $IdProduk);
            $stmt->execute();
            $mainCount=$stmt->rowCount();
            $result = $stmt->fetchObject();
            if($mainCount==0) {
                return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
            }
            return $response->withJson(["status" => "success", "data" => $result], 200);
        });

        //menyimpan data produk
        $app->post('/produk', function (Request $request, Response $response, array $args) {
            $input = $request->getParsedBody();
            $KodeProduk=trim(strip_tags($input['KodeProduk']));
            $NamaProduk=trim(strip_tags($input['NamaProduk']));
            $HargaJual=trim(strip_tags($input['HargaJual']));
            $Stok=trim(strip_tags($input['Stok']));
            $sql = "INSERT INTO produk(KodeProduk, NamaProduk, HargaJual, Stok) 
                VALUES(:KodeProduk, :NamaProduk, :HargaJual, :Stok)";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("KodeProduk", $KodeProduk);             
            $sth->bindParam("NamaProduk", $NamaProduk);            
            $sth->bindParam("HargaJual", $HargaJual);                
            $sth->bindParam("Stok", $Stok);      
            $StatusInsert=$sth->execute();
            if($StatusInsert){
                return $this->response->withJson(['status' => 'success','data'=>'success insert produk.'],200); 
            } else {
                return $this->response->withJson(['status' => 'error','data'=>'error insert produk.'],200); 
            }
        });

        //update data produk berdasarkan id produk
        $app->put('/produk/{IdProduk}', function (Request $request, Response $response, array $args) {
            $input = $request->getParsedBody();
            $IdProduk = trim(strip_tags($args["IdProduk"]));

            $KodeProduk=trim(strip_tags($input['KodeProduk']));
            $NamaProduk=trim(strip_tags($input['NamaProduk']));
            $HargaJual=trim(strip_tags($input['HargaJual']));
            $Stok=trim(strip_tags($input['Stok']));
            $sql = "UPDATE produk SET KodeProduk=:KodeProduk, NamaProduk=:NamaProduk, HargaJual=:HargaJual, Stok=:Stok WHERE IdProduk=:IdProduk";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("IdProduk", $IdProduk);
            $sth->bindParam("KodeProduk", $KodeProduk);              
            $sth->bindParam("NamaProduk", $NamaProduk);            
            $sth->bindParam("HargaJual", $HargaJual);                
            $sth->bindParam("Stok", $Stok);      
            $StatusUpdate=$sth->execute();
            if($StatusUpdate){
                return $this->response->withJson(['status' => 'success','data'=>'success update produk.'],200); 
            } else {
                return $this->response->withJson(['status' => 'error','data'=>'error update produk.'],200); 
            }
        });

        //delete data produk berdasarkan id produk
        $app->delete('/produk/{IdProduk}', function (Request $request, Response $response, array $args) {
            $input = $request->getParsedBody();
            $IdProduk = trim(strip_tags($args["IdProduk"]));

            $sql = "DELETE FROM produk WHERE IdProduk=:IdProduk";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("IdProduk", $IdProduk);    
            $StatusDelete=$sth->execute();
            if($StatusDelete){
                return $this->response->withJson(['status' => 'success','data'=>'success delete produk.'],200); 
            } else {
                return $this->response->withJson(['status' => 'error','data'=>'error delete produk.'],200); 
            }
        });
        
    });
};