<div id="$HolderID" class="field py-2 col-md">
	$Field
    <label class="form-check-label" for="$ID">$Title<% if $RightTitle %> $RightTitle<% end_if %></label>
	<% if $Message %><div class="message invalid-feedback">$Message</div><% end_if %>
	<% if $Description %><div class="description">$Description</div><% end_if %>
</div>
