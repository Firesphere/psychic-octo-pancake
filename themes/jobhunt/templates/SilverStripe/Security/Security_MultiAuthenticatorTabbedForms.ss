<ul class="nav nav-pills btn-group shadow-none bg-transparent" role="tablist">
    <% loop $Forms %>
        <li class="nav-item" role="presentation">
            <a class="rounded-5 nav-link btn btn-outline-light <% if $First %>active<% end_if %>"
               data-bs-toggle="tab"
               href="#{$FormName}"
               aria-selected="<% if $First %>true<% else %>false<% end_if %>"
               role="tab">
                $AuthenticatorName
            </a>
        </li>
    <% end_loop %>
</ul>

<div class="tab-content py-5">
    <% loop $Forms %>
    <div class="bg-opacity-25 tab-pane fade <% if $First %>active<% end_if %> show" id="$FormName" role="tabpanel">
            <h3>$AuthenticatorName</h3>
            $forTemplate
        </div>
    <% end_loop %>
</div>
