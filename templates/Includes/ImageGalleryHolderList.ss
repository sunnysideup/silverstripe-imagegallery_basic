<% if MyChildGalleries %>
<ul id="Galleries">
	<% control MyChildGalleries %>
		<li class="$FirstLast $EvensOdd $LinkingMode">
			<% if ImageGalleryEntries %>
				<a href="$Link">
				<% control ImageGalleryEntries.First %>
				<% control Image %>
					<img src="$CroppedImage(100,100).Link" title="$Title" alt="$Title" width="100" height="100" />
				<% end_control %><% end_control %>
				</a>
			<% end_if %>
			<div class="details">
				<h3><a href="$Link">$Title</a></h3>
				<div class="contentSummary">$Content.Summary</div>
			</div>
		</li>
	<% end_control %>
</ul>
<% end_if %>
