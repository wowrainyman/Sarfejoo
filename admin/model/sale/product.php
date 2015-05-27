<?php
require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/11/2014
 * Time: 09:06 AM
 */
class ModelSaleProduct extends Model
{
	public function GetAllProducts($data,$subprofile_id)
	{

		$pu_database_name = $GLOBALS['pu_database_name'];
		$oc_database_name = $GLOBALS['oc_database_name'];

		$sql = "SELECT COUNT(*) AS total FROM $pu_database_name.pu_subprofile_product tab1 ".
			"LEFT JOIN $oc_database_name.oc_product_description tab2 ON (tab1.product_id = tab2.product_id) WHERE tab1.subprofile_id = $subprofile_id";

		$implode = array();

		if (!empty($data['filter_id'])) {
			$implode[] = "tab1.id = '" . $this->db->escape($data['filter_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "tab2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'tab1.id',
			'tab2.name',
			'tab1.product_id',
			'tab1.view_count',
			'tab1.update_date',
			'tab1.availability',
			'tab1.status_id',
			'tab1.is_payed'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY tab1.id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];

	}
	public function GetProducts($data,$subprofile_id){
		$pu_database_name = $GLOBALS['pu_database_name'];
		$oc_database_name = $GLOBALS['oc_database_name'];

		$sql = "SELECT *,tab1.product_id AS product_id,tab1.id AS id FROM $pu_database_name.pu_subprofile_product tab1 ".
			"LEFT JOIN $oc_database_name.oc_product_description tab2 ON (tab1.product_id = tab2.product_id) WHERE tab1.subprofile_id = $subprofile_id";


		$implode = array();

		if (!empty($data['filter_id'])) {
			$implode[] = "tab1.id = '" . $this->db->escape($data['filter_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "tab2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$implode[] = "tab1.price = '" . $this->db->escape($data['filter_price']) . "'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'tab1.id',
			'tab2.name',
			'tab1.product_id',
			'tab1.view_count',
			'tab1.update_date',
			'tab1.availability',
			'tab1.status_id',
			'tab1.is_payed'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY tab1.id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}


		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function GetCustomerSubProfilesByStatusId($customerid,$statusid)
	{

		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `customer_id` = $customerid AND `status_id` = $statusid";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select)
			return $result_select;
		else
			return false;
	}
	public function GetCustomerSubProfiles($customerid)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `customer_id` = $customerid AND `status_id` <> 0";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select)
			return $result_select;
		else
			return false;
	}
	public function GetCustomerSubProfile($subprofile_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $subprofile_id  AND `status_id` <> 0";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row;
			break;
		}
		if ($exist)
			return $result;
		else
			return false;
	}
	public function GetLegalPersonInfo($id)
	{

		$con_PU_db = $GLOBALS['con_PU_db'];

		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row;
			break;
		}
		$id=$result["legalperson_id"];
		if(!$id)
			return false;
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_legalperson` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row;
			break;
		}
		if ($exist)
			return $result;
		else
			return false;
	}
	public function AddLegalPersonInfo($data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$agreementstamp = $data['agreementstamp'];
		$newspaperstamp = $data['newspaperstamp'];
		$registrationid = $data['registrationid'];
		$adminmessage = $data['adminmessage'];


		$sql_insert_string = "INSERT INTO `pu_legalperson`" .
			"(`agreementstamp`, `newspaperstamp`, `registrationid`, `adminmessage`)" .
			"VALUES ('$agreementstamp', '$newspaperstamp', '$registrationid','$adminmessage');";
		$result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
		$id = mysqli_insert_id($con_PU_db);
		return $id;
	}
	public function EditLegalPersonInfo($id, $data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$agreementstamp = $data['agreementstamp'];
		$newspaperstamp = $data['newspaperstamp'];
		$registrationid = $data['registrationid'];

		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_legalperson` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_legalperson` SET " .
				"`agreementstamp`='$agreementstamp'" .
				",`newspaperstamp`='$newspaperstamp'" .
				",`registrationid`='$registrationid'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function EditSubprofile($id,$data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$customer_id = $data['customer_id'];
		$group_id = $data['group_id'];
		$title = $data['title'];
		$legalperson_id = $data['legalperson_id'];
		$province_id = $data['province_id'];
		$city = $data['city'];
		$address = $data['address'];
		$lat = $data['lat'];
		$lon = $data['lon'];
		$zoom = $data['zoom'];
		$tel = $data['tel'];
		$mobile = $data['mobile'];
		$email = $data['email'];
		$website = $data['website'];
		$status_id = $data['status_id'];
		$is_payed = $data['is_payed'];
		$adminmessage = $data['adminmessage'];

		$exist = false;
		$sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`title`='$title'" .
				",`province_id`='$province_id'" .
				",`city`='$city'" .
				",`address`='$address'" .
				",`lat`='$lat'" .
				",`lon`='$lon'" .
				",`zoom`='$zoom'" .
				",`tel`='$tel'" .
				",`mobile`='$mobile'" .
				",`email`='$email'" .
				",`website`='$website'" .
				",`status_id`='$status_id'" .
				",`is_payed`='$is_payed'" .
				",`adminmessage`='$adminmessage'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function EditSubprofileStatus($id,$status)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];


		$exist = false;
		$sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`status_id`='$status'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function EditLogo($id,$name)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$customer_id = $this->customer->getId();
		$exist = false;
		$sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`logo`='$name'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function EditPicture($id,$name)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$customer_id = $this->customer->getId();
		$exist = false;
		$sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`picture`='$name'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function AddSubprofile($data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$customer_id = $this->customer->getId();
		$id = $data['id'];
		$group_id = $data['group_id'];
		$title = $data['title'];
		$legalperson_id = 0;
		$province_id = $data['province_id'];
		$city = $data['city'];
		$address = $data['address'];
		$lat = $data['lat'];
		$lon = $data['lon'];
		$zoom = $data['zoom'];
		$tel = $data['tel'];
		$mobile = $data['mobile'];
		$email = $data['email'];
		$website = $data['website'];
		$sql_insert_string = "INSERT INTO `pu_subprofile`" .
			"(`customer_id`, `group_id`, `title`, `legalperson_id`,
                 `province_id`, `city`,
                 `address`, `lat`,
                  `lon`, `zoom`,
                   `tel`, `mobile`,
                  `email`, `website`, `status_id`)" .
			"VALUES ('$customer_id', '$group_id', '$title','$legalperson_id'
                ,'$province_id','$city','$address'
                ,'$lat','$lon','$zoom'
                ,'$tel','$mobile','$email','$website','0');";
		$result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
		$id = mysqli_insert_id($con_PU_db);
		return $id;
	}
	public function UpdateSubprofileStatus($id,$status){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`status_id`='$status'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function GetSubprofileInfo($id){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT *,tab1.id AS id FROM `pu_subprofile` tab1 LEFT JOIN `pu_rating` tab2 ON(tab1.id = tab2.subprofile_id) WHERE tab1.id = $id";

		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			return $row;
		}
			return false;
	}
	public function SetSubprofileLegalperson($subprofileid, $legalpersonid)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $subprofileid";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile` SET " .
				"`legalperson_id`='$legalpersonid'" .
				" WHERE `id` = $subprofileid";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function UpdateProductPrice($id,$price)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];

		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile_product` SET " .
				"`price`='$price'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function UpdateProductDescription($id,$description)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile_product` SET " .
				"`description`='$description'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function UpdateProductBuyLink($id,$buy_link)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile_product` SET " .
				"`buy_link`='$buy_link'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function UpdateProductAvailability($id,$status)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];

		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile_product` SET " .
				"`availability`='$status'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function AddProductToSubprofile($data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$product_id = $data['product_id'];
		$subprofile_id = $data['subprofile_id'];
		$price = $data['price'];
		$buy_link = $data['buy_link'];
		$description = $data['description'];
		$availability= $data['availability'];
		$sql_insert_string = "INSERT INTO `pu_subprofile_product`" .
			"(`product_id`, `subprofile_id`, `price`, `buy_link`, `description`, `availability`)" .
			"VALUES ('$product_id', '$subprofile_id', '$price', '$buy_link', '$description','$availability');";

		$result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
		$id = mysqli_insert_id($con_PU_db);
		return $id;
	}
	public function UpdateProductStatus($id,$status){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_subprofile_product` SET " .
				"`status_id`='$status'" .
				" WHERE `id` = $id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			return false;
		}
	}
	public function GetCountProductsOfSubprofile($subprofile_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT COUNT(DISTINCT p.product_id) AS total "." FROM pu_subprofile_product p"." WHERE `subprofile_id` = $subprofile_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		return $result_select;
	}
	public function GetSubprofileProduct($id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		$result = array();
		while ($row = mysqli_fetch_assoc($result_select)) {
			return $row;
		}
		return false;
	}
	public function GetProductsOfSubprofile($subprofile_id,$data)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `subprofile_id` = $subprofile_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		$result = array();
		while ($row = mysqli_fetch_assoc($result_select)) {
			$result[] = $row;
		}
		return $result;
	}
	public function GetAllProductsOfSubprofile($subprofile_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `subprofile_id` = $subprofile_id AND status_id <> 0";
		// $sql_select_string.=" LIMIT " . (int)$data['start'] . "," . (int)$data['limit']
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		return $result_select;
	}
	public function GetAllSubprofileOfProducts($product_id)
	{


		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_subprofile_product`,`pu_subprofile` WHERE  `pu_subprofile`.id = `pu_subprofile_product`.subprofile_id AND `pu_subprofile_product`.status_id <> 0  and `pu_subprofile_product`.`product_id` = $product_id  and (`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2) ORDER BY `pu_subprofile_product`.`update_date` DESC";

		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$result[]=$row;
		}
		return $result;
	}
	public function GetAllSubprofileList($group_id,$limit)  // List All Provider of Group_id (0=all)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		if ($group_id =='a') {
			$sql_select_string = "SELECT * FROM `pu_subprofile`";
		} else {
			$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE group_id = $group_id  limit = $limit";
		}
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$result[]=$row;
		}
		return $result;
	}
	public function GetSubprofileByID($subprofile_id)  // Provider Profile by id
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();

		$sql_select_string = "SELECT * FROM `pu_subprofile` WHERE id = $subprofile_id";

		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());

		while ($row = mysqli_fetch_assoc($result_select)) {
			return $row;
		}
		return false;
	}
	public function GetListOfProductsOfSubprofileByID($subprofile_id)  // Products Of Subprofile (list Image, price, Name, ID)
	{
		$pu_database_name = $GLOBALS['pu_database_name'];
		$oc_database_name = $GLOBALS['oc_database_name'];

		$con_OC_db = $GLOBALS['con_OC_db'];
		$exist = false;
		$result = array();

		$sql_select_string = "SELECT ocp.`product_id`, ocp.`image`,ocd.`name`,pusp.`price` FROM `oc_product` ocp, `oc_product_description` ocd, $pu_database_name.`pu_subprofile_product` pusp WHERE ocp.`product_id`= pusp.`product_id` and ocp.`product_id` = ocd.`product_id`and pusp.`subprofile_id` = $subprofile_id";

		$result_select = mysqli_query($con_OC_db, $sql_select_string) or die(mysqli_error());

		while ($row = mysqli_fetch_assoc($result_select)) {
			$result[]=$row;
		}
		return $result;
	}
	public function GetTopSubprofileOfProducts($product_id,$count)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$sql_select_string = "SELECT * FROM `pu_subprofile_product`,`pu_subprofile` WHERE  `pu_subprofile`.id = `pu_subprofile_product`.subprofile_id  and `pu_subprofile_product`.`product_id` = $product_id  and (`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2) ORDER BY `pu_subprofile_product`.`update_date` DESC LIMIT 0,$count";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$result[]=$row;
		}
		if(isset($result))
			return $result;
		else
			return $result = array();
	}
	public function GetAveragepricePriceOfProduct($product_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT `average_price` FROM `pu_product_property` WHERE `product_id`=$product_id  ORDER BY `timestamps` DESC LIMIT 1";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row['average_price'];
			break;
		}
		if ($exist)
			return $result;
		else
			return false;
	}
	public function GetMinimumPriceOfProduct($product_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT MIN(price) FROM `pu_subprofile_product` WHERE product_id = $product_id and `availability`=0";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row;
			break;
		}
		if ($exist)
			return $result;
		else
			return false;
	}
	public function GetMaximumPriceOfProduct($product_id)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT MAX(price) FROM `pu_subprofile_product` WHERE product_id = $product_id and `availability`=0";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			$result = $row;
			break;
		}
		if ($exist)
			return $result;
		else
			return false;
	}
	public function GetSubprofileExpireDate($subprofile_id){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_plan_periodic_subprofile` WHERE `subprofile_id` = $subprofile_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select){
			while ($row = mysqli_fetch_assoc($result_select)) {
				return $row['end_date'];
			}
		}

		$sql_select_string = "SELECT * FROM `pu_plan_once_subprofile` WHERE `subprofile_id` = $subprofile_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select)
			return 0;
	}

	public function GetProductExpireDate($product_id){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$result = array();
		$sql_select_string = "SELECT * FROM `pu_plan_periodic_product` WHERE `subprofile_product_id` = $product_id";

		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select){
			while ($row = mysqli_fetch_assoc($result_select)) {
				return $row['end_date'];
			}
		}
		$sql_select_string = "SELECT * FROM `pu_plan_once_product` WHERE `subprofile_product_id` = $product_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		if ($result_select)
			return 0;
	}
	public function UpdateSubprofileRate($subprofile_id,$rate){
		$con_PU_db = $GLOBALS['con_PU_db'];
		$exist = false;
		$sql_select_string = "SELECT * FROM `pu_rating` WHERE `subprofile_id` = $subprofile_id";
		$result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
		while ($row = mysqli_fetch_assoc($result_select)) {
			$exist = true;
			break;
		}
		if ($exist) {
			$sql_update_string = "UPDATE `pu_rating` SET " .
				"`rate`='$rate'" .
				" WHERE `subprofile_id` = $subprofile_id";
			$result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
			return true;
		} else {
			$sql_insert_string = "INSERT INTO `pu_rating`" .
				"(`subprofile_id`, `rate`)" .
				"VALUES ('$subprofile_id', '$rate');";
			$result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
			return mysqli_insert_id($con_PU_db);
		}
	}
}