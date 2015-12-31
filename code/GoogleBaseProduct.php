<?php

/**
 * Extends: Product
 * Extension to add GoogleBase features and functionality
 *
 *
 * @author Tyler Kidd <tyler@adaircreative.com>
 * @date 04.23.2014
 */

class GoogleBaseProduct extends DataExtension
{


    /**
     * Returns a owner's (Product) Title.
     * Override with getGoogleBaseTitle on Product
     * @return String
     */
    public function getGoogleBaseTitle()
    {
        return $this->owner->Title;
    }
    
    /**
     * Returns list of categories used in GoogleBase.ss template
     * Override with getGoogleBaseCategoryList on Product defaults to getGoogleBaseCategoryList on GoogleBaseProduct
     * @return ArrayList of categories
     */
    public function getGoogleBaseCategoryList()
    {
        $list = $this->owner->GoogleBaseCategories;
        
        if ($list) {
            $allCategories = ArrayList::create();
            
            $categories = explode(' > ', $list);
            
            $string = '';
            $count = 0;
            
            $used = array();
                        
            foreach ($categories as $k => $category) {
                if (isset($used[$category])) {
                    continue;
                }
                
                $used[$category] = $category;
    
                
                ++$count;
                if ($count == 1) {
                    $string = trim($category);
                } else {
                    $string .= ' > '.trim($category);
                }
                
                $allCategories->push(ArrayData::create(array('Category' => $string)));
            }
            
            return $allCategories;
        }
        
        return false;
    }

    /**
     * Returns recursive list of categories if the parent is a Category
     * @return Array of categories
     */
    public function getGoogleBaseCategories()
    {
        $parent = $this->owner->Parent();
        if ($parent->ClassName == 'ProductCategory') {
            $categoryList = $parent->GoogleBaseCategoryList();
            return !empty($categoryList) ? implode(' > ', $categoryList) : false;
        }
        
        
        if ($productCategories = $parent->ProductCategories) {
            foreach ($productCategories as $category) {
                if ($categoryList = $category->GoogleBaseCategoryList()) {
                    if (!empty($categoryList)) {
                        return implode(' > ', $categoryList);
                    }
                }
            }
        }
    }
}
