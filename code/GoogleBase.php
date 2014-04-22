<?php

class GoogleBase extends Controller {
	
	static $allowed_actions = array(
		'products',
		'getinfo'
	);
	
	function products($request){
	
		$limit = $request->getVar('limit') ? $request->getVar('limit') : false;
		
		if(!$limit){
			$link = Director::absoluteURL(HTTP::setGetVar('limit',1000));
			die('A Limit is required, please try again using something like: <a href="'.$link.'">'.$link.'</a>');
		}
		
		$products = Product::get()->where("Title != '' AND Content != '' AND (VFI_Price != '0.00' OR VFI_Price > 0)");
		
		$productsItems = PaginatedList::create($products, $request)
			->setPageLength($limit)
			->setPaginationGetVar('start');
		
		$data = array(
			'FeedTitle'		=> SiteConfig::current_site_config()->Title,
			'FeedLink'		=> Director::absoluteURL('/'),
			'FeedDescription'	=> 'Google Base Feed',
			'Products'	=> $productsItems
		);
				
		return $this->renderWith('GoogleBase', $data);
	}
	
	function getinfo($request){
		$limit = $request->getVar('limit') ? $request->getVar('limit') : 10;
		$products = Product::get()->where("Title != '' AND Content != ''");
		
		$productsItems = PaginatedList::create($products, $request)
			->setPageLength($limit)
			->setPaginationGetVar('start');
		
		
		
		$count = $products->Count();
			
		$sets = floor($count / $limit);
		
		$setcount = $sets;
		
		echo '<p>There are a total of <strong>'.$count.'</strong> products.</p>';
		echo '<p>Google should be provided with <strong>'.$setcount.'</strong> different feeds.</strong>';
		
		for($i = 0; $i <= $sets; $i++){
			
			$counter = $limit * $i;
			
			$link = Director::absoluteURL('/googlebase/products/?limit='.$limit);
			
			if($i > 0){
				$link .= '&start='.$counter;
			}
			
			echo '<p><a href="'.$link.'" target="_blank">'.$link.'</a></p>';
		}
		
		die;
		
	}
	
}