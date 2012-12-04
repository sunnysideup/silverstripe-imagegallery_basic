<% if ImageGalleryEntries %>
<div id="ImageGalleryEntriesOuter">
	<ul id="ImageGalleryEntriesUL">
	<% control ImageGalleryEntries %>
		<% if Image %><li class="$EvenOdd $FirstLast IGE{$Pos}"><a href="$Image.URL" rel="prettyPhoto[$URLSegment]"><% control Image %><img src="$CroppedImage(100,100).Link" title="$Title" alt="$Title" width="100" height="100" /><% end_control %></a></li><% end_if %>
	<% end_control %>
	</ul>

</div>
<% end_if %>

