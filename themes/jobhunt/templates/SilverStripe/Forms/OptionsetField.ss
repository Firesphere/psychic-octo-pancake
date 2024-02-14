<ul $AttributesHTML>
    <% loop $Options %>
        <div $Up.addExtraClass("form-check-input").AttributesHTML>
            <input id="$ID" class="radio form-check-input btn-check" name="$Name" type="radio" value="$Value"<% if $isChecked %>
                   checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
            <label class="form-check-label btn
            <% if $Value == 1 %>
                btn-outline-danger
            <% else_if $Value == 2 %>
                btn-outline-warning
            <% else_if $Value == 3 %>
                btn-outline-primary
            <% else_if $Value == 4 %>
                btn-outline-info
            <% else_if $Value == 5 %>
                btn-outline-success
            <% else %>
                btn-outline-secondary
            <% end_if %>
            " for="$ID">
                $Title
            </label>
        </div>
    <% end_loop %>
</ul>
