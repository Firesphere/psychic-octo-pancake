<div class="fieldholder-small field-group" id="$HolderID.ATT">
	<% if $Title %><label class="col-sm-2 col-form-label" <% if $ID %>for="$ID"<% end_if %>>$Title</label><% end_if %>
	$Field
	<% if $RightTitle %><label class="form-text text-muted" <% if $ID %>for="$ID"<% end_if %>>$RightTitle</label><% end_if %>
</div>
