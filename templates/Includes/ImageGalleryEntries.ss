<% if ImageGalleryEntries %>
<div id="ImageGalleryEntriesOuter">
    <ul id="ImageGalleryEntriesUL">
    <% loop ImageGalleryEntries %>
        <% if Image %><li class="$EvenOdd $FirstLast IGE{$Pos}"><a href="$Image.Link" rel="prettyPhoto[$URLSegment]"><% with Image %><img src="$Fill(100,100).Link" title="$BestTitle.ATT" alt="$BestTitle.ATT" width="100" height="100" /><% end_with %></a></li><% end_if %>
    <% end_loop %>
    </ul>

</div>
<% end_if %>
