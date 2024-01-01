<div class="py-3">
    <% if $UseButtonTag %>
        <button $AttributesHTML.addExtraClass('btn btn-outline-primary')>
            <% if $ButtonContent %>$ButtonContent<% else %><span>$Title.XML</span><% end_if %>
        </button>
    <% else %>
        <input $AttributesHTML />
    <% end_if %>
</div>