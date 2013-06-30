<% if ImageGalleryEntries %>
<div id="ImageGalleryEntriesOuter">
	<ul id="ImageGalleryEntriesUL">
	<% loop ### with ImageGalleryEntries %>
		<% if Image %><li class="$EvenOdd $FirstLast IGE{$Pos}"><a href="$Image.URL" rel="prettyPhoto[$URLSegment]"><% loop Image %><img src="$CroppedImage(100,100).Link" title="$Title" alt="$Title" width="100" height="100" /><% end_loop %></a></li><% end_if %>
	<%  ### UPGRADE_REQUIRED   use end_loop OR end_with ###%>
	</ul>

</div>
<% end_if %>

