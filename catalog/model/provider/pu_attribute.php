<?php

require_once "provider.php";

require_once "settings.php";

class ModelProviderPuAttribute extends Model
{
    public function addAttribute($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

        $attribute_id = $this->db->getLastId();

        foreach ($data['attribute_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }
    }

    public function editAttribute($attribute_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

        foreach ($data['attribute_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }
    }

    public function deleteAttribute($attribute_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");
    }

    public function getAttribute($attribute_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getAttributes($data = array())
    {
        $sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_attribute_group_id'])) {
            $sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
        }

        $sort_data = array(
            'ad.name',
            'attribute_group',
            'a.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY attribute_group, ad.name";
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

    public function getAttributeDescriptions($attribute_id)
    {
        $attribute_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

        foreach ($query->rows as $result) {
            $attribute_data[$result['language_id']] = array('name' => $result['name']);
        }

        return $attribute_data;
    }

    public function getAttributesByAttributeGroupId($data = array())
    {
        $sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_attribute_group_id'])) {
            $sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
        }

        $sort_data = array(
            'ad.name',
            'attribute_group',
            'a.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY ad.name";
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

    public function getTotalAttributes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute");
        return $query->row['total'];
    }

    public function getTotalAttributesByAttributeGroupId($attribute_group_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

        return $query->row['total'];
    }

    public function isCustomProduct($product_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $attribute_type = 0;
        $result = array();
        $sql_select_string = "SELECT attribute_type FROM `pu_product_attributetype` WHERE `product_id` = $product_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $attribute_type = $row['attribute_type'];
        }
        return $attribute_type;
    }

    public function getCustomAttributes($category_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_category_attribute` WHERE `category_id` = $category_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        if ($result_select)
            return $result_select;
        else
            return false;
    }

    public function getCustomAttribute($attribute_id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $query = "SELECT * FROM $oc_database_name." . DB_PREFIX . "attribute a ,$oc_database_name." . DB_PREFIX . "attribute_description ad, $pu_database_name.pu_attributetype ac WHERE a.attribute_id = '" . (int)$attribute_id . "' AND a.attribute_id = ad.attribute_id AND a.attribute_id = ac.attribute_id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $query) or die(mysqli_error());
        foreach ($result_select as $result) {
            return $result;
        }
        return false;
    }

    public function getCustomAttributeValues($attribute_id)
    {
        $query = "SELECT * FROM pu_attribute_value WHERE attribute_id = $attribute_id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $query) or die(mysqli_error());
        if ($result_select)
            return $result_select;
        else
            return false;
    }

    public function addCustomAttribute($subprofile_id, $product_id, $attribute_id, $value)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_subprofile_product_attribute`" .
            "(`subprofile_id`, `product_id`, `attribute_id`, `value`)" .
            "VALUES ('$subprofile_id', '$product_id', '$attribute_id', '$value');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function getAttributeValue($subprofile_id, $product_id, $attribute_id)
    {
        $query = "SELECT id,value FROM pu_subprofile_product_attribute WHERE subprofile_id = $subprofile_id AND product_id = $product_id AND attribute_id = $attribute_id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $query) or die(mysqli_error());
        foreach ($result_select as $result) {
            return $result;
        }
        return false;
    }

    public function getImportantAttribute($product_id)
    {
        $query = "SELECT attribute_id FROM pu_attribute_important WHERE product_id = $product_id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $query) or die(mysqli_error());
        $result = array();
        foreach ($result_select as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function UpdateCustomAttribute($id, $value)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product_attribute` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product_attribute` SET " .
                "`value`='$value'" .
                " WHERE `id` = $id";
            echo $sql_update_string;
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return true;
        }
    }


}

?>