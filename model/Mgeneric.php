<?php 

 ini_set('display_errors', 1);

Class Action{

    private $db;

	public function __construct() {
		ob_start();
        session_start();
   	include '../config/database.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

 function load_category(){

    $query = "SELECT * from Category";
    $result = mysqli_query($this->db,$query);
    $rows = [];
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;

    }

    function save_generic(){

        extract($_POST);

        $errorMSG = "";

        /* NAME */
        if (empty($name)) {
            $errorMSG = "<li>Name is required</<li>";
        } 

        /* category */
        if (empty($category)) {
            $errorMSG .=  "<li>Category is required</<li>";
        } 

        if(empty($errorMSG)){
		$data = " name = '$name' ";
        $data .= ", Category_category_id = '$category' ";
        $data .= ", current_stock_level = '$current_stock' ";
        $data .= ", reorder_stock_level = '$reorder_stock' ";
        $data .= ", buffer_stock_level = '$buffer_stock' ";
        $data .= ", total_space = '$total_space' ";
        $data .= ", total_req_per_year = '$year_consumption' ";
        $data .= ", monthly_consumption = '$monthly_consumption' ";
        $data .= ", lead_time = '$lead_time' ";
        $data .= ", purchese_amount = '1' ";
        $data .= ", status = '$status' ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO Generic set ".$data);
		}else{
            $data .= ", Active = '$active' ";
			$save = $this->db->query("UPDATE Generic set ".$data." where generic_id=".$id);
		}

		if($save)
			return 1;
        }

        return $errorMSG;

	}

    function load_supplier_info(){

    $id = $_POST["id"];
    $query = "SELECT * from Supplier where supplier_id = $id ";
    $result = mysqli_query($this->db,$query);
    $row = mysqli_fetch_assoc($result);
    return $row;

    }



    function send_mail_to_supplier(){

        $quantity = $_POST["quantity"]; 
        if(isset($_POST["supp_id"])){
            $supp_id_arr = $_POST["supp_id"];
        }else{
            $supp_id_arr = "";
        }
        // $supp_id_arr = $_POST["supp_id"];
        $gen_id = $_POST["gen_id"];  
        $errorMSG = "";
        
        /* quantity */
        if (empty($quantity)) {
            $errorMSG .=  "<li>Quantity is required</<li>";
        } 

        if (!is_numeric($quantity)) {
            $errorMSG .=  "<li>Quantity is invalid</<li>";
        }

        if (empty($supp_id_arr)) {
            $errorMSG .=  "<li>Sppliers are required</<li>";
        } 
        
        if(empty($errorMSG)){

        $data = " Generic_generic_id = '$gen_id' ";
        $data .= ", quantity = '$quantity' ";
        $data .= ", quote_value = '0' ";
        $data .= ", generic_order_status = '1' ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

        $save = $this->db->query("INSERT INTO GenericRequest set ".$data);
        $last_id = $this->db->insert_id;

        $query_for_gen = "SELECT * from Generic where generic_id = $gen_id ";
        $result_for_gen = mysqli_query($this->db, $query_for_gen);
        $row_for_gen = mysqli_fetch_assoc($result_for_gen);
        if($row_for_gen){
            $gen_name=$row_for_gen["name"];

        }else{
            $gen_name="";

        }

        if($save){
            foreach ($supp_id_arr as $supp_id) {

                $supplier_info = $this->load_supplier_info_by_id($supp_id);
                
                $supplier_id = $supplier_info["supplier_id"];
                    $data1 = " generic_request_id = '$last_id' ";
                    $data1 .= ", Supplier_supplier_id = '$supplier_id' ";
                    $data1 .= ", supplier_acceptance = 'Pending' ";
                    $data1 .= ", request_status = '1' ";
                    $data1 .= ", create_date = '".date('Y-m-d H:i:s')."' ";
            
                    $save1 = $this->db->query("INSERT INTO GenericRequestSupplier set ".$data1);
                if($save1){
                    $res = $this->send_mail($supplier_info["email"],$quantity,$gen_name,$type = "supp");
                }
            }
        }
      
        }else{
            return $errorMSG;
        }
            return 1;

    }

    function send_mail($to_mail,$quantity,$generic,$type){
        
        require_once('mail/class.phpmailer.php');
    
        $mail = new PHPMailer();
    
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Username   = "eosusala@gmail.com";
        $mail->Password   = "eosusala@123";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
    
        $mail->SetFrom('eosusala@gmail.com', 'E OsuSala');
        $mail->Subject    = "Request for Quotation";

        if($type == "supp"){

        $body = "Dear Sir/Madam,\n \n
        We need $quantity from the generic product $generic for our business. If interested, please send us your quote
        through the portal & we’ll inform you after the evaluation if your price is compatible for us.\n\n    
        Thanks & regards,\n
        E-Osu Sala team\n";

        $subject = "Request for Quotation";
        }else{

        $body = "Dear Sir/Madam,\n\n
        You have been awarded for the previous quotation which you have made for the generic product $generic. Please check 
        your portal for more details.\n \n   
        Thanks & regards,\n
        E-Osu Sala team\n"; 

        $subject = "Purchase order for the award";
        }


        $mail->Body    = $body;
    
        $mail->AddAddress($to_mail, "Recipient name");
    
        if(!$mail->Send()) {
            return  $mail->ErrorInfo;
    }
        return 1;
    }

    
    function load_product_info(){

        $id = $_POST["id"];
        $query = "SELECT * from Product where product_id = $id ";
        $result = mysqli_query($this->db,$query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    
        }

        /* supplier response */
        function save_generic_response(){

            extract($_POST);
            // print_r($_POST);die;
    
            $errorMSG = "";
    
            /* Product */
            if (empty($product)) {
                $errorMSG = "<li>Product is required</<li>";
            } 
    
            /* Quantity */
            if (empty($quantity)) {
                $errorMSG .=  "<li>Quantity is required</<li>";
            } 

            if (!is_numeric($quantity)) {
                $errorMSG .=  "<li>Quantity is invalid</<li>";
            }

            /* Price */
            if (empty($price)) {
                $errorMSG .=  "<li>Price is required</<li>";
            }

            if (!is_numeric($price)) {
                $errorMSG .=  "<li>Price is invalid</<li>";
            }
    
            if(empty($errorMSG)){
            $data = " GenericRequest_generic_request_id = '$gen_req_id' ";
            $data .= ", GenericRequestSupplier_id = '$gen_req_supp_id' ";
            $data .= ", Product_product_id = '$product' ";
            $data .= ", quantity = '$quantity' ";
            $data .= ", price = '$price' ";
            $data .= ", deliverydate = '$deliverydate' ";
            $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";
    
            if(empty($id)){
                $save = $this->db->query("INSERT INTO GenericResponse set ".$data);
            }
            if($save)
                return 1;
            }
    
            return $errorMSG;
    
        }


 function load_product_by_gen_id(){

    $gen_req_id = $_POST["gen_req_id"];
    $supp_id = $_SESSION["SUID"];
    $query = "SELECT * from GenericRequest 
    INNER JOIN Product ON Product.Generic_generic_id = GenericRequest.Generic_generic_id
    WHERE GenericRequest.generic_request_id = $gen_req_id AND Product.Supplier_supplier_id = $supp_id
    ";
    $result = mysqli_query($this->db,$query);
    $rows = [];
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;

    }

    function save_supplier(){

        extract($_POST);

        $errorMSG = "";

        /* NAME */
        if (empty($FirstName)) {
            $errorMSG = "<li>Name is required</<li>";
        } 


         if (empty($Gender)) {
            $errorMSG .=  "<li>Gender is required</<li>";
        } 

        if (empty($Address)) {
            $errorMSG .=  "<li>Address is required</<li>";
        } 

        if (empty($ContactNo)) {
            $errorMSG .=  "<li>ContactNo is required</<li>";
        } 

        if (!is_numeric($ContactNo)) {
            $errorMSG .=  "<li>ContactNo is invalid</<li>";
        }

        if (!is_numeric($Age)) {
            $errorMSG .=  "<li>Age is invalid</<li>";
        }

        if (empty($Email)) {
            $errorMSG .=  "<li>Email is required</<li>";
        } 

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errorMSG .= "<li>Invalid email format</<li>";
        }

        if (empty($Password)) {
            $errorMSG .=  "<li>Password is required</<li>";
        } 
        if ($Password !== $ConfirmPassword) {
            $errorMSG .=  "<li>Password and Confirm password should match</<li>";  
    }

        if(empty($errorMSG)){
        
        $password = sha1($Password);
		$data = " Role_role_id = 1 ";
        $data .= ", firstname = '$FirstName' ";
        $data .= ", lastname = '$LastName' ";
        $data .= ", gender = '$Gender' ";
        $data .= ", address = '$Address' ";
        $data .= ", contactNo = '$ContactNo' ";
        $data .= ", email = '$Email' ";
        $data .= ", password = '$password' ";
        $data .= ", age = '$Age' ";
        $data .= ", city = '$City' ";
        $data .= ", Active = 1 ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO Supplier set ".$data);
            return 1;
		}else{
            $data .= ", update_date = '".date('Y-m-d H:i:s')."' ";
			$save = $this->db->query("UPDATE Supplier set ".$data." where supplier_id=".$id);
            return 1;
		}
		
        }

        return $errorMSG;

	}

    function save_company(){

        extract($_POST);

        $errorMSG = "";

        /* NAME */
        if (empty($name)) {
            $errorMSG = "<li>Name is required</<li>";
        } 

        /* category */
        if (empty($reg_no)) {
            $errorMSG .=  "<li>Reg_no is required</<li>";
        } 

        if (!is_numeric($contact)) {
            $errorMSG .=  "<li>ContactNo is invalid</<li>";
        }

        if (empty($email)) {
            $errorMSG .=  "<li>Email is required</<li>";
        } 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMSG .= "<li>Invalid email format</<li>";
        }

        if(empty($errorMSG)){
        $supp_id = $_SESSION["SUID"];
		$data = " name = '$name' ";
        $data .= ", Supplier_supplier_id = '$supp_id' ";
        $data .= ", address = '$address' ";
        $data .= ", contactNo = '$contact' ";
        $data .= ", email = '$email' ";
        $data .= ", regnNo = '$reg_no' ";
        $data .= ", city = '$city' ";
        $data .= ", year_established = '$year_estab' ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO SupplierCompany set ".$data);
		}else{
            $data .= ", Active = '$active' ";
			$save = $this->db->query("UPDATE SupplierCompany set ".$data." where company_id=".$id);
		}
		if($save)
			return 1;
        }

        return $errorMSG;

	}

 function remove_product(){

    $product_id = $_POST["product_id"];
    $save = $this->db->query("DELETE FROM Product WHERE product_id = $product_id ");

    if($save)
		return 1;
 }

 function load_supplier_info_by_id($id){

    $query = "SELECT * from Supplier where supplier_id = $id ";
    $result = mysqli_query($this->db,$query);
    $row = mysqli_fetch_assoc($result);
    return $row;

    }

    function quality_evo(){

        $query = "SELECT Product . *,GenericResponse.generic_response_id
        FROM GenericResponse
        INNER JOIN Product ON Product.product_id = GenericResponse.Product_product_id
        INNER JOIN Generic ON Generic.generic_id = Product.Generic_generic_id
        WHERE GenericResponse.quality_evaluate_status = 0
        ";
        $result = mysqli_query($this->db,$query);
        $rows = [];
        while($row = $result->fetch_assoc()) {
            $product_name = $row["name"];
            $product_NMRA = $row["NMRA_regno"];
            $id = $row["generic_response_id"];
            $this->update_quality_status($id,$product_name,$product_NMRA);
        }
        return 1;

    }

    /* update the quality status to 1 for quality fulfilled products & failed to 1 */
    function update_quality_status($id,$product_name,$product_NMRA){

        // print_r($product_NMRA);die;

        $query = "SELECT * from NRMI where productname = '$product_name' AND regno = '$product_NMRA' ";
        $result = mysqli_query($this->db,$query);
        if($result){
            $query1 = "UPDATE GenericResponse SET quality_evaluate_status = 1 where generic_response_id = $id ";
            $result1 = mysqli_query($this->db,$query1);
        }else{
            $query1 = "UPDATE GenericResponse SET quality_evaluate_status = 2 where generic_response_id = $id ";
            $result1 = mysqli_query($this->db,$query1);

        }
        return 1;
    
        }


    function send_mail_to_supplier_award(){

        extract($_POST);

        $errorMSG = "";
        
        if (empty($supplier_id)) {
            $errorMSG = "<li>Supplier is required</<li>";
        } 

        if (empty($gen_res_id)) {
            $errorMSG .=  "<li>Gen Res ID is required</<li>";
        } 

        if (!is_numeric($generic_id)) {
            $errorMSG .=  "<li>Generic is invalid</<li>";
        }

        if (empty($email)) {
            $errorMSG .=  "<li>Email is required</<li>";
        } 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMSG .= "<li>Invalid email format</<li>";
        }

        if(empty($errorMSG)){

        $data = " GenericResponse_generic_response_id = '$gen_res_id' ";
        $data .= ", Supplier_supplier_id = '$supplier_id' ";
        $data .= ", Generic_generic_id = '$generic_id' ";
        $data .= ", status = 'Pending' ";
        $data .= ", product_id = '$product_id' ";
        $data .= ", quantity = '$quantity' ";
        $data .= ", delevery_date = '$del_date' ";
        $data .= ", price = '$price' ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

        $save = $this->db->query("INSERT INTO Awarded set ".$data);
        $update = $this->db->query("UPDATE GenericRequest SET quote_value = quote_value+$quantity WHERE generic_request_id = $gen_req_id AND generic_order_status = 1 ");

        if($save){
            $res = $this->send_mail($email,$quantity, $generic_id,$type = "supp_award");
        }
      
        }else{
            return $errorMSG;
        }
            return 1;

    }

    function accept_award(){

        $id = $_POST["id"];
        $res_id = $_POST["res_id"];    
        
        if($id){
            $update = $this->db->query("UPDATE Awarded set status = 'Accepted' where award_id=".$id);
            $update1 = $this->db->query("UPDATE GenericResponse set award_acceptance = 'Accepted' where generic_response_id=".$res_id);
            return 1;
        }else{
            return 0;
        }
    }

    function reject_award(){

        $id = $_POST["id"];
        $res_id = $_POST["res_id"];
        if($id){
            $update = $this->db->query("UPDATE Awarded set status = 'Rejected' where award_id=".$id);
            $update1 = $this->db->query("UPDATE GenericResponse set award_acceptance = 'Rejected' where generic_response_id=".$res_id);

            return 1;
        }else{
            return 0;
        }
    }


    function reject_generic_request(){

        $id = $_POST["id"];

        if($id){
            $update = $this->db->query("UPDATE GenericRequest set Active = 0 where generic_request_id=".$id);
            return 1;
        }else{
            return 0;
        }
    }

    function load_generic_request_info(){

        $id = $_POST["id"];
        $query = "SELECT * from GenericRequest where Generic_generic_id = $id AND generic_order_status = 1 ";
        $result = mysqli_query($this->db,$query);
        $row = mysqli_fetch_assoc($result);
        if($row){
            return $row;
        }else{
            return -1;
        }
        
    
        }    
        
        // getting the stocks to the inventory
        function rec_award(){

            $id = $_POST["id"];
    
            if($id){
                $update = $this->db->query("UPDATE Awarded set received_status = 1 where award_id=".$id);

                $generic_id = $_POST["gen_id"]; 
                $quantity = $_POST["quantity"]; 
                
                $update2 = $this->db->query("UPDATE Generic set current_stock_level = current_stock_level+$quantity where generic_id=".$generic_id);
                $date = date("Y-m-d H:i:s");
                $save2 = $this->db->query(" INSERT INTO  Stock_log set create_date = '$date', status = 'Purchase', amount = ".$quantity.", gen_id_scrap = ".$generic_id);
                
                return 1;
            }else{
                return 0;
            }
        }


    function save_customer(){

        extract($_POST);

        $errorMSG = "";

        /* NAME */
        if (empty($FirstName)) {
            $errorMSG = "<li>Name is required</<li>";
        } 


         if (empty($Gender)) {
            $errorMSG .=  "<li>Gender is required</<li>";
        } 

        if (empty($Address)) {
            $errorMSG .=  "<li>Address is required</<li>";
        } 

        if (empty($ContactNo)) {
            $errorMSG .=  "<li>ContactNo is required</<li>";
        } 

        if (!is_numeric($ContactNo)) {
            $errorMSG .=  "<li>ContactNo is invalid</<li>";
        }

        if (!is_numeric($Age)) {
            $errorMSG .=  "<li>Age is invalid</<li>";
        }

        if (empty($Email)) {
            $errorMSG .=  "<li>Email is required</<li>";
        } 

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errorMSG .= "<li>Invalid email format</<li>";
        }

        if (empty($Password)) {
            $errorMSG .=  "<li>Password is required</<li>";
        } 
        if ($Password !== $ConfirmPassword) {
            $errorMSG .=  "<li>Password and Confirm password should match</<li>";  
    }

        if(empty($errorMSG)){
        
        $password = sha1($Password);
		$data = " Role_role_id = 2 ";
        $data .= ", firstname = '$FirstName' ";
        $data .= ", lastname = '$LastName' ";
        $data .= ", gender = '$Gender' ";
        $data .= ", address = '$Address' ";
        $data .= ", contactNo = '$ContactNo' ";
        $data .= ", email = '$Email' ";
        $data .= ", password = '$password' ";
        $data .= ", age = '$Age' ";
        $data .= ", city = '$City' ";
        $data .= ", Active = 1 ";
        $data .= ", create_date = '".date('Y-m-d H:i:s')."' ";

		if(empty($cus_id)){
            
			$save = $this->db->query("INSERT INTO Customer set ".$data);
            return 1;
		}else{
            $data .= ", update_date = '".date('Y-m-d H:i:s')."' ";
			$save = $this->db->query("UPDATE Customer set ".$data." where customer_id=".$cus_id);
            return 1;
		}
		
        }

        return $errorMSG;

	}

    function add_quantity(){

        $id = $_POST["id"];
        $qty = $_POST["quantity"];
        $price = $_POST["price"];
        $save = $this->db->query(" UPDATE Bill_item SET quantity = quantity+1, amount = $price*($qty)  WHERE bill_item_id = $id ");
    
        if($save)
            return 1;
     }

     function deduct_quantity(){

        $id = $_POST["id"];
        $qty = $_POST["quantity"];
        $price = $_POST["price"];
        $save = $this->db->query(" UPDATE Bill_item SET quantity = quantity-1, amount = $price*($qty)  WHERE bill_item_id = $id ");
    
        if($save)
            return 1;
     }


    function save_scrap(){

        extract($_POST);

        $errorMSG = "";

        /* NAME */
        if (empty($scrap_qty)) {
            $errorMSG = "<li>Quantity is required</<li>";
        } 

        if(empty($errorMSG)){

		if(!empty($gen_id_scrap)){
            // $save = $this->db->query(" UPDATE Generic set current_stock_level = current_stock_level-".$scrap_qty." WHERE generic_id = ".$gen_id_scrap." AND current_stock_level > $scrap_qty");
            // if($save){
            // $date = date("Y-m-d H:i:s");
            // $save2 = $this->db->query(" INSERT INTO  Stock_log set create_date = '$date', status = 'Scrap', amount = ".$scrap_qty.", gen_id_scrap = ".$gen_id_scrap);
            // }
            $save = $this->db->query(" UPDATE Generic set current_stock_level = current_stock_level-".$scrap_qty." WHERE generic_id = ".$gen_id_scrap." AND current_stock_level > $scrap_qty");
            $rw = $this->db->affected_rows;
            if($rw > 0){
            $date = date("Y-m-d H:i:s");
            $save2 = $this->db->query(" INSERT INTO  Stock_log set create_date = '$date', status = 'Scrap', amount = ".$scrap_qty.", gen_id_scrap = ".$gen_id_scrap);
            }else{
                return "Scrap quantity should be less than current stock level";
            }

			//$save = $this->db->query(" UPDATE Generic set current_stock_level = current_stock_level-".$scrap_qty." WHERE generic_id = ".$gen_id_scrap);
            //$date = date("Y-m-d H:i:s");
            //$save2 = $this->db->query(" INSERT INTO  Stock_log set create_date = '$date', status = 'Scrap', amount = ".$scrap_qty.", gen_id_scrap = ".$gen_id_scrap);
		}
		if($save)
			return 1;
        }

        return $errorMSG;

	}

    function del_status_update(){
        $id = $_POST["bill_id"];
        $val = $_POST["sel_val"];

        $query1 = "UPDATE Bill SET 	delivery_status = '$val' where bill_id = $id ";
        $result1 = mysqli_query($this->db,$query1);
        return 1;

        }

        function price_evo(){

            $query = "SELECT Product . *,GenericResponse.generic_response_id
            FROM GenericResponse
            INNER JOIN Product ON Product.product_id = GenericResponse.Product_product_id
            INNER JOIN Generic ON Generic.generic_id = Product.Generic_generic_id
            WHERE GenericResponse.quality_evaluate_status = 1 AND GenericResponse.price_evaluate_status = 0
            ";
            $result = mysqli_query($this->db,$query);
            $rows = [];

            $query3 = "UPDATE GenericResponse SET pri_stat = 0 ";
            $result3 = mysqli_query($this->db,$query3);

            while($row = $result->fetch_assoc()) {
                $id = $row["generic_response_id"];
                $this->update_price_status($id);
            }
            
            return 1;
    
        }
      
        function update_price_status($id){    
          
            $query1 = "UPDATE GenericResponse SET price_evaluate_status = 1 where generic_response_id = $id ";
            $result1 = mysqli_query($this->db,$query1);

            $query2 = "UPDATE GenericResponse SET pri_stat = 1 where generic_response_id = $id ";
            $result2 = mysqli_query($this->db,$query2);
    
            return 1;
        
            }

    }



?>