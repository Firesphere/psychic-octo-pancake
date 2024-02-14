<ul $AttributesHTML>
    <% if $Options.Count %>
        <% loop $Options %>
            <li class="$Class" role="$Role">
                <input id="$ID" class="checkbox form-check-input" name="$Name" type="checkbox" value="$Value.ATT"<% if $isChecked %>
                       checked="checked"<% end_if %><% if $isDisabled %> disabled="disabled"<% end_if %> />
                <label for="$ID" class="form-check-label">$Title</label>
            </li>
        <% end_loop %>
    <% else %>
        <li><%t SilverStripe\\Forms\\CheckboxSetField_ss.NOOPTIONSAVAILABLE 'No options available' %></li>
    <% end_if %>
</ul>
