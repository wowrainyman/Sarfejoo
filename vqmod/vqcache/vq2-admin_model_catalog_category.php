<?php
class ModelCatalogCategory extends Model {

	
			public function getCategories_MF($data) {
				if( version_compare( VERSION, '1.5.5', '>=' ) ) {
					$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

					if( ! empty( $data['filter_name'] ) ) {
						$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
					} 
				
					$sql .= " GROUP BY cp.category_id ORDER BY name";
				} else {
					$sql = "SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				
					if( ! empty( $data['filter_name'] ) ) {
						$sql .= " AND LOWER(cd.name) LIKE '" . $this->db->escape( function_exists( 'mb_strtolower' ) ? mb_strtolower( $data['filter_name'], 'utf-8' ) : $data['filter_name'] ) . "%'";
					}
				
					$sql .= " GROUP BY c.category_id ORDER BY name";
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
				
			

	public function getCategoryNonAuto($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		
		return $query->row;
	} 
	
	public function getCategoriesNonAuto($parent_id = 0) {
		$category_data = $this->cache->get('category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id);
	
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPathNonAuto($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategoriesNonAuto($result['category_id']));
			}	
	
			$this->cache->set('category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id, $category_data);
		}
		
		return $category_data;
	}

	public function getPathNonAuto($category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getPathNonAuto($query->row['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}

			public function enableCategory($category_id) {
				$category_info = $this->getCategory($category_id);
		
				if ($category_id) {
					$this->db->query("UPDATE " . DB_PREFIX . "category SET status = '1' WHERE category_id = '" . (int)$category_id . "'");
				}


			
				require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
				$seo = new ControllerCatalogSeoPack($this->registry);
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
				
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT cd.category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."category c 
								inner join ".DB_PREFIX."category_description cd on c.category_id = cd.category_id 
								inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
								where c.category_id = '" . (int)$category_id . "'");

						
						foreach ($query->rows as $category_row){	

							
							if( strlen($category_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($category_row['name']);
								$exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'category_id=" . $category_row['category_id'] . "' and language_id=".$category_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'category_id=" . $category_row['category_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($category_row['name']).'-'.rand();
											}
											else
											{
												$slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
											}
										}
									
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('category_id=" . $category_row['category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
			
				$this->cache->delete('category');
			}

			public function disableCategory($category_id) {
				$category_info = $this->getCategory($category_id);
		
				if ($category_id) {
					$this->db->query("UPDATE " . DB_PREFIX . "category SET status = '0' WHERE category_id = '" . (int)$category_id . "'");
				}


			
				require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
				$seo = new ControllerCatalogSeoPack($this->registry);
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
				
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT cd.category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."category c 
								inner join ".DB_PREFIX."category_description cd on c.category_id = cd.category_id 
								inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
								where c.category_id = '" . (int)$category_id . "'");

						
						foreach ($query->rows as $category_row){	

							
							if( strlen($category_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($category_row['name']);
								$exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'category_id=" . $category_row['category_id'] . "' and language_id=".$category_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'category_id=" . $category_row['category_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($category_row['name']).'-'.rand();
											}
											else
											{
												$slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
											}
										}
									
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('category_id=" . $category_row['category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
			
				$this->cache->delete('category');
			}
			
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', custom_title = '" . ((isset($value['custom_title']))?($this->db->escape($value['custom_title'])):'') . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			
			foreach ($data['keyword'] as $language_id => $keyword) {
				if ($keyword) {$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword) . "', language_id = " . $language_id);}
			}
			
		}


			
				require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
				$seo = new ControllerCatalogSeoPack($this->registry);
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
				
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT cd.category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."category c 
								inner join ".DB_PREFIX."category_description cd on c.category_id = cd.category_id 
								inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
								where c.category_id = '" . (int)$category_id . "'");

						
						foreach ($query->rows as $category_row){	

							
							if( strlen($category_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($category_row['name']);
								$exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'category_id=" . $category_row['category_id'] . "' and language_id=".$category_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'category_id=" . $category_row['category_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($category_row['name']).'-'.rand();
											}
											else
											{
												$slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
											}
										}
									
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('category_id=" . $category_row['category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
			
		$this->cache->delete('category');
	}

	public function editCategory($category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', custom_title = '" . ((isset($value['custom_title']))?($this->db->escape($value['custom_title'])):'') . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_store'])) {		
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");

		if ($data['keyword']) {
			
			foreach ($data['keyword'] as $language_id => $keyword) {
				if ($keyword) {$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword) . "', language_id = " . $language_id);}
			}
			
		}


			
				require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
				$seo = new ControllerCatalogSeoPack($this->registry);
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
				
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT cd.category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."category c 
								inner join ".DB_PREFIX."category_description cd on c.category_id = cd.category_id 
								inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
								where c.category_id = '" . (int)$category_id . "'");

						
						foreach ($query->rows as $category_row){	

							
							if( strlen($category_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($category_row['name']);
								$exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'category_id=" . $category_row['category_id'] . "' and language_id=".$category_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'category_id=" . $category_row['category_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($category_row['name']).'-'.rand();
											}
											else
											{
												$slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
											}
										}
									
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('category_id=" . $category_row['category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
			
		$this->cache->delete('category');
	}

	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {	
			$this->deleteCategory($result['category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");


			
				require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
				$seo = new ControllerCatalogSeoPack($this->registry);
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
				
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT cd.category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."category c 
								inner join ".DB_PREFIX."category_description cd on c.category_id = cd.category_id 
								inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
								where c.category_id = '" . (int)$category_id . "'");

						
						foreach ($query->rows as $category_row){	

							
							if( strlen($category_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($category_row['name']);
								$exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'category_id=" . $category_row['category_id'] . "' and language_id=".$category_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'category_id=" . $category_row['category_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($category_row['name']).'-'.rand();
											}
											else
											{
												$slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
											}
										}
									
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('category_id=" . $category_row['category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
			
		$this->cache->delete('category');
	} 

	// Function to repair any erroneous categories that are not in the category path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
	}


			public function getKeyWords($category_id) {
				$keywords = array();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
						
				foreach ($query->rows as $result) {
					$keywords[$result['language_id']] = $result['keyword'];					
				}
				
				return $keywords;
			}
			
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	public function getCategories($data) {
		$sql = "SELECT cp.category_id AS category_id, MIN(c.status) AS status, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id ORDER BY name";

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

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'custom_title' => $result['custom_title'], 'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}

		return $category_description_data;
	}	

	public function getCategoryFilters($category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}	

	public function getTotalCategoriesByImageId($image_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>