<% if MyChildGalleries %>
<ul id="Galleries">
	<% loop ### with MyChildGalleries %>
		<li class="$FirstLast $EvensOdd $LinkingMode">
			<% if ImageGalleryEntries %>
				<a href="$Link">
				<% loop ### with ImageGalleryEntries.First %>
				<% loop ### with Image %>
					<img src="$CroppedImage(100,100).Link" title="$Title" alt="$Title" width="100" height="100" />
				<%  ### UPGRADE_REQUIRED   use end_loop OR end_with ###%><%  ### UPGRADE_REQUIRED   use end_loop OR end_with ###%>
				</a>
			<% end_if %>
			<div class="details">
				<h3><a href="$Link">$Title</a></h3>
				<div class="contentSummary">$Content.Summary</div>
			</div>
		</li>
	<%  ### UPGRADE_REQUIRED   use end_loop OR end_with ###%>
</ul>
<% end_if %>
