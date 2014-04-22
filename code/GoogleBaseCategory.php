<?php

class GoogleBaseCategory extends SiteTreeExtension {
	
	static $db = array(
		'GoogleBaseCategory' => 'Varchar(255)'
	);
	
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldtoTab('Root.GoogleBase', TextField::create('GoogleBaseCategory','Google Base Category'));
	}
	
	public function GoogleBaseCategoryList(){
		
		$categoryList = array();
		
		$parent = $this->owner->Parent();
		if ($parent->ClassName == 'ProductCategory') {
			
			$parentList = $parent->GoogleBaseCategoryList();
			
			if (empty($parentList)) {
				$categoryList[] = $parent->GoogleBaseCategory;
			} else {
				$categoryList = array_merge($categoryList, $parentList);
			}
		}
		
		if($this->owner->GoogleBaseCategory){
			$categoryList[] = $this->owner->GoogleBaseCategory;
		}
		
		return $categoryList;
	}
}