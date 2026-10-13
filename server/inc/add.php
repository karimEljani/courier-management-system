<?php
function insertImagetoGallery($img)
{
	include 'connection.php';

	$sql = "INSERT INTO gallery(gallery_image) VALUES('$img')";
	return mysqli_query($con, $sql);
}

function addBranch($data)
{
	include 'connection.php';

	$branch_name = $data['branch_name'];
	$sql = "INSERT INTO branch(branch_name, is_deleted) VALUES('$branch_name', 0)";
	return mysqli_query($con, $sql);
}

function addArea($data)
{
	include 'connection.php';

	$area_name = $data['area_name'];


	$count = checkAreaByName($area_name);

	if ($count == 0) {

		$sql = "INSERT INTO area(area_name, is_deleted) VALUES('$area_name', 0)";
		return mysqli_query($con, $sql);
	} else {
		echo json_encode($count);
	}
}

function addPrice($data)
{
	include 'connection.php';

	$start_area = $data['start_area'];
	$end_area = $data['end_area'];
	$price = $data['price'];

	$count = checkPrice($start_area, $end_area);

	if ($count == 0) {

		$sql = "INSERT INTO price_table(start_area, end_area, price ,is_deleted, date_updated) VALUES('$start_area', '$end_area', '$price', 0 , now())";
		return mysqli_query($con, $sql);
	} else {
		echo json_encode($count);
	}
}


function addRequest($data)
{
    include 'connection.php';

    // Récupérer l'ID du client connecté
    $customer_id = $data['customer_id'];

    // Requête pour récupérer le numéro de téléphone de l'expéditeur
    $query = "SELECT phone FROM customer WHERE customer_id = '$customer_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sender_phone = $row['phone'];
    } else {
        return false; // Échec si le téléphone n'est pas trouvé
    }

    // Récupérer les autres données du formulaire
    $send_location = $data['send_location'];
    $end_location = $data['end_location'];
    $total_fee = $data['total_fee'];
    $res_phone = $data['res_phone'];
    $red_address = $data['red_address'];
    $res_name = $data['res_name'];

    // Champs supplémentaires
    $type = $data['type'];
    $nbre_paquets = $data['nbre_paquets'];
    $libelle = $data['libelle'];
    $observations = $data['observations'];

    // Insérer la demande dans la table `request`
    $sql = "INSERT INTO request (
                customer_id, 
                sender_phone, 
                send_location, 
                end_location, 
                total_fee, 
                res_phone, 
                red_address, 
                res_name, 
                type, 
                nbre_paquets, 
                libelle, 
                observations, 
                is_deleted, 
                date_updated, 
                tracking_status
            ) VALUES (
                '$customer_id', 
                '$sender_phone', 
                '$send_location', 
                '$end_location', 
                '$total_fee', 
                '$res_phone', 
                '$red_address', 
                '$res_name', 
                '$type', 
                '$nbre_paquets', 
                '$libelle', 
                '$observations', 
                0, 
                now(), 
                1
            )";

    return mysqli_query($con, $sql);
}






function addEmployee($data)
{
	include 'connection.php';

	$name = $data['name'];
	$email = $data['email'];
	$phone = $data['phone'];
	$nic = $data['nic'];
	$address = $data['address'];
	$gender = $data['gender'];
	$password = $data['password'];
	$branch_id = $data['branch_id'];


	$count = checkemployeetByEmail($email);

	if ($count == 0) {

		$sql = "INSERT INTO employee(name, email, phone, nic, address, gender, password ,is_deleted, branch_id) VALUES('$name', '$email', '$phone', '$nic', '$address', '$gender', '$password', 0 , '$branch_id')";
		return mysqli_query($con, $sql);
	} else {
		echo json_encode($count);
	}
}


//contact
function addMessage($data)
{
	include 'connection.php';

	$name = $data['name'];
	$email = $data['email'];
	$subject = $data['subject'];
	$message = $data['message'];


	$sql = "INSERT INTO contact(name, email, subject, message, date_updated) VALUES('$name', '$email', '$subject', '$message', now())";
	return mysqli_query($con, $sql);
}


function createCustomer($data)
{
	include 'connection.php';

	$name = $data['name'];
	$email = $data['email'];
	$phone = $data['phone'];
	$nic = $data['nic'];
	$address = $data['address'];
	$gender = $data['gender'];
	$password = $data['password'];

	$sql = "INSERT INTO customer(name, email, phone, nic, address, gender, password, is_deleted) VALUES('$name', '$email', '$phone', '$nic', '$address', '$gender', '$password', 0 )";
	return mysqli_query($con, $sql);
}
