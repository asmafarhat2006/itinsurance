<?php namespace App\Controllers;

class ProductController extends BaseController
{
    public function __construct()
    {
    
    }
    public function index()
    {
        return view('welcome_message');
    }
    public function listProducts()
    {
        try{
        $client = \Config\Services::curlrequest(
            ['base_uri' => 'https://www.itccompliance.co.uk/recruitment-webservice/api/','timeout' => 1,'http_errors' => false,
            ]
        );
        $responseData = $this->callRecruitmentWebService($client, 'list');
        $strProductsHTML  = '';
        if($responseData == false) {
            $strProductsHTML  = 'Data Source error Try Again';
            $data["productsHTML"] = $strProductsHTML;
            return view('viewproducts', $data);
        }
        $productsArray = $responseData["products"];
        foreach($responseData["products"] as $key=>$value)
        {
            //echo 'ProductID '.$key.' value : '.$value;
            $productData = $this->callRecruitmentWebService($client, 'info?id='.$key);
            if($productData !== false) { 
                $productsArray[$key] = $productData[$key];
            }
        }
        
        foreach($productsArray as $pid=>$pinfo){
                
            if(is_array($productsArray[$pid])) {
                $pinfoArray = $productsArray[$pid];
                $htmlHead = $htmlFooter = $htmlBody = '';
                
                if(count($pinfoArray) > 0) {
                    $htmlHead   .= '<div class="col-lg-4"><img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">';
                    $htmlFooter .= '</div>';
                }
                foreach($pinfoArray as $key=>$value){
                    if($key == 'name') {$htmlBody .= '<h3>'.$value.'</h3>';
                    }
                    else if(is_array($value)) { $htmlBody .= '<p>'.ucfirst($key).': '.implode(",", $value).'</p>';
                    }else{$htmlBody .= '<p>'.ucfirst($key).': '.$value.'</p>';
                    }
                }
                $strProductsHTML .= $htmlHead.$htmlBody.$htmlFooter;
                /*$strProductsHTML.= implode($pinfoArray);
                $pinfoArray["name"] .'</h2><p>'.$pinfoArray["description"].'</p>';
                if( array_key_exists("type",$pinfoArray)!==false){
                $strProductsHTML .= '<p>Type : '.$pinfoArray["type"].' </p>'; 
                }
                if( array_key_exists("suppliers",$pinfoArray)!==false){
                $strProductsHTML .= '<p>Suppliers: '.implode(",",$pinfoArray["suppliers"]).'</p></div>';
                }*/
            }
            else{
                $strProductsHTML.= '<div class="col-lg-4"><img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140"><h3>'.$pinfo .'</h3><p>No Details available</p></div>';
            }
        }
        $data["productsHTML"] = $strProductsHTML;
        
        return view('viewproducts', $data);
        }
		catch(\CodeIgniter\HTTP\Exceptions\HTTPException $e){
			$strProductsHTML  = 'Exception '.$e->getMessage();
            $data["productsHTML"] = $strProductsHTML;
            return view('viewproducts', $data);
        	
		}
    }
    public function callRecruitmentWebService($client,$url)
    {
        
        $response = $client->request(
            'get', $url, [
            'headers' => ['Content-Type'     => 'application/json'
            ],'verify' => false,'debug' => true]
        );
        
        $responseData = json_decode($response->getBody(), true);
        if(array_key_exists('error', $responseData)) {
            return false;
        }
        return $responseData;
    
    }
    public function listProducts1()
    {
        // set HTTP header for json 
        $headers = array('Content-Type: application/json');

        // set the url for the service you are contacting 
        // example has an id that is passed 
        $url = 'https://www.itccompliance.co.uk/recruitment-webservice/api/list'; 

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // this is controversial 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
        return $result;
        // get the result and parse to JSON
        $something = json_decode($result);

        if(isset($something)) { return $something ; 
        }

        else { return 'Products errlisted';
        }//return FALSE ; } 
        
    }
    //--------------------------------------------------------------------

}
