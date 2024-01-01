<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>

	<p id="{$FormName}_error" class="message $MessageType <% if not $Message %>d-none<% end_if %>">$Message</p>

	<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>
		<% loop $Fields %>
			$FieldHolder
		<% end_loop %>
		<div class="clear"><!-- --></div>
	</fieldset>

	<% if $Actions %>
	<div class="btn-toolbar justify-content-between">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
