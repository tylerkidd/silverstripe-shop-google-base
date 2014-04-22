<?xml version="1.0"?>
<rss version ="2.0" xmlns:g="http://base.google.com/ns/1.0"> 
<channel>
<title>$FeedTitle</title>
<link>$FeedLink</link>
<description>$FeedDescription</description>

<% if $Products %>
<% loop $Products %>
	<item>
		<% if $GoogleBaseTitle %><title>$GoogleBaseTitle.XML</title><% end_if %>
		<g:condition>New</g:condition>		
		<% if $Content %>
			<description><![CDATA[ {$Content.NoHtml.XML} ]]></description>
		<% end_if %>
		<% if Image %>
		<g:image_link><![CDATA[ {$Image.URL} ]]></g:image_link>
		<% end_if %>
		<link>$AbsoluteLink</link>		
		<g:id>$ID</g:id>
		<g:mpn>$UPC</g:mpn>				
		<g:identifier_exists>FALSE</g:identifier_exists>
		<g:price>$VFI_Price USD</g:price>
		<g:tax>
		   <g:country>US</g:country>
		   <g:region>TN</g:region>
		   <g:rate>9.00</g:rate>
		   <g:tax_ship>n</g:tax_ship>
		</g:tax>

		<% if $GoogleBaseCategoryList %>
			<% loop $GoogleBaseCategoryList %>
				<% if Last %>
					<% if $Category %>
						<g:google_product_category><![CDATA[{$Category}]]></g:google_product_category>
					<% end_if %>
				<% end_if %>
			<% end_loop %>
		<% end_if %>

		<% if Parent %>
			<g:product_type><![CDATA[{$Parent.Title}]]></g:product_type>
		<% end_if %>

		<% if $ProductCategories %>
			<% loop $ProductCategories %>
				<g:product_type><![CDATA[{$Title}]]></g:product_type>
			<% end_loop %>
		<% end_if %>
		
		<g:availability>in stock</g:availability>
	</item>
<% end_loop %>
<% end_if %>
</channel>
</rss>