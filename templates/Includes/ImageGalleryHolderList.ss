<% if MyChildGalleries %>
<ul id="Galleries">
	<% loop MyChildGalleries %>
		<li class="$FirstLast $EvensOdd $LinkingMode">
			<% if ImageGalleryEntries %>
				<a href="$Link">
				<% loop ImageGalleryEntries.First %>
				<% with Image %>
					<img src="$CroppedImage(100,100).Link" title="$Title" alt="$Title" width="100" height="100" />
				<%  end_with %><%  end_loop %>
				</a>
			<% end_if %>
			<div class="details">
				<h3><a href="$Link">$Title</a></h3>
				<div class="contentSummary">$Content.Summary</div>
			</div>
		</li>
	<% end_loop %>
</ul>
<% end_if %>
