<?php

class GoogleBaseProduct extends DataExtension {

	
	public function getGoogleBaseTitle(){
		return $this->owner->Title;
	}
	
	public function getGoogleBaseCategoryList(){

		$list = $this->owner->GoogleBaseCategories;
		
		if($list){
			$allCategories = ArrayList::create();
			
			$categories = explode(' > ', $list);
			
			$string = '';
			$count = 0;
			
			$used = array();
						
			foreach($categories as $k => $category){
	
				if(isset($used[$category])) continue;
				
				$used[$category] = $category;
	
				
				++$count;
				if($count == 1){
					$string = trim($category);
				}else{
					$string .= ' > '.trim($category);
				}
				
				$allCategories->push(ArrayData::create(array('Category' => $string)));
			}
			
			return $allCategories;
		}
		
		return false;

	}
	
	public function getGoogleBaseCategories(){
		$parent = $this->owner->Parent();
		if ($parent->ClassName == 'ProductCategory') {
			$categoryList = $parent->GoogleBaseCategoryList();
			return !empty($categoryList) ? implode(' > ', $categoryList) : false;
		}
		
		
		if($productCategories = $parent->ProductCategories){
			foreach($productCategories as $category){
				if($categoryList = $category->GoogleBaseCategoryList()){
					if(!empty($categoryList)){
						return implode(' > ', $categoryList);
					}
				}
			}
		}

	}
	
	
}