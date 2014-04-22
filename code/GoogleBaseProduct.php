<?php

class GoogleBaseProduct extends SiteTreeExtension {

	
	public function getGoogleBaseCategoryList(){
	
		$allCategories = ArrayList::create();
	
		if($list = $this->owner->GoogleBaseCategories){
			$categories = explode(' > ', $list);
			
			
			$string = '';
			$count = 0;
			
			$used = array();
			
			//Debug::dump($categories);
			
			foreach($categories as $k => $category){

				if(isset($used[$category])) continue;
				
				$used[$category] = $category;

				
				++$count;
				if($count == 1){
					$string = trim($category);
				}else{
					$string .= ' > '.trim($category);
				}
				
				//die('String: '.$string);
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
		
		if($productCategories = $product->ProductCategories()){
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