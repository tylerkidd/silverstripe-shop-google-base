<?php

class GoogleBase extends Controller
{
    
    public static $allowed_actions = array(
        'products',
        'getinfo'
    );


    /**
     * Returns a list of Products.
     * extend with alterProducts to use a different set other than Product::get()
     * @return DataList or ArrayList of Products
     */
    public function ProductList()
    {
        $products = $this->extend('alterProducts');

        if (count($products)) {
            $products = array_pop($products);
        }

        return $products ? $products : Product::get();
    }

    /**
     * Action: get list of products for base feed
     * @param SS_HTTPRequest $request
     * @return XML list of GoogleBase products
     */
    public function products($request)
    {
        $limit = $request->getVar('limit') ? $request->getVar('limit') : false;
        
        if (!$limit) {
            $link = Director::absoluteURL(HTTP::setGetVar('limit', 1000));
            die('A Limit is required, please try again using something like: <a href="'.$link.'">'.$link.'</a>');
        }
        
        $products = $this->ProductList();
        
        if ($products && $products->Count() > 0) {
            $productsItems = PaginatedList::create($products, $request)
                ->setPageLength($limit)
                ->setPaginationGetVar('start');
            
            $data = array(
                'FeedTitle'        => SiteConfig::current_site_config()->Title,
                'FeedLink'        => Director::absoluteURL('/'),
                'FeedDescription'    => 'Google Base Feed',
                'Products'    => $productsItems
            );
                    
            return $this->renderWith('GoogleBase', $data);
        }
    }

    /**
     * Action: get info about product set to help you determine how to appropriately use /products
     * @param SS_HTTPRequest $request
     */
    
    public function getinfo($request)
    {
        $limit = $request->getVar('limit') ? $request->getVar('limit') : 1000;

        $products = $this->ProductList();
        
        $productsItems = PaginatedList::create($products, $request)
            ->setPageLength($limit)
            ->setPaginationGetVar('start');
        
        $count = $products->Count();
            
        $sets = floor($count / $limit);
        
        $setcount = $sets;
        
        echo '<p>There are a total of <strong>'.$count.'</strong> products.</p>';
        echo '<p>Google should be provided with <strong>'.$setcount.'</strong> different feeds, showing '.$limit.' per page.</strong>';
        
        for ($i = 0; $i <= $sets; $i++) {
            $counter = $limit * $i;
            
            $link = Director::absoluteURL('/googlebase/products/?limit='.$limit);
            
            if ($i > 0) {
                $link .= '&start='.$counter;
            }
            
            echo '<p><a href="'.$link.'" target="_blank">'.$link.'</a></p>';
        }
        
        die;
    }
}
