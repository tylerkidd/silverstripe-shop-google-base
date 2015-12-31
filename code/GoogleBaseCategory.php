<?php

/**
 * Extends: ProductCategory
 * Extension to add GoogleBaseCategory db field and CMS fields.
 *
 *
 * @author Tyler Kidd <tyler@adaircreative.com>
 * @date 04.23.2014
 */

class GoogleBaseCategory extends SiteTreeExtension
{
    
    public static $db = array(
        'GoogleBaseCategory' => 'Varchar(255)'
    );
    
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldtoTab('Root.GoogleBase', TextField::create('GoogleBaseCategory', 'Google Base Category'));
    }


    /**
     * Get a recursive list of Product Categories where parents are ProductCategories
     * @return array of categories
     */
    public function GoogleBaseCategoryList()
    {
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
        
        if ($this->owner->GoogleBaseCategory) {
            $categoryList[] = $this->owner->GoogleBaseCategory;
        }
        
        return $categoryList;
    }
}
