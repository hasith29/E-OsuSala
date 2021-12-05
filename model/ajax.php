<?php 

ob_start();
$action = $_GET['action'];
include 'Mgeneric.php';
$crud = new Action();

if($action == "load_category"){
    $category = $crud->load_category();
	if($category)
		echo json_encode($category);
}

if($action == "save_generic"){
	$save = $crud->save_generic();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}
}

if($action == "load_supplier_info"){
    $supplier = $crud->load_supplier_info();
	if($supplier)
		echo json_encode($supplier);
}

if($action == "send_mail_to_supplier"){
    $supplier_mail = $crud->send_mail_to_supplier();
	if($supplier_mail == 1){
		echo json_encode((['code'=>200, 'msg'=>$supplier_mail]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$supplier_mail]);
	}
}

if($action == "load_product_info"){
    $product = $crud->load_product_info();
	if($product)
		echo json_encode($product);
}

if($action == "save_generic_response"){
	$save = $crud->save_generic_response();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}

}

if($action == "load_product_by_gen_id"){
	$products = $crud->load_product_by_gen_id();
	if($products)
		echo json_encode($products);
}

if($action == "save_supplier"){
	$save = $crud->save_supplier();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}
}

if($action == "save_company"){
	$save = $crud->save_company();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}
}

if($action == "remove_product"){
	$delete = $crud->remove_product();
	if($delete)
		echo json_encode($delete);

}


if($action == "quality_evo"){
	$quality_evo = $crud->quality_evo();
	if($quality_evo)
		echo json_encode($quality_evo);

}

if($action == "send_mail_to_supplier_award"){
    $supplier_mail_award = $crud->send_mail_to_supplier_award();
	if($supplier_mail_award == 1){
		echo json_encode((['code'=>200, 'msg'=>$supplier_mail_award]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$supplier_mail_award]);
	}
}

if($action == "accept_award"){
    $accept_award = $crud->accept_award();
	if($accept_award == 1)
	echo json_encode($accept_award);
}

if($action == "reject_award"){
    $reject_award = $crud->reject_award();
	if($reject_award == 1)
	echo json_encode($reject_award);
}

if($action == "reject_generic_request"){
    $reject_generic_request = $crud->reject_generic_request();
	if($reject_generic_request == 1)
	echo json_encode($reject_generic_request);
}

if($action == "load_generic_request_info"){
    $load_generic_request_info = $crud->load_generic_request_info();
	if($load_generic_request_info)
		echo json_encode($load_generic_request_info);
}

if($action == "rec_award"){
    $rec_award = $crud->rec_award();
	if($rec_award == 1)
	echo json_encode($rec_award);
}

if($action == "save_customer"){
	$save = $crud->save_customer();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}
}


if($action == "add_quantity"){
    $add_quantity = $crud->add_quantity();
	if($add_quantity == 1)
	echo json_encode($add_quantity);
}

if($action == "deduct_quantity"){
    $deduct_quantity = $crud->deduct_quantity();
	if($deduct_quantity == 1)
	echo json_encode($deduct_quantity);
}

if($action == "save_scrap"){
	$save = $crud->save_scrap();
	if($save == 1){
		echo json_encode((['code'=>200, 'msg'=>$save]));
	}else{
		echo json_encode(['code'=>404, 'msg'=>$save]);
	}
}

if($action == "del_status_update"){
    $stat = $crud->del_status_update();
	if($stat)
		echo json_encode($stat);
}

if($action == "price_evo"){
	$price_evo = $crud->price_evo();
	if($price_evo)
		echo json_encode($price_evo);

}

?>