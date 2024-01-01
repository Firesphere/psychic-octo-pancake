<div id="$HolderID" class="field form-group py-1">
	<% if $Title %><label class="left col-form-label" for="$ID">$Title</label><% end_if %>
		$Field
	<% if $RightTitle %><label class="right" for="$ID">$RightTitle</label><% end_if %>
	<% if $Message %><div class="message $MessageType">$Message</div><% end_if %>
	<% if $Description %><div class="description">$Description</div><% end_if %>
</div>
